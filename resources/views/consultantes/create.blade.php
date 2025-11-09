@extends('layouts.app')

@section('title', 'Nuevo Consultante')

@section('content')
<div class="card">
    <div class="card-header">
        Registrar Nuevo Consultante
    </div>

    <form action="{{ route('consultantes.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="nombre">Nombre Completo *</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div class="form-group">
            <label for="edad">Edad *</label>
            <input type="number" id="edad" name="edad" value="{{ old('edad') }}" min="0" max="120" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="fecha_registro">Fecha de Registro *</label>
            <input type="date" id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea id="observaciones" name="observaciones">{{ old('observaciones') }}</textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Guardar Consultante</button>
            <a href="{{ route('consultantes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
