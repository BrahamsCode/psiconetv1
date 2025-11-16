@extends('layouts.app')

@section('title', 'Nueva Historia Psicológica')
@section('page-title', 'Seleccionar Consultante para Historia')

@section('content')
<div class="card">
    <div class="card-header">
        Consultantes sin Historia Psicológica
    </div>

    @if($consultantes->isEmpty())
        <div style="padding: 2rem; text-align: center; color: var(--text-secondary);">
            <p style="font-size: 1.1rem; margin-bottom: 1rem;">
                📋 No hay consultantes disponibles
            </p>
            <a href="{{ route('consultantes.create') }}" class="btn btn-primary">
                ➕ Registrar Nuevo Consultante
            </a>
        </div>
    @else
        {{-- <div style="padding: 1rem; background: var(--primary-light); border-bottom: 1px solid var(--border-color);">
            <p style="margin: 0; color: var(--text-secondary);">
                Seleccione un consultante para crear su historia psicológica
            </p>
        </div> --}}

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Fecha Registro</th>
                    <th style="text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultantes as $consultante)
                <tr>
                    <td>
                        <strong>{{ $consultante->nombre }}</strong>
                    </td>
                    <td>{{ $consultante->edad }} años</td>
                    <td>{{ $consultante->telefono ?? '-' }}</td>
                    <td>{{ $consultante->email ?? '-' }}</td>
                    <td>{{ $consultante->fecha_registro->format('d/m/Y') }}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('historias.create', $consultante) }}"
                           class="btn btn-primary btn-sm">
                            📝 Crear Historia
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- <div style="margin-top: 1rem;">
    <a href="{{ route('historias.index') }}" class="btn btn-secondary">
        ← Volver al Listado
    </a>
</div> --}}
@endsection
