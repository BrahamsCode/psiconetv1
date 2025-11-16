@extends('layouts.app')

@section('title', 'Tratamientos Recibidos - ' . $consultante->nombre)

@section('page-title', 'Tratamientos Recibidos')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="margin: 0; font-size: 1.25rem;">Consultante: <span style="color: var(--primary);">{{ $consultante->nombre }}</span></h2>
            <p style="margin: 0.5rem 0 0; font-size: 0.875rem; color: var(--text-secondary);">
                Historia Nº {{ $historia->numero_historia }} | Edad: {{ $consultante->edad }} años
            </p>
        </div>
        <a href="{{ route('tratamientos.index') }}" class="btn btn-secondary btn-sm">
            ← Volver al Listado
        </a>
    </div>

    <form action="{{ route('tratamientos.update', $consultante) }}" method="POST" id="tratamientosForm">
        @csrf
        @method('PUT')

        <div style="padding: 1.5rem;">
            <h3 style="font-size: 1.125rem; margin-bottom: 1rem; color: var(--secondary);">
                 B2)Tratamientos recibidos
            </h3>

            <div style="overflow-x: auto;">
                <table id="tratamientosTable" style="margin-bottom: 1.5rem;">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Tratamientos</th>
                            <th style="width: 100px;">Edad</th>
                            <th style="width: 250px;">Motivo</th>
                            <th style="width: 200px;">Lugar</th>
                            <th style="width: 150px;">Tiempo</th>
                            <th style="width: 250px;">Motivo de término</th>
                            <th style="width: 80px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tratamientosBody">
                        @php
                            $tratamientosPorTipo = $historia->tratamientosPrevios->groupBy('tipo_tratamiento');
                            $rowIndex = 0;
                        @endphp

                        @foreach($tiposTratamiento as $key => $tipo)
                            @php
                                $tratamientos = $tratamientosPorTipo->get($key, collect());
                                // Si no hay tratamientos de este tipo, crear al menos 3 filas vacías
                                $cantidadFilas = max(1, $tratamientos->count());
                            @endphp

                            @for($i = 0; $i < $cantidadFilas; $i++)
                                @php
                                    $tratamiento = $tratamientos->get($i);
                                @endphp
                                <tr class="tratamiento-row">
                                    <td>
                                        @if($i === 0)
                                            <strong style="color: var(--secondary);">{{ $tipo }}</strong>
                                            <input type="hidden" name="tratamientos[{{ $rowIndex }}][tipo_tratamiento]" value="{{ $key }}">
                                        @else
                                            <input type="hidden" name="tratamientos[{{ $rowIndex }}][tipo_tratamiento]" value="{{ $key }}">
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number"
                                               name="tratamientos[{{ $rowIndex }}][edad]"
                                               value="{{ $tratamiento->edad ?? '' }}"
                                               min="0"
                                               max="120"
                                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
                                    </td>
                                    <td>
                                        <textarea name="tratamientos[{{ $rowIndex }}][motivo]"
                                                  rows="2"
                                                  style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; resize: vertical; min-height: 60px;">{{ $tratamiento->motivo ?? '' }}</textarea>
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="tratamientos[{{ $rowIndex }}][lugar]"
                                               value="{{ $tratamiento->lugar ?? '' }}"
                                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="tratamientos[{{ $rowIndex }}][tiempo]"
                                               value="{{ $tratamiento->tiempo ?? '' }}"
                                               placeholder="ej: 6 meses"
                                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
                                    </td>
                                    <td>
                                        <textarea name="tratamientos[{{ $rowIndex }}][motivo_termino]"
                                                  rows="2"
                                                  style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; resize: vertical; min-height: 60px;">{{ $tratamiento->motivo_termino ?? '' }}</textarea>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($i > 0)
                                            <button type="button"
                                                    onclick="eliminarFila(this)"
                                                    class="btn btn-danger btn-sm"
                                                    title="Eliminar fila"
                                                    style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                                🗑️
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @php $rowIndex++; @endphp
                            @endfor
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem; align-items: center;">
                <button type="button" onclick="agregarFilaPsicologico()" class="btn btn-sm" style="background: var(--info); color: white;">
                    ➕ Agregar Fila - Psicológico
                </button>
                <button type="button" onclick="agregarFilaPsiquiatrico()" class="btn btn-sm" style="background: var(--info); color: white;">
                    ➕ Agregar Fila - Psiquiátrico
                </button>
                <button type="button" onclick="agregarFilaComunidad()" class="btn btn-sm" style="background: var(--info); color: white;">
                    ➕ Agregar Fila - Comunidad Terapéutica
                </button>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid var(--border-color); display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-success">
                    💾 Guardar Tratamientos
                </button>
                <a href="{{ route('consultantes.show', $consultante) }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<style>
    #tratamientosTable td {
        vertical-align: top;
        padding: 0.75rem 0.5rem;
    }

    #tratamientosTable input[type="text"],
    #tratamientosTable input[type="number"],
    #tratamientosTable textarea {
        font-size: 0.875rem;
    }

    #tratamientosTable textarea:focus,
    #tratamientosTable input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .tratamiento-row:hover {
        background-color: var(--sidebar-hover);
    }
</style>

<script>
    let rowCounter = {{ $rowIndex }};

    function agregarFila(tipoTratamiento) {
        const tbody = document.getElementById('tratamientosBody');
        const newRow = document.createElement('tr');
        newRow.className = 'tratamiento-row';
        newRow.innerHTML = `
            <td>
                <input type="hidden" name="tratamientos[${rowCounter}][tipo_tratamiento]" value="${tipoTratamiento}">
            </td>
            <td>
                <input type="number"
                       name="tratamientos[${rowCounter}][edad]"
                       min="0"
                       max="120"
                       style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </td>
            <td>
                <textarea name="tratamientos[${rowCounter}][motivo]"
                          rows="2"
                          style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; resize: vertical; min-height: 60px;"></textarea>
            </td>
            <td>
                <input type="text"
                       name="tratamientos[${rowCounter}][lugar]"
                       style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </td>
            <td>
                <input type="text"
                       name="tratamientos[${rowCounter}][tiempo]"
                       placeholder="ej: 6 meses"
                       style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </td>
            <td>
                <textarea name="tratamientos[${rowCounter}][motivo_termino]"
                          rows="2"
                          style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; resize: vertical; min-height: 60px;"></textarea>
            </td>
            <td style="text-align: center;">
                <button type="button"
                        onclick="eliminarFila(this)"
                        class="btn btn-danger btn-sm"
                        title="Eliminar fila"
                        style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                    🗑️
                </button>
            </td>
        `;

        // Encontrar la última fila del tipo correspondiente e insertar después
        const rows = Array.from(tbody.querySelectorAll('tr'));
        let insertIndex = -1;

        for (let i = rows.length - 1; i >= 0; i--) {
            const hiddenInput = rows[i].querySelector('input[name*="[tipo_tratamiento]"]');
            if (hiddenInput && hiddenInput.value === tipoTratamiento) {
                insertIndex = i;
                break;
            }
        }

        if (insertIndex !== -1 && insertIndex < rows.length - 1) {
            rows[insertIndex].after(newRow);
        } else {
            tbody.appendChild(newRow);
        }

        rowCounter++;
    }

    function agregarFilaPsicologico() {
        agregarFila('psicologico');
    }

    function agregarFilaPsiquiatrico() {
        agregarFila('psiquiatrico');
    }

    function agregarFilaComunidad() {
        agregarFila('comunidad_terapeutica');
    }

    function eliminarFila(button) {
        if (confirm('¿Está seguro de eliminar esta fila?')) {
            button.closest('tr').remove();
        }
    }
</script>
@endsection
