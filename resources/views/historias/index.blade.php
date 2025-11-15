@extends('layouts.app')

@section('title', 'Historias Clínicas')
@section('page-title', 'Historias Clínicas')

@section('content')
<div class="card">
    <div class="card-header">Historias Psicológicas</div>

    @if($historias->isEmpty())
    <p style="text-align:center; padding:2rem; color:#999;">No hay historias registradas.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nº Historia</th>
                <th>Consultante</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historias as $historia)
            <tr>
                <td>{{ $historia->id }}</td>
                <td><strong>{{ $historia->numero_historia }}</strong></td>
                <td>{{ $historia->consultante->nombre ?? '-' }}</td>
                <td>{{ optional($historia->fecha_historia)->format('d/m/Y') ?? '-' }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('historias.show', $historia) }}" class="btn btn-primary btn-sm">Ver</a>
                        <a href="{{ route('historias.edit', $historia) }}" class="btn btn-secondary btn-sm">Editar</a>
                        <a href="{{ route('historias.pdf', $historia) }}" class="btn btn-primary btn-sm"
                            style="background:#e73e3e">PDF</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem;">{{ $historias->links() }}</div>
    @endif
</div>
@endsection
