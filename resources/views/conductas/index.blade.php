@extends('layouts.app')

@section('title', 'Procedimiento Terapéutico')
@section('page-title', 'Procedimiento Terapéutico - Seleccionar Historia')

@section('content')
<div class="card">
    <div class="card-header">
        Seleccione una Historia para Gestionar el Procedimiento Terapéutico
    </div>

    @if($historias->isEmpty())
        <div style="padding: 2rem; text-align: center; color: var(--text-secondary);">
            <p style="font-size: 1.1rem; margin-bottom: 1rem;">
                📋 No hay historias disponibles
            </p>
            <a href="{{ route('historias.nueva') }}" class="btn btn-primary">
                ➕ Crear Nueva Historia
            </a>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>N° Historia</th>
                    <th>Consultante</th>
                    <th>Edad</th>
                    <th>Fecha</th>
                    <th>Conductas Registradas</th>
                    <th style="text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historias as $historia)
                <tr>
                    <td><strong>{{ $historia->numero_historia }}</strong></td>
                    <td>{{ $historia->consultante->nombre }}</td>
                    <td>{{ $historia->consultante->edad }} años</td>
                    <td>{{ $historia->fecha_historia->format('d/m/Y') }}</td>
                    <td>
                        @if($historia->conductasProblema->count() > 0)
                            <span style="color: var(--success); font-weight: 500;">
                                ✅ {{ $historia->conductasProblema->count() }} conducta(s)
                            </span>
                        @else
                            <span style="color: var(--text-secondary);">
                                Sin conductas
                            </span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('conductas.create', $historia) }}"
                           class="btn btn-primary btn-sm">
                            @if($historia->conductasProblema->count() > 0)
                                ✏️ Editar Procedimiento
                            @else
                                ➕ Crear Procedimiento
                            @endif
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 1rem;">
            {{ $historias->links() }}
        </div>
    @endif
</div>

{{-- <div style="margin-top: 1rem;">
    <a href="{{ route('historias.index') }}" class="btn btn-secondary">
        ← Volver a Historias
    </a>
</div> --}}
@endsection
