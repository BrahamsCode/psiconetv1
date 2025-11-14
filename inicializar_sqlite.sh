#!/bin/bash

# Script de Inicialización de PSICONET V1 con SQLite
# ====================================================

echo "🏥 PSICONET V1 - Inicializando Base de Datos SQLite"
echo "=================================================="
echo ""

# Verificar si estamos en un proyecto Laravel
if [ ! -f "artisan" ]; then
    echo "❌ Error: Este script debe ejecutarse desde la raíz del proyecto Laravel"
    exit 1
fi

# Crear directorio database si no existe
echo "📁 Verificando estructura de directorios..."
mkdir -p database

# Crear archivo SQLite si no existe
if [ ! -f "database/database.sqlite" ]; then
    echo "📄 Creando archivo database.sqlite..."
    touch database/database.sqlite
    chmod 664 database/database.sqlite
    echo "✅ Archivo database.sqlite creado"
else
    echo "✅ El archivo database.sqlite ya existe"
fi

echo ""
echo "🔧 Configuración de .env detectada:"
echo "   DB_CONNECTION=sqlite"
echo ""

# Verificar si hay migraciones pendientes
echo "🔄 Ejecutando migraciones..."
php artisan migrate

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Base de datos inicializada correctamente"
    echo ""
    echo "📊 Estadísticas de la base de datos:"
    php artisan db:show
    echo ""
    echo "🎉 ¡Sistema listo para usar!"
    echo ""
    echo "Para iniciar el servidor:"
    echo "  php artisan serve"
else
    echo ""
    echo "❌ Error al ejecutar las migraciones"
    echo "Revisa los mensajes de error anteriores"
    exit 1
fi
