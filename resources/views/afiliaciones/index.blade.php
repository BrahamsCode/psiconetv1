@extends('layouts.app')

@section('title', 'Afiliaciones')
@section('page-title', 'Gestión de Afiliaciones')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span>📋 Lista de Afiliaciones</span>
            <a href="{{ route('afiliaciones.create') }}" class="btn btn-primary">
                ➕ Nueva Afiliación
            </a>
        </div>
    </div>

    @if($afiliaciones->isEmpty())
        <div style="padding: 2rem; text-align: center; color: #7f8c8d;">
            <p>📭 No hay afiliaciones registradas aún.</p>
            <a href="{{ route('afiliaciones.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                Registrar primera afiliación
            </a>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>N° Historia</th>
                        <th>Nombres y Apellidos</th>
                        <th>DNI</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                        <th>Fecha Registro</th>
                        <th>Historia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($afiliaciones as $afiliacion)
                    <tr>
                        <td>
                            @if($afiliacion->historiaPsicologica)
                                <span class="badge badge-success">
                                    {{ $afiliacion->historiaPsicologica->numero_historia }}
                                </span>
                            @else
                                <span class="badge badge-warning">Sin historia</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $afiliacion->nombres_apellidos }}</strong>
                        </td>
                        <td>{{ $afiliacion->documento_identidad ?? '-' }}</td>
                        <td>{{ $afiliacion->edad }} años</td>
                        <td>{{ $afiliacion->telefono ?? '-' }}</td>
                        <td>{{ $afiliacion->fecha_creacion_historia->format('d/m/Y') }}</td>
                        <td>
                            @if($afiliacion->tieneHistoria())
                                <a href="{{ route('historias.show', $afiliacion->historiaPsicologica) }}"
                                   class="btn btn-sm btn-info">
                                    📄 Ver Historia
                                </a>
                            @else
                                <a href="{{ route('historias.create', $afiliacion) }}"
                                   class="btn btn-sm btn-success">
                                    ➕ Crear Historia
                                </a>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('afiliaciones.show', $afiliacion) }}"
                                   class="btn btn-sm btn-info" title="Ver detalles">
                                    👁️
                                </a>
                                <a href="{{ route('afiliaciones.edit', $afiliacion) }}"
                                   class="btn btn-sm btn-warning" title="Editar">
                                    ✏️
                                </a>
                                <form action="{{ route('afiliaciones.destroy', $afiliacion) }}"
                                      method="POST"
                                      style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar esta afiliación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div style="padding: 1rem;">
            {{ $afiliaciones->links() }}
        </div>
    @endif
</div>

<style>
    .badge {
        padding: 0.35rem 0.65rem;
        border-radius: 0.25rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-success {
        background-color: #27ae60;
        color: white;
    }

    .badge-warning {
        background-color: #f39c12;
        color: white;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }
</style>
@endsection
