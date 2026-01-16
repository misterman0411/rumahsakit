# Script untuk setup dan menjalankan ngrok
# Pastikan Anda sudah memasukkan authtoken terlebih dahulu

param(
    [string]$authtoken = ""
)

$ngrokPath = "E:\laragon\bin\ngrok\ngrok.exe"
$projectPath = "E:\laragon\www\rumahsakit"

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Setup ngrok untuk Rumah Sakit App" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Cek apakah ngrok ada
if (-not (Test-Path $ngrokPath)) {
    Write-Host "Error: ngrok tidak ditemukan di $ngrokPath" -ForegroundColor Red
    exit 1
}

# Setup authtoken jika diberikan
if ($authtoken -ne "") {
    Write-Host "Mengatur authtoken..." -ForegroundColor Yellow
    & $ngrokPath config add-authtoken $authtoken
    Write-Host "Authtoken berhasil diatur!" -ForegroundColor Green
    Write-Host ""
}

# Cek apakah authtoken sudah diatur
$configCheck = & $ngrokPath config check 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "  AUTHTOKEN BELUM DIATUR!" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Cara mendapatkan authtoken:" -ForegroundColor Yellow
    Write-Host "1. Buka: https://dashboard.ngrok.com/signup" -ForegroundColor White
    Write-Host "2. Daftar atau login" -ForegroundColor White
    Write-Host "3. Copy authtoken dari: https://dashboard.ngrok.com/get-started/your-authtoken" -ForegroundColor White
    Write-Host ""
    Write-Host "Jalankan script dengan authtoken:" -ForegroundColor Yellow
    Write-Host "  .\ngrok-setup.ps1 -authtoken YOUR_TOKEN_HERE" -ForegroundColor White
    Write-Host ""
    exit 1
}

Write-Host "Konfigurasi ngrok valid!" -ForegroundColor Green
Write-Host ""
Write-Host "Menjalankan ngrok..." -ForegroundColor Yellow
Write-Host "Tekan Ctrl+C untuk menghentikan" -ForegroundColor Yellow
Write-Host ""

# Jalankan ngrok
Set-Location $projectPath
& $ngrokPath http rumahsakit.test:80 --host-header=rumahsakit.test
