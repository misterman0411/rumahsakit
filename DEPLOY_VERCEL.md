# Deploy `rumahsakit` ke Vercel

Panduan ini menggantikan `DEPLOY_RAILWAY.md` (arsip — Railway setup tidak dipakai lagi).

## Stack Production

| Komponen | Provider | Alasan |
|----------|----------|--------|
| Hosting | Vercel Serverless | Auto-scaling, CDN global, free tier generous |
| PHP runtime | `vercel-php@0.9.0` (community) | Satu-satunya runtime PHP mature di Vercel |
| Database | TiDB Cloud Serverless (MySQL 8.0 compatible) | Free tier tanpa kartu kredit, MySQL-compatible, serverless auto-scale |
| File storage | Vercel Blob | Native integration, ideal untuk upload radiologi |
| Cache/Session/Queue | `database` driver | Konsisten dengan TiDB, tidak butuh Redis |
| Cron | Vercel Cron | Replace `schedule:run` di Railway |
| Logging | stderr (auto-captured Vercel) | Tidak ada persistent log file di filesystem |

---

## Prasyarat

- [Akun Vercel](https://vercel.com/signup) (gratis)
- [Akun TiDB Cloud](https://tidbcloud.com/free-tier) (gratis, **tidak butuh kartu kredit**)
- Repo ini sudah ter-connect ke GitHub/GitLab/Bitbucket
- Local punya `php`, `composer`, `node`, `npm` (untuk build assets)

---

## 1. Buat Database di TiDB Cloud Serverless

TiDB Cloud Serverless adalah **MySQL 8.0 compatible** dengan free tier yang generous (5GB storage, 50M Request Units/bulan) — **tidak butuh kartu kredit**, jadi lebih mudah dibanding PlanetScale yang sudah discontinue free tier.

1. Login ke [tidbcloud.com](https://tidbcloud.com) (sign up dengan Google/GitHub)
2. **Create Cluster** → pilih **Serverless** (bukan Dedicated)
3. Setting:
   - **Cluster Name**: `rumahsakit-prod`
   - **Region**: `Singapore (ap-southeast-1)` recommended untuk latency Indonesia
   - **Tier**: `Free` (default untuk Serverless)
4. Klik **Create Cluster** (provisining ~30 detik)
5. Setelah cluster ready, klik **Connect** di kanan atas:
   - **Connection Type**: `General` (standard MySQL driver)
   - **Operating System**: `Linux`
   - Copy **Connect with...** string untuk **MySQL CLI** — bentuknya:
     ```
     mysql --connect-timeout 15 -u USERNAME -h HOST.tidbcloud.com -P 4000 -p DATABASE
     ```
   - Catat:
     - `HOST` (contoh: `gateway.tidbcloud.com`)
     - `PORT` = `4000` (default TiDB Cloud, **bukan 3306**)
     - `USERNAME` (format: `<username>.root`)
     - `PASSWORD` (generate baru atau pakai default)
     - `DATABASE` (default `test`, rename ke `hospital_db`)

6. (Opsional tapi recommended) Rename database default ke nama yang lebih deskriptif:
   ```sql
   CREATE DATABASE hospital_db;
   -- Opsional: drop database 'test' setelah migrate
   ```

> ⚠️ **SSL Wajib**: TiDB Cloud Serverless **wajib** pakai TLS. Sertifikat CA Let's Encrypt (`isrgrootx1.pem`) sudah ada di `/etc/ssl/cert.pem` di Vercel. Config `database.php` otomatis mendeteksi path ini (Linux) atau fallback ke `storage/certs/isrgrootx1.pem` (bundled). Tidak perlu set env var `MYSQL_ATTR_SSL_CA` kecuali pakai custom CA.

> ✅ **Foreign keys tetap aktif** di TiDB Cloud Serverless — beda dari PlanetScale yang disable FK. Migration Laravel akan jalan normal tanpa warning.

---

## 2. Buat Vercel Blob Store

> Langkah ini bisa juga dilakukan **setelah import project** di Vercel, di tab Storage.

1. Login ke Vercel → klik project rumahsakit (atau buat dulu di langkah 3)
2. Tab **Storage** → **Create Database** → pilih **Blob**
3. Nama: `rumahsakit-files`
4. Region: pilih yang sama dengan function (default `iad1`, atau `sin1` untuk latency Asia)
5. Klik **Create**
6. Setelah dibuat, Vercel otomatis inject env var `BLOB_READ_WRITE_TOKEN` ke project — tidak perlu copy manual

---

## 3. Import Project ke Vercel

1. Login ke [vercel.com/new](https://vercel.com/new)
2. **Import Git Repository** → pilih repo `rumahsakit`
3. Configure Project:
   - **Project Name**: `rumahsakit` (atau subdomain pilihan)
   - **Framework Preset**: `Other`
   - **Build Command**: (kosongkan — sudah di `vercel.json`)
   - **Output Directory**: (kosongkan — sudah `public`)
   - **Install Command**: (kosongkan)
4. Klik **Deploy** (akan gagal di step ini karena env belum di-set, normal)

---

## 4. Set Environment Variables

Di Vercel dashboard → Project → **Settings** → **Environment Variables**, isi:

| Key | Value | Catatan |
|-----|-------|---------|
| `APP_ENV` | `production` | |
| `APP_DEBUG` | `false` | |
| `APP_KEY` | `base64:...` | Generate: `php artisan key:generate --show` |
| `APP_URL` | `https://rumahsakit.vercel.app` | Sesuaikan dengan project URL |
| `DB_CONNECTION` | `mysql` | TiDB Cloud pakai MySQL protocol |
| `DB_HOST` | `gateway.tidbcloud.com` | Dari TiDB Cloud Connect dialog |
| `DB_PORT` | `4000` | **Bukan 3306** — TiDB Cloud Serverless default port |
| `DB_DATABASE` | `hospital_db` | Atau nama lain yang dibuat di langkah 1 |
| `DB_USERNAME` | `<user>.root` | Dari TiDB Cloud (ada suffix `.root`) |
| `DB_PASSWORD` | `...` | Dari TiDB Cloud |
| `SESSION_DRIVER` | `cookie` | Stateless, tidak butuh server storage |
| `CACHE_STORE` | `database` | Tabel `cache` sudah ada di migration |
| `QUEUE_CONNECTION` | `database` | Tabel `jobs` sudah ada (migration baru) |
| `LOG_CHANNEL` | `stderr` | Captured otomatis oleh Vercel |
| `FILESYSTEM_DISK` | `vercel-blob` | Untuk upload radiology |
| `BLOB_READ_WRITE_TOKEN` | (auto) | Auto-inject saat Blob dibuat di langkah 2 |
| `CRON_SECRET` | (random 32 char) | Generate: `openssl rand -hex 32` |
| `MIDTRANS_MERCHANT_ID` | `G...` | Production merchant ID |
| `MIDTRANS_CLIENT_KEY` | `Mid-client-...` | Production key |
| `MIDTRANS_SERVER_KEY` | `Mid-server-...` | Production server key |
| `MIDTRANS_IS_PRODUCTION` | `true` | |
| `MAIL_MAILER` | `smtp` | Setup provider (Resend/Postmark) |

> **APP_KEY penting**: JANGAN gunakan key dari `.env` lokal. Generate baru untuk production.
> Untuk cek nilai tanpa menyimpan: `php artisan key:generate --show`

---

## 5. Jalankan Migration (Sekali Saja)

Vercel tidak punya shell persistent, jadi migration dijalankan dari **local** dengan mengarahkan ke database production.

```bash
# Export credentials TiDB Cloud ke environment lokal
export DB_HOST="gateway.tidbcloud.com"
export DB_PORT="4000"
export DB_DATABASE="hospital_db"
export DB_USERNAME="..."
export DB_PASSWORD="..."
export DB_CONNECTION="mysql"

# MYSQL_ATTR_SSL_CA tidak perlu di-set — config otomatis detect path
# yang sesuai (storage/certs/isrgrootx1.pem di Windows, /etc/ssl/cert.pem di Linux)

# Jalankan migration
php artisan migrate --force
```

Atau via Vercel CLI:
```bash
vercel env pull .env.production
vercel exec php artisan migrate --force
```

---

## 6. Seed Data (Opsional)

```bash
php artisan db:seed --force
```

Atau gunakan seeder spesifik untuk akun demo:
```bash
php artisan db:seed --class=DatabaseSeederNew --force
```

Akun default ada di file `LOGIN_CREDENTIALS.md`.

---

## 7. Deploy Ulang

Setelah env vars dan database siap:

```bash
git add vercel.json api/ .vercelignore config/vercel_blob.php config/filesystems.php \
        app/Services/VercelBlobStorage.php app/Providers/AppServiceProvider.php \
        app/Http/Controllers/RadiologyController.php app/Http/Controllers/CronController.php \
        app/Models/RadiologyOrder.php resources/views/radiology/ \
        database/migrations/2026_01_15_030000_create_jobs_table.php \
        routes/web.php routes/console.php .env.example DEPLOY_VERCEL.md
git commit -m "feat: Vercel deployment setup with TiDB Cloud and Vercel Blob"
git push origin main
```

Vercel akan auto-deploy dalam ~1-2 menit. Cek progress di **Deployments** tab.

---

## 8. Verifikasi

Setelah deploy sukses:

1. **Buka URL Vercel** → harusnya muncul halaman login (bukan error 500)
2. **Login** dengan akun seeder → cek Vercel function logs untuk query MySQL:
   ```bash
   vercel logs --follow
   ```
3. **CSS/JS load** → inspect browser devtools, tidak ada 404 untuk `/build/*`
4. **Upload radiology image** → cek [Vercel Blob dashboard](https://vercel.com/dashboard) → tab Storage → `rumahsakit-files` → file muncul dengan public URL
5. **Test cron harian**:
   ```bash
   curl -H "Authorization: Bearer $CRON_SECRET" https://rumahsakit.vercel.app/api/cron/charge-rooms
   ```
   Harusnya return JSON `{ "status": "ok", ... }`. Cek di logs bahwa `inpatient:charge-rooms-daily` jalan.

---

## Troubleshooting

### Error 500 saat homepage load

Lihat logs di Vercel dashboard → Functions → klik function → Logs tab. Biasanya:

- **`MissingAppKeyException`** → `APP_KEY` belum di-set atau salah
- **`SQLSTATE[HY000] [2002]`** → `DB_HOST` salah atau SSL required (cek `MYSQL_ATTR_SSL_CA` di `config/database.php`)
- **`Class "VercelBlobStorage" not found`** → composer autoload belum refresh; trigger redeploy atau `composer dump-autoload`

### Static asset 404 (CSS/JS)

Cek bahwa `npm run build` sukses di build logs. Vercel hanya serve file di `public/build/` yang sudah ada saat build.

### Upload radiology gagal

Pastikan `BLOB_READ_WRITE_TOKEN` ter-inject. Cek di tab Storage → klik Blob store → Connection String. Bandingkan dengan env var di Settings → Environment Variables.

### Cron tidak jalan

Cek tab **Crons** di project settings — jadwal `1 0 * * *` di vercel.json berarti jalan tiap hari jam 00:01 UTC. Test manual via curl seperti di langkah 8.5.

### Migration error di TiDB Cloud

TiDB Cloud Serverless pakai MySQL 8.0 syntax — semua migration Laravel seharusnya jalan normal. Kalau ada error:
- **SSL error** → pastikan `MYSQL_ATTR_SSL_CA=/etc/ssl/cert.pem` ter-set
- **Connection timeout** → cek `DB_PORT=4000` (bukan 3306)
- **Unknown database** → cek `DB_DATABASE` sesuai nama yang dibuat di langkah 1

---

## Maintenance

### Update aplikasi

```bash
git add -A
git commit -m "..."
git push  # Vercel auto-deploy
```

### Rollback deploy

Di Vercel dashboard → tab **Deployments** → klik deployment sebelumnya → **Promote to Production**.

### Lihat logs real-time

```bash
vercel logs --follow --prod
```

Atau di dashboard → Project → Logs.

### Backup database

TiDB Cloud Serverless free tier tidak include automatic backup. Export manual via mysqldump:

```bash
mysqldump --ssl-mode=REQUIRED -h $DB_HOST -P 4000 -u $DB_USERNAME -p $DB_DATABASE > backup-$(date +%Y%m%d).sql
```

Atau pakai TiDB Cloud UI → cluster → **Backup** tab (untuk paid tier).

---

## Catatan Migrasi dari Railway

Perubahan yang dilakukan saat migrasi:

1. **Procfile / nixpacks.toml** → tidak dipakai lagi, abaikan. Boleh dihapus atau di-archive.
2. **`server.php`** → tidak dipakai lagi. Fungsi static-file serving di-handle Vercel routes.
3. **`SESSION_DRIVER=file` → `cookie`** → session tidak lagi disimpan di server.
4. **`FILESYSTEM_DISK=local` → `vercel-blob`** → upload radiology masuk Vercel Blob.
5. **Schedule `inpatient:charge-rooms-daily`** → pindah ke Vercel Cron.
6. **APP_KEY rotation** → generate baru untuk production.

File konfigurasi lama tetap di repo tapi tidak dipakai saat deploy ke Vercel.
