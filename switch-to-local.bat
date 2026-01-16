@echo off
echo Switching to LOCAL mode...
echo.

cd /d E:\laragon\www\rumahsakit

powershell -Command "(Get-Content .env) -replace 'APP_URL=.*', 'APP_URL=http://rumahsakit.test' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'ASSET_URL=.*', 'ASSET_URL=' | Set-Content .env"

E:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.exe artisan config:clear
E:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.exe artisan cache:clear

echo.
echo ========================================
echo   Switched to LOCAL mode
echo   Access: http://rumahsakit.test
echo ========================================
pause
