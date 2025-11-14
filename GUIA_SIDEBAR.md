# 📋 Sidebar Completo de PSICONET V1

## ✅ Estructura del Menú Actualizado

He completado el sidebar con **todas las funcionalidades** del sistema organizadas en 7 secciones lógicas:

---

## 🏗️ Secciones del Sidebar

### 1. 🏠 PRINCIPAL
```
✓ Dashboard - Vista general del sistema
```

### 2. 👥 CONSULTANTES
```
✓ Todos los Consultantes - Listado completo
✓ Nuevo Consultante - Formulario de registro
```

### 3. 📋 HISTORIAS CLÍNICAS
```
✓ Todas las Historias - Listado de historias psicológicas
✓ Nueva Historia - Crear historia psicológica de adicciones
```

### 4. 🗓️ SESIONES
```
✓ Todas las Sesiones - Intervenciones terapéuticas
✓ Calendario - Vista de calendario (por implementar)
```

### 5. 🧠 EVALUACIONES
```
✓ Evaluaciones Psicológicas - Tests y evaluaciones
✓ Interconsultas - Interconsultas psiquiátricas
```

### 6. 📊 GESTIÓN
```
✓ Estadísticas - Análisis de datos
✓ Reportes - Generación de informes
✓ Búsqueda Avanzada - Filtros personalizados
```

### 7. ⚙️ SISTEMA
```
✓ Respaldos - Gestión de backups de SQLite
✓ Configuración - Ajustes del sistema
✓ Acerca de - Información del sistema
```

---

## 🔧 Ajustar las Rutas

Una vez que tengas todas las vistas creadas, solo necesitas actualizar las rutas en el sidebar:

### Rutas Actuales (Temporales)

Estas son las rutas que debes reemplazar cuando tengas las vistas listas:

```blade
<!-- TEMPORALES - Apuntan a consultantes.index por ahora -->
<a href="{{ route('consultantes.index') }}" class="nav-item">
    <span class="nav-icon">📋</span>
    <span>Todas las Historias</span>
</a>
```

### Rutas Finales (Cuando estén listas)

```blade
<!-- FINAL - Rutas específicas que ya tenemos en routes/web.php -->

<!-- Historias -->
<a href="{{ route('historias.index') }}" class="nav-item">
    <span class="nav-icon">📋</span>
    <span>Todas las Historias</span>
</a>

<!-- Intervenciones -->
<a href="{{ route('intervenciones.index') }}" class="nav-item">
    <span class="nav-icon">🗓️</span>
    <span>Todas las Sesiones</span>
</a>

<!-- Evaluaciones -->
<a href="{{ route('evaluaciones.index') }}" class="nav-item">
    <span class="nav-icon">🧠</span>
    <span>Evaluaciones Psicológicas</span>
</a>

<!-- Interconsultas -->
<a href="{{ route('interconsultas.index') }}" class="nav-item">
    <span class="nav-icon">⚕️</span>
    <span>Interconsultas</span>
</a>

<!-- Estadísticas -->
<a href="{{ route('estadisticas.index') }}" class="nav-item">
    <span class="nav-icon">📊</span>
    <span>Estadísticas</span>
</a>

<!-- Respaldos -->
<a href="{{ route('respaldos.index') }}" class="nav-item">
    <span class="nav-icon">💾</span>
    <span>Respaldos</span>
</a>
```

---

## 🎨 Funcionalidades Incluidas

### ✅ Navegación Activa
```blade
class="{{ request()->routeIs('consultantes.index') ? 'active' : '' }}"
```
El elemento del menú se marca como activo cuando estás en esa ruta.

### ✅ Diseño Responsive
- Desktop: Sidebar fijo a la izquierda (280px)
- Tablet/Mobile: Sidebar oculto con botón hamburguesa
- Overlay oscuro cuando el menú está abierto en móvil

### ✅ Iconos Emoji
Cada sección tiene su emoji característico:
- 🏠 Dashboard
- 👥 Consultantes
- 📋 Historias
- 🗓️ Sesiones
- 🧠 Evaluaciones
- ⚕️ Interconsultas
- 📊 Estadísticas
- 💾 Respaldos

### ✅ Alertas Mejoradas
Agregué soporte para 3 tipos de alertas:
- ✅ Success (verde) - Operaciones exitosas
- ❌ Error (rojo) - Errores y validaciones
- ℹ️ Info (azul) - Información general

---

## 📝 Cómo Usarlo

### 1. Reemplazar tu layout actual

```bash
cp app.blade.php resources/views/layouts/app.blade.php
```

### 2. Todas tus vistas lo heredarán automáticamente

```blade
@extends('layouts.app')

@section('title', 'Título de la página')

@section('page-title', 'Título en el top bar')

@section('content')
    <!-- Tu contenido aquí -->
@endsection
```

### 3. Cuando crees nuevas rutas, actualiza el sidebar

Busca en `app.blade.php` y reemplaza los `href="#"` o `href="{{ route('consultantes.index') }}"` temporales por las rutas reales.

---

## 🎯 Rutas que Necesitas Crear Aún

Para que el sidebar funcione al 100%, necesitas crear estas rutas:

### Historias (ya tenemos los controladores)
```php
Route::get('historias', [HistoriaPsicologicaController::class, 'index'])
    ->name('historias.index');
```

### Intervenciones
```php
Route::get('intervenciones', [IntervencionController::class, 'index'])
    ->name('intervenciones.index');
```

### Evaluaciones (ya tenemos el controlador)
```php
Route::get('evaluaciones', [EvaluacionPsicologicaController::class, 'index'])
    ->name('evaluaciones.index');
```

### Interconsultas (ya tenemos el controlador)
```php
Route::get('interconsultas', [InterconsultaPsiquiatricaController::class, 'index'])
    ->name('interconsultas.index');
```

### Nuevas (por crear)
```php
// Estadísticas
Route::get('estadisticas', [EstadisticasController::class, 'index'])
    ->name('estadisticas.index');

// Reportes
Route::get('reportes', [ReportesController::class, 'index'])
    ->name('reportes.index');

// Respaldos
Route::get('respaldos', [RespaldosController::class, 'index'])
    ->name('respaldos.index');

// Configuración
Route::get('configuracion', [ConfiguracionController::class, 'index'])
    ->name('configuracion.index');
```

---

## 🔄 Orden de Implementación Sugerido

1. ✅ **Dashboard** (ya tienes)
2. ✅ **Consultantes** (ya tienes create, index, show, edit)
3. ⏳ **Historias Psicológicas** (próximo paso - vistas)
4. ⏳ **Intervenciones** (listar y crear desde consultante)
5. ⏳ **Evaluaciones** (vista index)
6. ⏳ **Interconsultas** (vista index)
7. ⏳ **Calendario** (opcional - integrar FullCalendar)
8. ⏳ **Estadísticas** (gráficos con Chart.js)
9. ⏳ **Reportes** (exportar a PDF)
10. ⏳ **Respaldos** (copiar database.sqlite)

---

## 💡 Tips de Uso

### Para Marcar Múltiples Rutas como Activas
```blade
{{ request()->routeIs('consultantes.*') ? 'active' : '' }}
```
Esto marcará como activo cualquier ruta que empiece con `consultantes.`

### Para Rutas con Parámetros
```blade
<a href="{{ route('historias.show', $historia) }}" class="nav-item">
```

### Para Rutas Anidadas
```blade
<a href="{{ route('consultantes.intervenciones.create', $consultante) }}" class="nav-item">
```

---

## 🎨 Personalización

### Cambiar Colores
Edita las variables CSS en `:root`:
```css
:root {
    --primary: #2563eb;        /* Azul principal */
    --primary-hover: #1d4ed8;  /* Azul hover */
    --sidebar-bg: #ffffff;      /* Fondo sidebar */
}
```

### Cambiar Iconos
Reemplaza los emojis por iconos de Font Awesome u otra librería:
```blade
<span class="nav-icon">
    <i class="fas fa-home"></i>
</span>
```

### Ajustar Ancho del Sidebar
```css
.sidebar {
    width: 280px; /* Cambia este valor */
}

.main-content {
    margin-left: 280px; /* Debe ser igual al sidebar */
}
```

---

## 📦 Archivos del Paquete

```
app.blade.php         → Layout principal con sidebar completo
GUIA_SIDEBAR.md       → Este documento
```

---

## ✅ Resumen

- ✅ Sidebar completo con todas las funcionalidades
- ✅ 7 secciones organizadas lógicamente
- ✅ Navegación activa automática
- ✅ Responsive para móviles
- ✅ Alertas mejoradas (success, error, info)
- ✅ Listo para usar - solo reemplaza las rutas temporales

**¡Tu interfaz está lista para empezar a trabajar!** 🚀
