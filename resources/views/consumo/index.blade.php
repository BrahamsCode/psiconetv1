@extends('layouts.app')

@section('title', 'Fase del Consumo - Seleccionar Consultante')

@section('page-title', 'Fase del Consumo')

@section('content')
<div class="card">
    <div class="card-header">
        Seleccionar Consultante para Evaluación de Consumo
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Fecha Registro</th>
                <th>Historia Psicológica</th>
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
                <td class="actions">
                    @if($consultante->historiaPsicologica)
                        <a href="{{ route('consumo.fase', $consultante) }}" class="btn btn-primary btn-sm">
                            📊 Ver Fase de Consumo
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
                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-secondary);">
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
    <div class="card-header">Estadísticas</div>
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
                <h3>{{ $consultantes->whereNotNull('historiaPsicologica')->count() }}</h3>
                <p>Con Historia Psicológica</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div class="stat-content">
                <h3>{{ $consultantes->whereNull('historiaPsicologica')->count() }}</h3>
                <p>Sin Historia Psicológica</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
