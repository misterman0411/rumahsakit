@echo off
REM Batch file untuk menjalankan ngrok dengan mudah

echo ========================================
echo   Rumah Sakit App - ngrok Launcher
echo ========================================
echo.

cd /d E:\laragon\www\rumahsakit

REM Cek apakah PowerShell execution policy mengizinkan script
powershell -ExecutionPolicy Bypass -File ".\ngrok-setup.ps1"

pause
