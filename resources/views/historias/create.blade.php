@extends('layouts.app')

@section('title', 'Nueva Historia Psicológica')

@section('page-title', 'Crear Historia Psicológica')

@section('content')
<form action="{{ route('historias.store', $consultante) }}" method="POST">
    @csrf

    <!-- Información del Consultante -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>Información del Consultante</span>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <strong style="font-size: 1.1rem; color: var(--primary-dark);">
                    {{ $consultante->nombre }}
                </strong>
                <span style="color: var(--text-secondary); font-size: 0.95rem;">
                    {{ $consultante->edad }} años
                </span>
            </div>
        </div>
    </div>

    <!-- A) DATOS DE FILIACIÓN -->
    <div class="card">
        <div class="card-header">A) DATOS DE FILIACIÓN</div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
            <!-- Fecha de Historia -->
            <div class="form-group">
                <label for="fecha_historia">Fecha de Historia *</label>
                <input type="date" name="fecha_historia" id="fecha_historia"
                    value="{{ old('fecha_historia', date('Y-m-d')) }}" required>
            </div>

            <!-- Género -->
            <div class="form-group">
                <label for="genero">Género *</label>
                <select name="genero" id="genero" required>
                    <option value="">Seleccionar...</option>
                    @foreach(App\Models\HistoriaPsicologica::GENEROS as $key => $value)
                    <option value="{{ $key }}" {{ old('genero')==$key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Grado de Instrucción -->
            <div class="form-group">
                <label for="grado_instruccion">Grado de Instrucción</label>
                <select name="grado_instruccion" id="grado_instruccion">
                    <option value="">Seleccionar...</option>
                    @foreach(App\Models\HistoriaPsicologica::GRADOS_INSTRUCCION as $key => $value)
                    <option value="{{ $key }}" {{ old('grado_instruccion')==$key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Estado Civil -->
            <div class="form-group">
                <label for="estado_civil">Estado Civil</label>
                <select name="estado_civil" id="estado_civil">
                    <option value="">Seleccionar...</option>
                    @foreach(App\Models\HistoriaPsicologica::ESTADOS_CIVILES as $key => $value)
                    <option value="{{ $key }}" {{ old('estado_civil')==$key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Ocupación -->
            <div class="form-group">
                <label for="ocupacion">Ocupación</label>
                <input type="text" name="ocupacion" id="ocupacion" value="{{ old('ocupacion') }}"
                    placeholder="Ej: Estudiante, Empleado, etc.">
            </div>

            <!-- Teléfono -->
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $consultante->telefono) }}"
                    placeholder="999 999 999">
            </div>

            <!-- Residencia -->
            <div class="form-group">
                <label for="residencia">Residencia</label>
                <input type="text" name="residencia" id="residencia" value="{{ old('residencia') }}"
                    placeholder="Dirección actual">
            </div>

            <!-- Religión -->
            <div class="form-group">
                <label for="religion">Religión</label>
                <input type="text" name="religion" id="religion" value="{{ old('religion') }}"
                    placeholder="Católica, Evangélica, etc.">
            </div>

            <!-- Natural de -->
            <div class="form-group">
                <label for="natural_de">Natural de</label>
                <input type="text" name="natural_de" id="natural_de" value="{{ old('natural_de') }}"
                    placeholder="Ciudad/Región de nacimiento">
            </div>

            <!-- Tiempo de Residencia en Lima -->
            <div class="form-group">
                <label for="tiempo_residencia_lima">Tiempo de Residencia en Lima</label>
                <input type="text" name="tiempo_residencia_lima" id="tiempo_residencia_lima"
                    value="{{ old('tiempo_residencia_lima') }}" placeholder="Ej: 10 años, toda la vida">
            </div>
        </div>

        <!-- Persona Responsable -->
        <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">
        <h3 style="margin-bottom: 1rem; color: var(--secondary); font-size: 1rem;">Persona Responsable</h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label for="persona_responsable">Nombre Completo</label>
                <input type="text" name="persona_responsable" id="persona_responsable"
                    value="{{ old('persona_responsable') }}" placeholder="Nombre de la persona responsable">
            </div>

            <div class="form-group">
                <label for="parentesco_responsable">Parentesco</label>
                <input type="text" name="parentesco_responsable" id="parentesco_responsable"
                    value="{{ old('parentesco_responsable') }}" placeholder="Padre, Madre, Tutor, etc.">
            </div>

            <div class="form-group">
                <label for="telefono_responsable">Teléfono</label>
                <input type="text" name="telefono_responsable" id="telefono_responsable"
                    value="{{ old('telefono_responsable') }}" placeholder="999 999 999">
            </div>
        </div>

        <!-- Asisten a Primera Consulta -->
        <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">
        <h3 style="margin-bottom: 1rem; color: var(--secondary); font-size: 1rem;">Asisten a Primera Consulta</h3>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="asisten_primera_consulta">¿Quiénes asisten?</label>
                <input type="text" name="asisten_primera_consulta" id="asisten_primera_consulta"
                    value="{{ old('asisten_primera_consulta') }}" placeholder="Nombres de quienes asisten">
            </div>

            <div class="form-group">
                <label for="telefono_primera_consulta">Teléfono</label>
                <input type="text" name="telefono_primera_consulta" id="telefono_primera_consulta"
                    value="{{ old('telefono_primera_consulta') }}" placeholder="999 999 999">
            </div>
        </div>

        <!-- Datos de la Entrevista -->
        <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">
        <h3 style="margin-bottom: 1rem; color: var(--secondary); font-size: 1rem;">Datos de la Entrevista</h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label for="lugar_entrevista">Lugar de la Entrevista</label>
                <input type="text" name="lugar_entrevista" id="lugar_entrevista"
                    value="{{ old('lugar_entrevista', 'Los Olivos (P) (V)') }}">
            </div>

            <div class="form-group">
                <label for="terapeuta">Terapeuta Asignado</label>
                <input type="text" name="terapeuta" id="terapeuta" value="{{ old('terapeuta') }}"
                    placeholder="Nombre del terapeuta">
            </div>
        </div>

        <!-- Recomendado por -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="recomendado_por">Recomendado por</label>
                <select name="recomendado_por" id="recomendado_por" onchange="toggleRecomendadoDetalle()">
                    <option value="">Seleccionar...</option>
                    @foreach(App\Models\HistoriaPsicologica::RECOMENDADO_POR as $key => $value)
                    <option value="{{ $key }}" {{ old('recomendado_por')==$key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="recomendado_detalle_group" style="display: none;">
                <label for="recomendado_detalle">Especificar</label>
                <input type="text" name="recomendado_detalle" id="recomendado_detalle"
                    value="{{ old('recomendado_detalle') }}" placeholder="Especifique">
            </div>
        </div>
    </div>

    <!-- B) MOTIVO DE CONSULTA -->
    {{-- <div class="card">
        <div class="card-header">B) MOTIVO DE CONSULTA</div>

        <div class="form-group">
            <label for="motivo_consulta">Motivo de Consulta *</label>
            <textarea name="motivo_consulta" id="motivo_consulta" rows="4" required
                placeholder="Describa el motivo principal de la consulta...">{{ old('motivo_consulta') }}</textarea>
        </div>
    </div> --}}

    <!-- C) PROBLEMA ACTUAL -->
    {{-- <div class="card">
        <div class="card-header">C) PROBLEMA ACTUAL</div>

        @for($i = 1; $i <= 5; $i++) <div class="form-group">
            <label for="problema_actual_{{ $i }}">Problema {{ $i }}</label>
            <textarea name="problema_actual_{{ $i }}" id="problema_actual_{{ $i }}" rows="2"
                placeholder="Describa el problema {{ $i }}...">{{ old("problema_actual_$i") }}</textarea>
    </div>
    @endfor
    </div> --}}

    <!-- Botones de Acción -->
    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
        <a href="{{ route('historias.nueva') }}" class="btn btn-secondary">
            Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
            💾 Crear Historia Psicológica
        </button>
    </div>
</form>

<script>
    function toggleRecomendadoDetalle() {
    const recomendadoPor = document.getElementById('recomendado_por').value;
    const detalleGroup = document.getElementById('recomendado_detalle_group');
    const detalleInput = document.getElementById('recomendado_detalle');

    if (recomendadoPor === 'Otros') {
        detalleGroup.style.display = 'block';
        detalleInput.setAttribute('required', 'required');
    } else {
        detalleGroup.style.display = 'none';
        detalleInput.removeAttribute('required');
        detalleInput.value = '';
    }
}

// Ejecutar al cargar si ya hay valor
document.addEventListener('DOMContentLoaded', toggleRecomendadoDetalle);
</script>
@endsection
