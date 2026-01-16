# Setup ngrok untuk Rumah Sakit App

## 📋 Prasyarat
- Laragon sudah terinstall dan berjalan
- Aplikasi rumahsakit berjalan di `rumahsakit.test`
- ngrok sudah terinstall di `E:\laragon\bin\ngrok\`

## 🚀 Cara Setup

### 1. Dapatkan Authtoken
1. Kunjungi: https://dashboard.ngrok.com/signup
2. Daftar menggunakan email atau akun Google/GitHub (GRATIS)
3. Setelah login, buka: https://dashboard.ngrok.com/get-started/your-authtoken
4. Copy authtoken yang ditampilkan (format: `2xxxxxxxxxxxxxxxxxxxxxxxxxxxxx`)

### 2. Setup Authtoken

**Opsi A: Menggunakan Script PowerShell**
```powershell
.\ngrok-setup.ps1 -authtoken YOUR_TOKEN_HERE
```

**Opsi B: Manual**
```powershell
E:\laragon\bin\ngrok\ngrok.exe config add-authtoken YOUR_TOKEN_HERE
```

### 3. Jalankan ngrok

**Menggunakan Script (Recommended):**
```powershell
.\ngrok-setup.ps1
```

**Manual:**
```powershell
E:\laragon\bin\ngrok\ngrok.exe http rumahsakit.test:80 --host-header=rumahsakit.test
```

### 4. Update Laravel Config

Setelah ngrok berjalan, Anda akan mendapat URL seperti:
```
https://xxxx-xxx-xxx-xxx-xxx.ngrok-free.app
```

Update file `.env`:
```env
APP_URL=https://xxxx-xxx-xxx-xxx-xxx.ngrok-free.app
```

Kemudian jalankan:
```powershell
php artisan config:cache
```

## 🔧 Troubleshooting

### Error: authentication failed
- Pastikan authtoken sudah diatur dengan benar
- Cek di `%USERPROFILE%\.ngrok2\ngrok.yml` apakah authtoken ada

### Error: tunnel tidak bisa diakses
- Pastikan Laragon Apache sedang berjalan
- Pastikan `rumahsakit.test` bisa diakses di browser lokal
- Gunakan parameter `--host-header=rumahsakit.test`

### Session expired (free plan)
- ngrok free plan membatasi durasi session 2 jam
- Restart ngrok setelah session expired
- Upgrade ke paid plan untuk unlimited session

## 📱 Akses dari Internet

Setelah ngrok berjalan, aplikasi dapat diakses dari:
- URL yang diberikan ngrok (https://xxx.ngrok-free.app)
- Bisa dibuka di HP/device lain
- Cocok untuk testing/demo

## 🎯 Tips
- Gunakan ngrok web interface di http://localhost:4040 untuk monitoring
- Copy URL ngrok dan share ke teman/klien untuk demo
- Untuk production, gunakan domain dan hosting proper

## 🔗 Link Berguna
- Dashboard ngrok: https://dashboard.ngrok.com
- Dokumentasi: https://ngrok.com/docs
- Status: https://status.ngrok.com
