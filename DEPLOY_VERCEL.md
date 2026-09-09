# Deploy `rumahsakit` ke Vercel

Panduan ini menggantikan `DEPLOY_RAILWAY.md` (arsip — Railway setup tidak dipakai lagi).

## Stack Production

| Komponen | Provider | Alasan |
|----------|----------|--------|
| Hosting | Vercel Serverless | Auto-scaling, CDN global, free tier generous |
| PHP runtime | `vercel-php@0.9.0` (community) | Satu-satunya runtime PHP mature di Vercel |
| Database | PlanetScale MySQL | Free 5GB, MySQL-compatible, branch-based workflow |
| File storage | Vercel Blob | Native integration, ideal untuk upload radiologi |
| Cache/Session/Queue | `database` driver | Konsisten dengan PlanetScale, tidak butuh Redis |
| Cron | Vercel Cron | Replace `schedule:run` di Railway |
| Logging | stderr (auto-captured Vercel) | Tidak ada persistent log file di filesystem |

---

## Prasyarat

- [Akun Vercel](https://vercel.com/signup) (gratis)
- [Akun PlanetScale](https://planetscale.com/signup) (gratis)
- Repo ini sudah ter-connect ke GitHub/GitLab/Bitbucket
- Local punya `php`, `composer`, `node`, `npm` (untuk build assets)

---

## 1. Buat Database di PlanetScale

1. Login ke [planetscale.com](https://planetscale.com) → New database
2. Pilih region terdekat (Singapore `ap-southeast` recommended untuk Indonesia)
3. Nama DB: `hospital-db`
4. Klik **Create database**
5. Setelah DB ready, ke tab **Branches** → klik branch `main` → **Connect** → pilih **PHP** → copy connection string:
   ```
   mysql://USERNAME:PASSWORD@HOST/DBNAME?ssl={"ssl":{"ca":"/etc/ssl/cert.pem"}}
   ```
6. Catat credentials berikut (akan dipakai di langkah 4):
   - `DB_HOST` (hostname tanpa port)
   - `DB_PORT` (default `3306`)
   - `DB_DATABASE` (nama database)
   - `DB_USERNAME` dan `DB_PASSWORD`

> ⚠️ PlanetScale **disable foreign keys** di production branch. Beberapa migration Laravel akan emit warning, bukan error — ini normal.

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
| `DB_CONNECTION` | `mysql` | |
| `DB_HOST` | `...psdb.cloud` | Dari PlanetScale |
| `DB_PORT` | `3306` | |
| `DB_DATABASE` | `hospital-db` | |
| `DB_USERNAME` | `...` | Dari PlanetScale |
| `DB_PASSWORD` | `...` | Dari PlanetScale |
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
# Export credentials PlanetScale ke environment lokal
export DB_HOST="..."
export DB_PORT="3306"
export DB_DATABASE="hospital-db"
export DB_USERNAME="..."
export DB_PASSWORD="..."
export DB_CONNECTION="mysql"

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
git commit -m "feat: Vercel deployment setup with PlanetScale and Vercel Blob"
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

### Migration error di PlanetScale

PlanetScale disable FK di production branch. Cek error message — kalau soal FK, abaikan saja (Laravel emit warning, bukan error fatal).

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

PlanetScale otomatis daily backup di paid tier. Di free tier, export manual via:

```bash
mysqldump -h $DB_HOST -u $DB_USERNAME -p $DB_DATABASE > backup.sql
```

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
