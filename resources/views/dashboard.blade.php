@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Panel de Control')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
            <h3>{{ $totalConsultantes }}</h3>
            <p>Total de Consultantes</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-content">
            <h3>{{ $totalIntervenciones }}</h3>
            <p>Total de Intervenciones</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-content">
            <h3>{{ $intervencionesHoy }}</h3>
            <p>Intervenciones Hoy</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🆕</div>
        <div class="stat-content">
            <h3>{{ $nuevosEsteMes }}</h3>
            <p>Nuevos Este Mes</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Acciones Rápidas
    </div>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('consultantes.create') }}" class="btn btn-primary">
            ➕ Nuevo Consultante
        </a>
        <a href="{{ route('consultantes.index') }}" class="btn btn-secondary">
            👥 Ver Todos los Consultantes
        </a>
    </div>
</div>

@if($ultimosConsultantes->isNotEmpty())
<div class="card">
    <div class="card-header">
        Últimos Consultantes Registrados
    </div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Fecha de Registro</th>
                <th>Sesiones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ultimosConsultantes as $consultante)
            <tr>
                <td><strong>{{ $consultante->nombre }}</strong></td>
                <td>{{ $consultante->edad }} años</td>
                <td>{{ $consultante->fecha_registro->format('d/m/Y') }}</td>
                <td>
                    <span class="badge badge-primary">
                        {{ $consultante->intervenciones_count }} sesión(es)
                    </span>
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('consultantes.show', $consultante) }}" class="btn btn-primary btn-sm">
                            Ver Detalles
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if($proximasIntervenciones->isNotEmpty())
<div class="card">
    <div class="card-header">
        Últimas Intervenciones
    </div>
    <table>
        <thead>
            <tr>
                <th>Consultante</th>
                <th>Sesión #</th>
                <th>Fecha</th>
                <th>Terapeuta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proximasIntervenciones as $intervencion)
            <tr>
                <td><strong>{{ $intervencion->consultante->nombre }}</strong></td>
                <td>
                    <span class="badge badge-success">
                        Sesión {{ $intervencion->numero_sesion }}
                    </span>
                </td>
                <td>{{ $intervencion->fecha->format('d/m/Y') }}</td>
                <td>{{ $intervencion->terapeuta }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('consultantes.show', $intervencion->consultante) }}" class="btn btn-primary btn-sm">
                            Ver Consultante
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
