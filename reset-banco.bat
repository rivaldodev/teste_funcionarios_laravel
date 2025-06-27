@echo off
echo =====================================
echo  Reset do Banco de Dados
echo =====================================
echo.
echo ATENÇÃO: Esta operação irá:
echo - Remover todos os dados existentes
echo - Recriar as tabelas
echo - Inserir dados de teste
echo.
set /p confirm="Deseja continuar? (S/N): "
if /i "%confirm%" neq "S" (
    echo Operação cancelada.
    pause
    exit /b 0
)

echo.
echo Navegando para o diretório do projeto...
cd /d "C:\xampp\htdocs\teste_tecnico\sistema-funcionarios"

echo.
echo Resetando migrações...
php artisan migrate:fresh --seed

echo.
echo =====================================
echo  Reset concluído com sucesso!
echo =====================================
echo.
echo O banco foi resetado e os dados de teste foram inseridos.
echo.
pause
