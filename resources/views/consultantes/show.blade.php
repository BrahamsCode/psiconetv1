@extends('layouts.app')

@section('title', 'Detalles del Consultante')

@section('content')
<div class="card">
    <div class="card-header">
        Información del Consultante
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div>
            <strong style="color: #667eea;">Nombre:</strong><br>
            <span style="font-size: 1.25rem;">{{ $consultante->nombre }}</span>
        </div>
        <div>
            <strong style="color: #667eea;">Edad:</strong><br>
            <span style="font-size: 1.25rem;">{{ $consultante->edad }} años</span>
        </div>
        <div>
            <strong style="color: #667eea;">Teléfono:</strong><br>
            <span>{{ $consultante->telefono ?? '-' }}</span>
        </div>
        <div>
            <strong style="color: #667eea;">Email:</strong><br>
            <span>{{ $consultante->email ?? '-' }}</span>
        </div>
        <div>
            <strong style="color: #667eea;">Fecha de Registro:</strong><br>
            <span>{{ $consultante->fecha_registro->format('d/m/Y') }}</span>
        </div>
        <div>
            <strong style="color: #667eea;">Total de Sesiones:</strong><br>
            <span style="font-size: 1.25rem; color: #667eea; font-weight: bold;">
                {{ $consultante->intervenciones->count() }}
            </span>
        </div>
    </div>

    @if($consultante->observaciones)
    <div style="margin-bottom: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 4px;">
        <strong style="color: #667eea;">Observaciones:</strong><br>
        <span>{{ $consultante->observaciones }}</span>
    </div>
    @endif

    <div class="actions">
        <a href="{{ route('intervenciones.create', $consultante) }}" class="btn btn-primary">
            ➕ Nueva Intervención
        </a>
        <a href="{{ route('consultantes.edit', $consultante) }}" class="btn btn-secondary">
            ✏️ Editar Consultante
        </a>
        <form action="{{ route('consultantes.destroy', $consultante) }}" method="POST" style="display: inline;" 
              onsubmit="return confirm('¿Está seguro de eliminar este consultante? Se eliminarán todas sus intervenciones.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">🗑️ Eliminar</button>
        </form>
        <a href="{{ route('consultantes.index') }}" class="btn btn-secondary">⬅️ Volver</a>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        📋 Historial de Intervenciones Psicológicas
    </div>

    @if($consultante->intervenciones->isEmpty())
        <p style="text-align: center; padding: 2rem; color: #999;">
            No hay intervenciones registradas.
            <a href="{{ route('intervenciones.create', $consultante) }}" style="color: #667eea;">
                ¡Registra la primera sesión!
            </a>
        </p>
    @else
        <table>
            <thead>
                <tr>
                    <th>N° Sesión</th>
                    <th>Fecha</th>
                    <th>Asistidos</th>
                    <th>Actividades</th>
                    <th>Terapeuta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultante->intervenciones->sortBy('numero_sesion') as $intervencion)
                <tr>
                    <td>
                        <strong style="color: #667eea;">{{ $intervencion->numero_sesion }}</strong>
                    </td>
                    <td>{{ $intervencion->fecha->format('d/m/Y') }}</td>
                    <td>{{ $intervencion->asistidos }}</td>
                    <td style="max-width: 300px;">{{ Str::limit($intervencion->actividades, 100) }}</td>
                    <td>{{ $intervencion->terapeuta }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('intervenciones.edit', $intervencion) }}" class="btn btn-secondary btn-sm">
                                Editar
                            </a>
                            <form action="{{ route('intervenciones.destroy', $intervencion) }}" method="POST" 
                                  style="display: inline;" onsubmit="return confirm('¿Eliminar esta intervención?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
