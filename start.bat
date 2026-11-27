@echo off
rem Arranca MyMind con el servidor integrado de PHP (XAMPP). Abre http://localhost:8000
cd /d "%~dp0"
"C:\xampp\php\php.exe" -S localhost:8000 -t public
