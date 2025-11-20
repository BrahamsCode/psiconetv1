@extends('layouts.app')

@section('title', 'Seleccionar Afiliación')
@section('page-title', 'Seleccionar Afiliación para Nueva Historia')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span>👥 Seleccionar Afiliación</span>
            <a href="{{ route('afiliaciones.create') }}" class="btn btn-primary">
                ➕ Nueva Afiliación
            </a>
        </div>
    </div>

    @if($afiliaciones->isEmpty())
        <div style="padding: 2rem; text-align: center; color: #7f8c8d;">
            <p>📭 No hay afiliaciones sin historia psicológica.</p>
            <p>Todas las afiliaciones ya tienen su historia creada o no hay afiliaciones registradas.</p>
            <div style="margin-top: 1.5rem;">
                <a href="{{ route('afiliaciones.create') }}" class="btn btn-primary">
                    ➕ Registrar Nueva Afiliación
                </a>
                <a href="{{ route('afiliaciones.index') }}" class="btn btn-secondary">
                    Ver Todas las Afiliaciones
                </a>
            </div>
        </div>
    @else
        <div class="info-box" style="margin: 1rem; padding: 1rem; background: #e8f4f8; border-left: 4px solid #3498db;">
            <strong>ℹ️ Instrucciones:</strong> Seleccione una afiliación de la lista para crear su historia psicológica.
        </div>

        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombres y Apellidos</th>
                        <th>DNI</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                        <th>Fecha de Registro</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($afiliaciones as $afiliacion)
                    <tr>
                        <td>
                            <strong>{{ $afiliacion->nombres_apellidos }}</strong>
                        </td>
                        <td>{{ $afiliacion->documento_identidad ?? '-' }}</td>
                        <td>{{ $afiliacion->edad }} años</td>
                        <td>{{ $afiliacion->telefono ?? '-' }}</td>
                        <td>{{ $afiliacion->fecha_creacion_historia->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('historias.create', $afiliacion) }}"
                               class="btn btn-success">
                                📋 Crear Historia
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
