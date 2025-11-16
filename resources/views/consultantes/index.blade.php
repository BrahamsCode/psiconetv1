@extends('layouts.app')

@section('title', 'Lista de Consultantes')
@section('page-title', 'Lista de Consultantes')

@section('content')
<div class="card">
    <div class="card-header">
        Lista de Consultantes
    </div>

    @if($consultantes->isEmpty())
        <div style="padding: 2rem; text-align: center; color: var(--text-secondary);">
            <p style="font-size: 1.1rem; margin-bottom: 1rem;">
                👥 No hay consultantes registrados
            </p>
            <p style="margin-bottom: 1.5rem;">
                Comienza registrando tu primer consultante
            </p>
            <a href="{{ route('consultantes.create') }}" class="btn btn-primary">
                ➕ Registrar Nuevo Consultante
            </a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Sesiones</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultantes as $consultante)
                <tr>
                    <td>{{ $consultante->id }}</td>
                    <td><strong>{{ $consultante->nombre }}</strong></td>
                    <td>{{ $consultante->edad }} años</td>
                    <td>{{ $consultante->telefono ?? '-' }}</td>
                    <td>{{ $consultante->email ?? '-' }}</td>
                    <td>
                        <span style="background: #667eea; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem;">
                            {{ $consultante->intervenciones->count() }} sesiones
                        </span>
                    </td>
                    <td>{{ $consultante->fecha_registro->format('d/m/Y') }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('consultantes.show', $consultante) }}" class="btn btn-primary btn-sm">
                                Ver
                            </a>
                            <a href="{{ route('consultantes.edit', $consultante) }}" class="btn btn-secondary btn-sm">
                                Editar
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
