@extends('layouts.app')

@section('title', 'Historia Psicológica #' . $historia->numero_historia)

@section('page-title', 'Historia Psicológica')

@section('content')
<!-- Encabezado con Acciones -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <div>
        <h2 style="color: var(--primary); margin: 0;">
            Historia N°: {{ $historia->numero_historia }}
        </h2>
        <p style="color: var(--text-secondary); margin: 0.25rem 0 0 0;">
            Creada: {{ $historia->fecha_historia->format('d/m/Y') }}
        </p>
    </div>

    <div style="display: flex; gap: 0.5rem;">
        {{-- <a href="{{ route('historias.index') }}" class="btn btn-secondary btn-sm">
            ← Volver al Consultante
        </a> --}}
        <a href="{{ route('historias.edit', $historia) }}" class="btn btn-primary btn-sm">
            ✏️ Editar Historia
        </a>
        <a href="{{ route('historias.pdf', $historia) }}" class="btn btn-sm" style="background: var(--error); color: white;" target="_blank">
            📄 Exportar PDF
        </a>
    </div>
</div>

<!-- A) DATOS DE FILIACIÓN -->
<div class="card">
    <div class="card-header">A) DATOS DE FILIACIÓN</div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div>
            <strong>Nombre:</strong><br>
            {{ $historia->consultante->nombre }}
        </div>
        <div>
            <strong>Edad:</strong><br>
            {{ $historia->consultante->edad }} años
        </div>
        <div>
            <strong>Género:</strong><br>
            {{ $historia->genero ?? '-' }}
        </div>
        <div>
            <strong>Grado de Instrucción:</strong><br>
            {{ $historia->grado_instruccion ?? '-' }}
        </div>
        <div>
            <strong>Estado Civil:</strong><br>
            {{ $historia->estado_civil ?? '-' }}
        </div>
        <div>
            <strong>Ocupación:</strong><br>
            {{ $historia->ocupacion ?? '-' }}
        </div>
        <div>
            <strong>Teléfono:</strong><br>
            {{ $historia->telefono ?? '-' }}
        </div>
        <div>
            <strong>Residencia:</strong><br>
            {{ $historia->residencia ?? '-' }}
        </div>
        <div>
            <strong>Religión:</strong><br>
            {{ $historia->religion ?? '-' }}
        </div>
        <div>
            <strong>Natural de:</strong><br>
            {{ $historia->natural_de ?? '-' }}
        </div>
        <div>
            <strong>Tiempo en Lima:</strong><br>
            {{ $historia->tiempo_residencia_lima ?? '-' }}
        </div>
    </div>

    @if($historia->persona_responsable)
    <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">
    <h3 style="margin-bottom: 1rem; color: var(--secondary); font-size: 1rem;">Persona Responsable</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div>
            <strong>Nombre:</strong><br>
            {{ $historia->persona_responsable }}
        </div>
        <div>
            <strong>Parentesco:</strong><br>
            {{ $historia->parentesco_responsable ?? '-' }}
        </div>
        <div>
            <strong>Teléfono:</strong><br>
            {{ $historia->telefono_responsable ?? '-' }}
        </div>
    </div>
    @endif

    @if($historia->asisten_primera_consulta)
    <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">
    <h3 style="margin-bottom: 1rem; color: var(--secondary); font-size: 1rem;">Primera Consulta</h3>
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
        <div>
            <strong>Asisten:</strong><br>
            {{ $historia->asisten_primera_consulta }}
        </div>
        <div>
            <strong>Teléfono:</strong><br>
            {{ $historia->telefono_primera_consulta ?? '-' }}
        </div>
    </div>
    @endif

    <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">
    <h3 style="margin-bottom: 1rem; color: var(--secondary); font-size: 1rem;">Datos de la Entrevista</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div>
            <strong>Lugar:</strong><br>
            {{ $historia->lugar_entrevista }}
        </div>
        <div>
            <strong>Fecha:</strong><br>
            {{ $historia->fecha_historia->format('d/m/Y') }}
        </div>
        <div>
            <strong>Terapeuta:</strong><br>
            {{ $historia->terapeuta ?? '-' }}
        </div>
        <div>
            <strong>Recomendado por:</strong><br>
            {{ $historia->recomendado_por ?? '-' }}
            @if($historia->recomendado_detalle)
                ({{ $historia->recomendado_detalle }})
            @endif
        </div>
    </div>
</div>

<!-- B) MOTIVO DE CONSULTA -->
<div class="card">
    <div class="card-header">B) MOTIVO DE CONSULTA</div>
    <p style="white-space: pre-wrap;">{{ $historia->motivo_consulta ?? 'No especificado' }}</p>
</div>

<!-- C) PROBLEMA ACTUAL -->
@if($historia->problemas_actuales)
<div class="card">
    <div class="card-header">C) PROBLEMA ACTUAL</div>
    @foreach($historia->problemas_actuales as $index => $problema)
    <div style="margin-bottom: 1rem;">
        <strong style="color: var(--primary);">Problema {{ $index + 1 }}:</strong>
        <p style="margin: 0.5rem 0 0 0; white-space: pre-wrap;">{{ $problema }}</p>
    </div>
    @endforeach
</div>
@endif

<!-- Accesos Rápidos a Secciones -->
<div class="card">
    <div class="card-header">Secciones de la Historia</div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('consumo.fase', $historia->consultante) }}" class="btn btn-primary">
            🔁 Fase del Consumo
        </a>
        <a href="#" class="btn btn-secondary">
            💊 Tratamientos Previos
        </a>
        <a href="#" class="btn btn-secondary">
            👨‍👩‍👧‍👦 Diagrama Familiar
        </a>
        <a href="#" class="btn btn-secondary">
            🎯 Conductas Problema
        </a>
        <a href="#" class="btn btn-secondary">
            🧠 Evaluación Psicológica
        </a>
        <a href="#" class="btn btn-secondary">
            ⚕️ Interconsulta Psiquiátrica
        </a>
    </div>
</div>
@endsection
