@extends('layouts.app')

@section('title', 'Tratamientos Recibidos - Seleccionar Consultante')

@section('page-title', 'Tratamientos Recibidos')

@section('content')
<div class="card">
    <div class="card-header">
        Seleccionar Consultante para Gestionar Tratamientos Previos
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Fecha Registro</th>
                <th>Historia Psicológica</th>
                <th>Tratamientos Registrados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultantes as $consultante)
            <tr>
                <td><strong>{{ $consultante->nombre }}</strong></td>
                <td>{{ $consultante->edad }} años</td>
                <td>{{ \Carbon\Carbon::parse($consultante->fecha_registro)->format('d/m/Y') }}</td>
                <td>
                    @if($consultante->historiaPsicologica)
                        <span class="badge badge-success">✓ Creada</span>
                    @else
                        <span class="badge badge-warning">⚠ No creada</span>
                    @endif
                </td>
                <td>
                    @if($consultante->historiaPsicologica && $consultante->historiaPsicologica->tratamientosPrevios->count() > 0)
                        <span class="badge badge-primary">
                            {{ $consultante->historiaPsicologica->tratamientosPrevios->count() }} tratamiento(s)
                        </span>
                    @else
                        <span class="text-muted small">Sin tratamientos</span>
                    @endif
                </td>
                <td class="actions">
                    @if($consultante->historiaPsicologica)
                        <a href="{{ route('tratamientos.show', $consultante) }}" class="btn btn-primary btn-sm">
                            💊 Gestionar Tratamientos
                        </a>
                    @else
                        <a href="{{ route('historias.create', $consultante) }}" class="btn btn-secondary btn-sm">
                            📝 Crear Historia Primero
                        </a>
                    @endif

                    <a href="{{ route('consultantes.show', $consultante) }}" class="btn btn-sm" style="background: var(--info); color: white;">
                        👁 Ver Perfil
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                    No hay consultantes registrados.
                    <br><br>
                    <a href="{{ route('consultantes.create') }}" class="btn btn-primary">
                        ➕ Registrar Nuevo Consultante
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($consultantes->isNotEmpty())
<div class="card">
    <div class="card-header">Estadísticas de Tratamientos</div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <h3>{{ $consultantes->count() }}</h3>
                <p>Total Consultantes</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-content">
                <h3>{{ $consultantes->filter(fn($c) => $c->historiaPsicologica)->count() }}</h3>
                <p>Con Historia Psicológica</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💊</div>
            <div class="stat-content">
                <h3>{{ $consultantes->sum(fn($c) => $c->historiaPsicologica ? $c->historiaPsicologica->tratamientosPrevios->count() : 0) }}</h3>
                <p>Tratamientos Registrados</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
