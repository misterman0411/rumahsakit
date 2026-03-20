# 🚀 Deploy Rumah Sakit ke Railway

## Prasyarat
- Akun GitHub (repo project sudah di-push)
- Akun Railway: [railway.app](https://railway.app) (login pakai GitHub)

---

## Langkah Deploy

### 1. Push Project ke GitHub
Pastikan semua perubahan sudah di-commit dan di-push:
```bash
git add .
git commit -m "feat: add Railway deployment configuration"
git push origin main
```

### 2. Buat Project di Railway
1. Buka [railway.app](https://railway.app) → **New Project**
2. Pilih **Deploy from GitHub repo**
3. Pilih repo `rumahsakit` → klik **Deploy Now**
4. Railway akan otomatis mendeteksi `nixpacks.toml` dan mulai build

### 3. Tambahkan MySQL Database
1. Di dashboard project Railway, klik **+ New** → **Database** → **MySQL**
2. Railway akan otomatis membuat database dan menambahkan env variables berikut ke project:
   - `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`

### 4. Set Environment Variables
Di Railway dashboard → pilih service app kamu → tab **Variables** → klik **Raw Editor**, lalu paste ini (sesuaikan nilai yang diperlukan):

```env
APP_NAME=Rumah Sakit
APP_ENV=production
APP_KEY=                        ← Isi hasil: php artisan key:generate --show
APP_DEBUG=false
APP_URL=                        ← Isi setelah dapat URL dari Railway (langkah 5)

APP_LOCALE=id
APP_FALLBACK_LOCALE=id

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@rumahsakit.app
MAIL_FROM_NAME=Rumah Sakit
```

> **Untuk `APP_KEY`**: jalankan perintah berikut di komputer lokal, lalu copy hasilnya:
> ```bash
> php artisan key:generate --show
> ```

### 5. Dapatkan URL Publik
1. Di Railway dashboard → tab **Settings** → bagian **Domains**
2. Klik **Generate Domain** → Railway memberi URL seperti: `https://rumahsakit-production.up.railway.app`
3. Copy URL tersebut, lalu update `APP_URL` di Variables

### 6. Redeploy
Setelah semua variabel diset, klik **Deploy** ulang agar konfigurasi terbaru dipakai.

---

## ✅ Verifikasi Deploy Berhasil

Di Railway dashboard → tab **Logs**, periksa apakah:
- Build berhasil (✓ Nixpacks build complete)
- Migrasi berjalan (`Migration table created`, `Migrated: xx_buat_tabel_users`)
- Server berjalan (`PHP Development Server started`)

Lalu buka URL publik di browser.

---

## 🔁 Alur Update Kode (Setelah Deploy Pertama)

Setiap kali push ke GitHub → Railway otomatis build ulang & deploy (CI/CD otomatis).

```
Edit kode lokal
   ↓
git add . && git commit -m "update"
   ↓
git push origin main
   ↓
Railway auto-deploy ✅
```

---

## 🗄️ Jalankan Seeder (Opsional)

Jika ingin mengisi data awal (admin, dll), buka tab **Shell** di Railway dashboard:
```bash
php artisan db:seed --force
```

---

## ❓ Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Build gagal di `npm run build` | Cek error di build log, pastikan `package.json` lengkap |
| `APP_KEY` tidak valid | Generate ulang dengan `php artisan key:generate --show` |
| Database connection error | Pastikan env variables MySQL sudah ada di Railway Variables tab |
| 500 Server Error | Set `APP_DEBUG=true` sementara untuk melihat error detail |
| Storage/File permission error | Jalankan `php artisan storage:link` via Shell di Railway |

---

## 📞 Resources

- Railway Dashboard: [railway.app](https://railway.app)
- Railway Docs: [docs.railway.app](https://docs.railway.app)
- Laravel Deployment: [laravel.com/docs/deployment](https://laravel.com/docs/deployment)
