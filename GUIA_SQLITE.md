# PSICONET V1 - Guía de Instalación con SQLite

## 🎯 Configuración para Aplicación de Escritorio Local

Esta guía te ayudará a configurar PSICONET V1 como una aplicación de escritorio que funciona completamente en local con SQLite.

---

## ✅ Ventajas de SQLite para tu Proyecto

- ✅ **Sin servidor** - No necesitas MySQL, PostgreSQL ni Apache
- ✅ **Un solo archivo** - Toda la base de datos en `database/database.sqlite`
- ✅ **Portátil** - Copia el archivo y migra fácilmente
- ✅ **Rápido** - Excelente rendimiento para aplicaciones locales
- ✅ **Respaldos simples** - Solo copia el archivo .sqlite
- ✅ **Cero configuración** - Ya funciona con tu .env actual

---

## 📋 Pre-requisitos

1. **PHP 8.1+** instalado
2. **Composer** instalado
3. **Extensión SQLite** habilitada en PHP

### Verificar SQLite en PHP

```bash
php -m | grep sqlite
```

Deberías ver:
```
pdo_sqlite
sqlite3
```

Si no aparece, habilita en `php.ini`:
```ini
extension=pdo_sqlite
extension=sqlite3
```

---

## 🚀 Instalación Rápida

### Opción 1: Usando el Script de Inicialización

**Windows:**
```cmd
inicializar_sqlite.bat
```

**Linux/Mac:**
```bash
chmod +x inicializar_sqlite.sh
./inicializar_sqlite.sh
```

### Opción 2: Manual

```bash
# 1. Crear archivo SQLite
touch database/database.sqlite

# 2. Ejecutar migraciones
php artisan migrate

# 3. Iniciar servidor
php artisan serve
```

---

## 📝 Pasos Detallados

### 1. Verificar Configuración .env

Tu archivo `.env` ya está correcto:
```properties
DB_CONNECTION=sqlite
```

### 2. Crear Archivo de Base de Datos

```bash
touch database/database.sqlite
```

En Windows (PowerShell):
```powershell
New-Item database\database.sqlite -ItemType File
```

### 3. Copiar Migraciones

```bash
cp add_filiacion_fields_to_consultantes.php database/migrations/2024_11_09_000001_add_filiacion_fields_to_consultantes.php
cp create_historias_psicologicas_table.php database/migrations/2024_11_09_000002_create_historias_psicologicas_table.php
cp create_consumo_sustancias_table.php database/migrations/2024_11_09_000003_create_consumo_sustancias_table.php
cp create_tratamientos_previos_table.php database/migrations/2024_11_09_000004_create_tratamientos_previos_table.php
cp create_conductas_problema_table.php database/migrations/2024_11_09_000005_create_conductas_problema_table.php
cp create_evaluaciones_psicologicas_table.php database/migrations/2024_11_09_000006_create_evaluaciones_psicologicas_table.php
cp create_interconsultas_psiquiatricas_table.php database/migrations/2024_11_09_000007_create_interconsultas_psiquiatricas_table.php
```

### 4. Copiar Modelos y Controladores

```bash
# Modelos
cp Consultante_updated.php app/Models/Consultante.php
cp HistoriaPsicologica.php app/Models/
cp ConsumoSustancia.php app/Models/
cp TratamientoPrevio.php app/Models/
cp ConductaProblema.php app/Models/
cp EvaluacionPsicologica.php app/Models/
cp InterconsultaPsiquiatrica.php app/Models/

# Controladores
cp HistoriaPsicologicaController.php app/Http/Controllers/
cp EvaluacionPsicologicaController.php app/Http/Controllers/
cp InterconsultaPsiquiatricaController.php app/Http/Controllers/
```

### 5. Actualizar Rutas

Agrega el contenido de `web_routes_updated.php` a `routes/web.php`

### 6. Ejecutar Migraciones

```bash
php artisan migrate
```

---

## 🔧 Comandos Útiles

### Ver Base de Datos

```bash
php artisan db:show
php artisan db:table consultantes
```

### Acceder a SQLite Directamente

```bash
sqlite3 database/database.sqlite

-- Dentro de SQLite:
.tables                      -- Ver tablas
.schema consultantes        -- Ver estructura
SELECT * FROM consultantes; -- Consultar
.quit                       -- Salir
```

### Respaldos

**Crear respaldo:**
```bash
# Linux/Mac
cp database/database.sqlite database/backup/db_$(date +%Y%m%d).sqlite

# Windows
copy database\database.sqlite database\backup\db_%date:~-4,4%%date:~-10,2%%date:~-7,2%.sqlite
```

**Restaurar respaldo:**
```bash
cp database/backup/db_20241109.sqlite database/database.sqlite
```

---

## ⚡ Optimización de SQLite

Agrega a `config/database.php`:

```php
'sqlite' => [
    'driver' => 'sqlite',
    'database' => env('DB_DATABASE', database_path('database.sqlite')),
    'prefix' => '',
    'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
    'busy_timeout' => 5000,
    
    // Pragmas para mejor rendimiento
    'pragmas' => [
        'journal_mode' => 'WAL',        // Write-Ahead Logging
        'synchronous' => 'NORMAL',      // Balance
        'foreign_keys' => 'ON',         // FK habilitadas
        'busy_timeout' => 5000,
    ],
],
```

---

## 🐛 Solución de Problemas

### "database is locked"
```php
// config/database.php
'busy_timeout' => 5000, // Agregar timeout
```

### "readonly database"
```bash
chmod 664 database/database.sqlite
chmod 775 database
```

### "unable to open database"
```bash
touch database/database.sqlite
php artisan migrate
```

---

## 📦 Convertir a Ejecutable de Escritorio

### Con NativePHP

```bash
composer require nativephp/laravel
php artisan native:install
php artisan native:serve
```

### Con Servidor Portable

Empaqueta:
- PHP portable
- Tu proyecto Laravel
- SQLite embebido
- Script de inicio

---

## 🚀 Iniciar Aplicación

```bash
php artisan serve
```

Accede en: `http://localhost:8000`

---

## ✅ Checklist

- [ ] PHP con SQLite instalado
- [ ] `database/database.sqlite` creado
- [ ] Migraciones copiadas y ejecutadas
- [ ] Modelos y controladores copiados
- [ ] Rutas actualizadas
- [ ] Servidor corriendo

---

## 📌 Notas Importantes

1. **Las migraciones de Laravel funcionan igual** con SQLite
2. **NO necesitas scripts SQL** - Laravel se encarga de todo
3. **Perfecto para aplicación local** - Un solo archivo de BD
4. **Fácil de respaldar** - Solo copia el archivo .sqlite

---

**¡Tu sistema está listo para funcionar con SQLite!** 🎉
