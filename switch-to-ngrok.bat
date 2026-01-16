@echo off
echo Getting ngrok URL...
echo.

cd /d E:\laragon\www\rumahsakit

REM Get ngrok URL from API
for /f "tokens=*" %%i in ('powershell -Command "try { $response = Invoke-RestMethod -Uri 'http://127.0.0.1:4040/api/tunnels' -ErrorAction Stop; $url = $response.tunnels[0].public_url; Write-Output $url } catch { Write-Output 'ERROR' }"') do set NGROK_URL=%%i

if "%NGROK_URL%"=="ERROR" (
    echo ngrok is not running! Please start ngrok first.
    echo Run: start-ngrok.bat
    pause
    exit /b 1
)

echo Found ngrok URL: %NGROK_URL%
echo.
echo Updating .env file...

powershell -Command "(Get-Content .env) -replace 'APP_URL=.*', 'APP_URL=%NGROK_URL%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'ASSET_URL=.*', 'ASSET_URL=%NGROK_URL%' | Set-Content .env"

E:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.exe artisan config:clear
E:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.exe artisan cache:clear

echo.
echo ========================================
echo   Switched to NGROK mode
echo   Access: %NGROK_URL%
echo ========================================
pause
