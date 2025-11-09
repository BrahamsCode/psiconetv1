@extends('layouts.app')

@section('title', 'Editar Consultante')

@section('content')
<div class="card">
    <div class="card-header">
        Editar Consultante: {{ $consultante->nombre }}
    </div>

    <form action="{{ route('consultantes.update', $consultante) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nombre">Nombre Completo *</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $consultante->nombre) }}" required>
        </div>

        <div class="form-group">
            <label for="edad">Edad *</label>
            <input type="number" id="edad" name="edad" value="{{ old('edad', $consultante->edad) }}" min="0" max="120" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $consultante->telefono) }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $consultante->email) }}">
        </div>

        <div class="form-group">
            <label for="fecha_registro">Fecha de Registro *</label>
            <input type="date" id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro', $consultante->fecha_registro->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea id="observaciones" name="observaciones">{{ old('observaciones', $consultante->observaciones) }}</textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('consultantes.show', $consultante) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
