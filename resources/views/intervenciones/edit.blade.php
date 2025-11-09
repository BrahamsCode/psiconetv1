@extends('layouts.app')

@section('title', 'Editar Intervención')

@section('content')
<div class="card">
    <div class="card-header">
        Editar Intervención - {{ $intervencion->consultante->nombre }}
    </div>

    <div style="background: #e3f2fd; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #667eea;">
        <strong>Sesión N°:</strong> {{ $intervencion->numero_sesion }}
    </div>

    <form action="{{ route('intervenciones.update', $intervencion) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="fecha">Fecha de la Sesión *</label>
            <input type="date" id="fecha" name="fecha" value="{{ old('fecha', $intervencion->fecha->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="asistidos">Asistidos *</label>
            <input type="text" id="asistidos" name="asistidos" value="{{ old('asistidos', $intervencion->asistidos) }}" 
                   placeholder="Ejemplo: Paciente, Familiar, etc." required>
            <small style="color: #666;">¿Quiénes asistieron a la sesión?</small>
        </div>

        <div class="form-group">
            <label for="actividades">Actividades Realizadas *</label>
            <textarea id="actividades" name="actividades" required 
                      placeholder="Describe las actividades, temas tratados, técnicas aplicadas, etc.">{{ old('actividades', $intervencion->actividades) }}</textarea>
        </div>

        <div class="form-group">
            <label for="terapeuta">Terapeuta *</label>
            <input type="text" id="terapeuta" name="terapeuta" value="{{ old('terapeuta', $intervencion->terapeuta) }}" 
                   placeholder="Nombre del terapeuta" required>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('consultantes.show', $intervencion->consultante) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
