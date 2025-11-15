@extends('layouts.app')

@section('title', 'Editar Historia')
@section('page-title', 'Editar Historia')

@section('content')
<div class="card">
    <div class="card-header">Editar Historia: {{ $historia->numero_historia ?? $historia->id }}</div>

    <form action="{{ route('historias.update', $historia) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="fecha_historia">Fecha de Historia *</label>
            <input type="date" id="fecha_historia" name="fecha_historia"
                value="{{ old('fecha_historia', optional($historia->fecha_historia)->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="motivo_consulta">Motivo de Consulta *</label>
            <textarea id="motivo_consulta" name="motivo_consulta"
                required>{{ old('motivo_consulta', $historia->motivo_consulta) }}</textarea>
        </div>

        <div class="form-group">
            <label>Problema Actual (hasta 5)</label>
            @for($i=1; $i<=5; $i++) <input type="text" name="problema_actual_{{ $i }}"
                value="{{ old('problema_actual_'.$i, $historia->{'problema_actual_'.$i} ?? '') }}"
                placeholder="Problema actual {{ $i }}">
                @endfor
        </div>

        <div class="form-group">
            <label for="diagrama_familiar_observaciones">Diagrama Familiar - Observaciones</label>
            <textarea id="diagrama_familiar_observaciones"
                name="diagrama_familiar_observaciones">{{ old('diagrama_familiar_observaciones', $historia->diagrama_familiar_observaciones ?? '') }}</textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('historias.show', $historia) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection