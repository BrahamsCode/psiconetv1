@echo off
REM Script de Inicialización de PSICONET V1 con SQLite (Windows)
REM ============================================================

echo.
echo ===============================================
echo    PSICONET V1 - Inicializando SQLite
echo ===============================================
echo.

REM Verificar si estamos en un proyecto Laravel
if not exist "artisan" (
    echo [ERROR] Este script debe ejecutarse desde la raiz del proyecto Laravel
    pause
    exit /b 1
)

REM Crear directorio database si no existe
echo [*] Verificando estructura de directorios...
if not exist "database" mkdir database

REM Crear archivo SQLite si no existe
if not exist "database\database.sqlite" (
    echo [*] Creando archivo database.sqlite...
    type nul > "database\database.sqlite"
    echo [OK] Archivo database.sqlite creado
) else (
    echo [OK] El archivo database.sqlite ya existe
)

echo.
echo [*] Configuracion de .env detectada:
echo     DB_CONNECTION=sqlite
echo.

REM Ejecutar migraciones
echo [*] Ejecutando migraciones...
php artisan migrate

if %ERRORLEVEL% EQU 0 (
    echo.
    echo [OK] Base de datos inicializada correctamente
    echo.
    echo [*] Estadisticas de la base de datos:
    php artisan db:show
    echo.
    echo ===============================================
    echo    Sistema listo para usar!
    echo ===============================================
    echo.
    echo Para iniciar el servidor:
    echo   php artisan serve
    echo.
) else (
    echo.
    echo [ERROR] Error al ejecutar las migraciones
    echo Revisa los mensajes de error anteriores
    pause
    exit /b 1
)

pause
