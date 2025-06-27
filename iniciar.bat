@echo off
echo Iniciando Sistema de Funcionarios...
echo.

echo Verificando XAMPP...
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe" >NUL
if "%ERRORLEVEL%"=="0" (
    echo Apache OK
) else (
    echo Apache nao esta rodando. Inicie o XAMPP primeiro!
    pause
    exit /b 1
)

tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe" >NUL
if "%ERRORLEVEL%"=="0" (
    echo MySQL OK
) else (
    echo MySQL nao esta rodando. Inicie o XAMPP primeiro!
    pause
    exit /b 1
)

echo.
echo Navegando para projeto...
cd /d "C:\xampp\htdocs\teste_tecnico\sistema-funcionarios"

echo.
echo Verificando banco...
C:\xampp\mysql\bin\mysql.exe -u root -e "USE sistema_funcionarios;" 2>NUL
if %ERRORLEVEL% neq 0 (
    echo Criando banco...
    C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE sistema_funcionarios;"
)

echo.
echo Executando migrations...
php artisan migrate --force

echo.
echo Executando seeders...
php artisan db:seed --force

echo.
echo Iniciando servidor...
echo.
echo ================================
echo  Sistema iniciado com sucesso!
echo ================================
echo.
echo Acesse: http://localhost:8000
echo.
echo Pressione Ctrl+C para parar o servidor
echo.

php artisan serve
