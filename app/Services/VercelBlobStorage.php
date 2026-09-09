<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Config;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter as FlysystemAdapter;
use League\Flysystem\PathPrefixer;
use RuntimeException;

/**
 * Filesystem adapter for Vercel Blob.
 *
 * Vercel Blob ships only an official JS/Python SDK; in PHP we talk to the
 * REST API directly with cURL. The contract is intentionally minimal:
 *
 *   PUT   https://blob.vercel-storage.com/<path>     — upload (auth + body)
 *   GET   https://blob.vercel-storage.com/<path>     — fetch bytes
 *   HEAD  https://blob.vercel-storage.com/<path>     — existence
 *   DELETE https://blob.vercel-storage.com/<path>    — remove
 *
 * On PUT, Vercel returns a JSON envelope `{ "url": "https://..." }` whose URL
 * is publicly readable. We persist that URL on the model instead of the raw
 * path so views can render images without any further resolution.
 *
 * @see https://vercel.com/docs/storage/vercel-blob/using-blob-sdk
 */
class VercelBlobStorage implements FlysystemAdapter
{
    public function __construct(
        protected string $token,
        protected string $baseUrl = 'https://blob.vercel-storage.com',
    ) {
        if (empty($this->token)) {
            throw new RuntimeException(
                'Vercel Blob token is not configured. Set BLOB_READ_WRITE_TOKEN in your environment.'
            );
        }
    }

    public function getPathPrefixer(): PathPrefixer
    {
        return new PathPrefixer('', '\\');
    }

    /**
     * Write the given contents to the given path.
     *
     * @param  string  $path       Path relative to the disk root.
     * @param  string|resource  $contents
     */
    public function write(string $path, $contents, array|FlysystemAdapter $config = []): void
    {
        $this->upload($path, $contents, $this->mimeFromConfig($config));
    }

    /**
     * Upload via a streaming resource (UploadedFile / file handle).
     */
    public function writeStream(string $path, $contents, array|FlysystemAdapter $config = []): void
    {
        if (! is_resource($contents)) {
            throw new RuntimeException('writeStream requires a resource.');
        }

        $body = stream_get_contents($contents);
        $this->upload($path, (string) $body, $this->mimeFromConfig($config));
    }

    public function put(string $path, $contents, mixed $options = []): string
    {
        $response = $this->upload($path, $contents, $this->mimeFromConfig((array) $options));

        return $response['url'] ?? $this->url($path);
    }

    /**
     * Convenience for Laravel's `Storage::putFile()` / file->store() calls.
     *
     * The driver returns the *public Vercel URL* (not a relative path) so
     * views can render <img src> directly without any helper indirection.
     */
    public function putFile(string $prefix, UploadedFile|string $file, mixed $options = []): string|false
    {
        if ($file instanceof UploadedFile) {
            $name = $prefix.'/'.uniqid().'.'.$file->getClientOriginalExtension();
            $body = file_get_contents($file->getRealPath());
            $mime = $file->getMimeType() ?? 'application/octet-stream';
        } else {
            $name = $prefix.'/'.uniqid();
            $body = file_get_contents($file);
            $mime = 'application/octet-stream';
        }

        return $this->put($name, $body, ['mimetype' => $mime]);
    }

    public function read(string $path): string
    {
        $url = $this->publicUrl($path);

        $body = $this->request('GET', $url);

        if ($body === false || $body === null) {
            throw new RuntimeException("Vercel Blob GET failed for path [{$path}].");
        }

        return (string) $body;
    }

    public function readStream(string $path)
    {
        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $this->read($path));
        rewind($stream);

        return $stream;
    }

    public function fileExists(string $path): bool
    {
        return $this->exists($path);
    }

    public function directoryExists(string $path): bool
    {
        // Vercel Blob is a flat object store; directories are virtual and free.
        return true;
    }

    public function exists(string $path): bool
    {
        $url = $this->publicUrl($path);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_NOBODY         => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$this->token],
        ]);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $code >= 200 && $code < 300;
    }

    public function size(string $path): int
    {
        $url = $this->publicUrl($path);
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_NOBODY         => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$this->token],
        ]);
        curl_exec($ch);
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD) ?: 0;
        curl_close($ch);

        return (int) $size;
    }

    public function mimeType(string $path): string
    {
        return $this->getMetadata($path)['content-type'] ?? 'application/octet-stream';
    }

    /**
     * Build the public URL Vercel returns for an uploaded object.
     * Callers (views) should persist this URL, not the relative path.
     */
    public function url(string $path): string
    {
        return $this->publicUrl($path);
    }

    public function delete(string $path): void
    {
        $this->request('DELETE', $this->publicUrl($path));
    }

    public function deleteDirectory(string $prefix): void
    {
        // Vercel Blob has no concept of directory deletion.
        Log::info('VercelBlobStorage::deleteDirectory called (no-op)', ['prefix' => $prefix]);
    }

    public function createDirectory(string $path, array $config = []): void
    {
        // No-op for object storage.
    }

    public function listContents(string $path = '', bool $deep = false): iterable
    {
        // Vercel Blob REST API does not expose listing in the free tier.
        return [];
    }

    public function lastModified(string $path): int
    {
        return time();
    }

    public function visibility(string $path): string
    {
        return 'public';
    }

    public function setVisibility(string $path, string $visibility): void
    {
        // All uploaded blobs are publicly readable.
    }

    public function move(string $source, string $destination, array $config = []): void
    {
        // Read → Write → Delete. Re-uploading produces a fresh blob URL.
        $this->write($destination, $this->read($source));
        $this->delete($source);
    }

    public function copy(string $source, string $destination, array $config = []): void
    {
        $this->write($destination, $this->read($source));
    }

    public function getMetadata(string $path, string $type = 'all'): array
    {
        return [];
    }

    /**
     * Apply by Flysystem's Config DTO when callers pass one.
     *
     * @param  array|FlysystemAdapter  $config
     */
    protected function mimeFromConfig(array|Config $config): string
    {
        if ($config instanceof Config) {
            $config = $config->toArray();
        }

        return $config['mimetype'] ?? $config['mimes'] ?? 'application/octet-stream';
    }

    /**
     * Build the canonical public URL of a path within the blob store.
     */
    protected function publicUrl(string $path): string
    {
        $normalized = ltrim($path, '/');

        return rtrim($this->baseUrl, '/').'/'.$normalized;
    }

    /**
     * Upload bytes to Vercel Blob. Returns the parsed JSON response on
     * success; throws on failure (network or non-2xx).
     */
    protected function upload(string $path, string $body, string $mime): array
    {
        $url = $this->publicUrl($path);
        $payload = $this->request('PUT', $url, $body, [
            'Content-Type: '.$mime,
            'x-content-type: '.$mime,
        ]);

        return is_array($payload) ? $payload : [];
    }

    /**
     * Perform an HTTP request against the Vercel Blob REST API.
     *
     * @return array|string|bool  Parsed JSON if response looks like JSON,
     *                            raw body string otherwise, false on error.
     */
    protected function request(string $method, string $url, ?string $body = null, array $extraHeaders = [])
    {
        $headers = array_merge([
            'Authorization: Bearer '.$this->token,
        ], $extraHeaders);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        if ($body !== null && in_array(strtoupper($method), ['POST', 'PUT', 'PATCH'], true)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $response = curl_exec($ch);
        $code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            Log::error('Vercel Blob request failed', ['method' => $method, 'url' => $url, 'error' => $error]);

            return false;
        }

        if ($code >= 400) {
            Log::warning('Vercel Blob returned error', [
                'method' => $method,
                'url'    => $url,
                'code'   => $code,
                'body'   => substr((string) $response, 0, 200),
            ]);

            return false;
        }

        $decoded = json_decode((string) $response, true);

        return is_array($decoded) ? $decoded : (string) $response;
    }
}
