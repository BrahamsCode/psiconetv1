@extends('layouts.app')

@section('title', 'Nueva Afiliación')
@section('page-title', 'Registrar Nueva Afiliación - Datos de Filiación')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/document-preview.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        📋 Registrar Nueva Afiliación
    </div>

    <form action="{{ route('afiliaciones.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- DATOS PERSONALES BÁSICOS -->
        <div class="form-section">
            <h3 class="section-title">Datos Personales</h3>

            <div class="form-group">
                <label for="nombres_apellidos">Nombres y Apellidos *</label>
                <input type="text" id="nombres_apellidos" name="nombres_apellidos"
                       value="{{ old('nombres_apellidos') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento *</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                           value="{{ old('fecha_nacimiento') }}" required>
                </div>

                <div class="form-group">
                    <label for="edad">Edad <small>(calculada automáticamente)</small></label>
                    <input type="number" id="edad" name="edad"
                           value="{{ old('edad') }}" min="0" max="120" readonly
                           style="background-color: #f5f5f5;">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="lugar_nacimiento">Lugar de Nacimiento</label>
                    <input type="text" id="lugar_nacimiento" name="lugar_nacimiento"
                           value="{{ old('lugar_nacimiento') }}" placeholder="Ej: Lima, Perú">
                </div>

                <div class="form-group">
                    <label for="sexo">Sexo (Según lo refiera el paciente) *</label>
                    <select id="sexo" name="sexo" required>
                        <option value="">Seleccione...</option>
                        @foreach(\App\Models\Afiliacion::SEXOS as $key => $value)
                            <option value="{{ $key }}" {{ old('sexo') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="documento_identidad">Documento de Identidad (DNI/CE)</label>
                <input type="text" id="documento_identidad" name="documento_identidad"
                       value="{{ old('documento_identidad') }}"
                       placeholder="Ej: 12345678" maxlength="20">
            </div>
        </div>

        <!-- CONTACTO -->
        <div class="form-section">
            <h3 class="section-title">Información de Contacto</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono">Teléfono(s) de Contacto</label>
                    <input type="text" id="telefono" name="telefono"
                           value="{{ old('telefono') }}" placeholder="Ej: 987654321">
                </div>

                <div class="form-group">
                    <label for="correo_electronico">Correo Electrónico</label>
                    <input type="email" id="correo_electronico" name="correo_electronico"
                           value="{{ old('correo_electronico') }}"
                           placeholder="ejemplo@correo.com">
                </div>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion"
                       value="{{ old('direccion') }}"
                       placeholder="Dirección completa">
            </div>
        </div>

        <!-- INFORMACIÓN ACADÉMICA Y LABORAL -->
        <div class="form-section">
            <h3 class="section-title">Información Académica y Laboral</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="grado_instruccion">Grado de Instrucción</label>
                    <select id="grado_instruccion" name="grado_instruccion">
                        <option value="">Seleccione...</option>
                        @foreach(\App\Models\Afiliacion::GRADOS_INSTRUCCION as $key => $value)
                            <option value="{{ $key }}" {{ old('grado_instruccion') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="ocupacion">Ocupación</label>
                    <input type="text" id="ocupacion" name="ocupacion"
                           value="{{ old('ocupacion') }}"
                           placeholder="Ej: Estudiante, Ingeniero, etc.">
                </div>
            </div>
        </div>

        <!-- INFORMACIÓN PERSONAL -->
        <div class="form-section">
            <h3 class="section-title">Información Personal</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="estado_civil">Estado Civil</label>
                    <select id="estado_civil" name="estado_civil">
                        <option value="">Seleccione...</option>
                        @foreach(\App\Models\Afiliacion::ESTADOS_CIVILES as $key => $value)
                            <option value="{{ $key }}" {{ old('estado_civil') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="religion">Religión</label>
                    <input type="text" id="religion" name="religion"
                           value="{{ old('religion') }}" placeholder="Opcional">
                </div>
            </div>
        </div>

        <!-- CONTACTO DE EMERGENCIA -->
        <div class="form-section">
            <h3 class="section-title">Persona de Contacto en Emergencia</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="contacto_emergencia_nombre">Nombre Completo</label>
                    <input type="text" id="contacto_emergencia_nombre" name="contacto_emergencia_nombre"
                           value="{{ old('contacto_emergencia_nombre') }}"
                           placeholder="Nombre del contacto de emergencia">
                </div>

                <div class="form-group">
                    <label for="contacto_emergencia_telefono">Teléfono</label>
                    <input type="text" id="contacto_emergencia_telefono" name="contacto_emergencia_telefono"
                           value="{{ old('contacto_emergencia_telefono') }}"
                           placeholder="Teléfono del contacto">
                </div>
            </div>
        </div>

        <!-- REFERENCIA -->
        <div class="form-section">
            <h3 class="section-title">Referencia</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="referido_por">Referido por (Quién lo derivó a consulta)</label>
                    <select id="referido_por" name="referido_por">
                        <option value="">Seleccione...</option>
                        @foreach(\App\Models\Afiliacion::REFERIDO_POR as $key => $value)
                            <option value="{{ $key }}" {{ old('referido_por') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Contenedor dinámico para detalles -->
                <div class="form-group" id="referido_detalle_container" style="display: none;">
                    <!-- Input de texto para Amigo, Médico, Psicólogo, etc. -->
                    <div id="detalle_texto_group" style="display: none;">
                        <label for="referido_detalle_texto" id="label_detalle_texto">Especifique</label>
                        <input type="text"
                               id="referido_detalle_texto"
                               value="{{ old('referido_detalle') }}"
                               placeholder="Especifique detalles">
                    </div>

                    <!-- Select para Redes Sociales -->
                    <div id="detalle_redes_group" style="display: none;">
                        <label for="referido_detalle_redes">Seleccione la red social</label>
                        <select id="referido_detalle_redes">
                            <option value="">Seleccione...</option>
                            @foreach(\App\Models\Afiliacion::REDES_SOCIALES as $key => $value)
                                <option value="{{ $key }}" {{ old('referido_detalle') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- DOCUMENTOS -->
        <div class="form-section">
            <h3 class="section-title">Documentos Adjuntos</h3>

            <div class="form-group">
                <label for="consentimiento_informado">
                    Consentimiento Informado Firmado
                    <small>(PDF, Word o Imagen - Máx. 5MB)</small>
                </label>
                <div class="file-input-group">
                    <input type="file"
                           id="consentimiento_informado"
                           name="consentimiento_informado"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           onchange="handleFileSelect(this, 'consentimiento')">
                </div>
                <div id="consentimiento-preview-container" class="file-preview-container" style="display:none;">
                    <span class="file-selected-info">
                        <i class="fas fa-file"></i>
                        <span id="consentimiento-filename"></span>
                    </span>
                    <button type="button"
                            class="btn-preview"
                            id="consentimiento-preview-btn"
                            onclick="previewSelectedFile('consentimiento_informado')">
                        <i class="fas fa-eye"></i> Ver vista previa
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="contrato_terapeutico">
                    Contrato Terapéutico
                    <small>(PDF, Word o Imagen - Máx. 5MB)</small>
                </label>
                <div class="file-input-group">
                    <input type="file"
                           id="contrato_terapeutico"
                           name="contrato_terapeutico"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           onchange="handleFileSelect(this, 'contrato')">
                </div>
                <div id="contrato-preview-container" class="file-preview-container" style="display:none;">
                    <span class="file-selected-info">
                        <i class="fas fa-file"></i>
                        <span id="contrato-filename"></span>
                    </span>
                    <button type="button"
                            class="btn-preview"
                            id="contrato-preview-btn"
                            onclick="previewSelectedFile('contrato_terapeutico')">
                        <i class="fas fa-eye"></i> Ver vista previa
                    </button>
                </div>
            </div>
        </div>

        <!-- METADATA -->
        <div class="form-section">
            <h3 class="section-title">Información de Registro</h3>

            <div class="form-group">
                <label for="fecha_creacion_historia">Fecha de Creación de Historia *</label>
                <input type="date" id="fecha_creacion_historia" name="fecha_creacion_historia"
                       value="{{ old('fecha_creacion_historia', date('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones Generales</label>
                <textarea id="observaciones" name="observaciones" rows="4">{{ old('observaciones') }}</textarea>
            </div>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">💾 Guardar Afiliación</button>
            <a href="{{ route('afiliaciones.index') }}" class="btn btn-secondary">❌ Cancelar</a>
        </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('assets/js/document-preview.js') }}"></script>

<script>
    let selectedFiles = {};

    function handleFileSelect(input, type) {
        const file = input.files[0];
        const previewContainer = document.getElementById(`${type}-preview-container`);
        const filenameSpan = document.getElementById(`${type}-filename`);

        if (file) {
            selectedFiles[input.id] = file;

            previewContainer.style.display = 'flex';
            filenameSpan.textContent = file.name;
        } else {
            previewContainer.style.display = 'none';
            delete selectedFiles[input.id];
        }
    }

    function previewSelectedFile(inputId) {
        const file = selectedFiles[inputId];
        if (file && documentPreview) {
            documentPreview.previewFile(file);
        }
    }

    function calcularEdad() {
        const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
        const edadInput = document.getElementById('edad');

        if (fechaNacimiento) {
            const hoy = new Date();
            const nacimiento = new Date(fechaNacimiento);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const mes = hoy.getMonth() - nacimiento.getMonth();

            if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }

            edadInput.value = edad >= 0 ? edad : 0;
        } else {
            edadInput.value = '';
        }
    }

    // Función para manejar el campo referido_detalle dinámicamente
    function actualizarCampoReferidoDetalle() {
        const referidoPor = document.getElementById('referido_por');
        const detalleContainer = document.getElementById('referido_detalle_container');
        const detalleTextoGroup = document.getElementById('detalle_texto_group');
        const detalleRedesGroup = document.getElementById('detalle_redes_group');
        const labelDetalleTexto = document.getElementById('label_detalle_texto');
        const inputTexto = document.getElementById('referido_detalle_texto');
        const selectRedes = document.getElementById('referido_detalle_redes');

        const valor = referidoPor.value;

        // Resetear displays
        detalleContainer.style.display = 'none';
        detalleTextoGroup.style.display = 'none';
        detalleRedesGroup.style.display = 'none';

        // Limpiar los name attributes
        inputTexto.removeAttribute('name');
        selectRedes.removeAttribute('name');
        inputTexto.required = false;
        selectRedes.required = false;

        switch(valor) {
            case 'Amigo':
                detalleContainer.style.display = 'block';
                detalleTextoGroup.style.display = 'block';
                labelDetalleTexto.textContent = 'Nombre del amigo (opcional)';
                inputTexto.placeholder = 'Ingrese el nombre del amigo';
                inputTexto.setAttribute('name', 'referido_detalle');
                break;

            case 'Redes Sociales':
                detalleContainer.style.display = 'block';
                detalleRedesGroup.style.display = 'block';
                selectRedes.setAttribute('name', 'referido_detalle');
                selectRedes.required = true;
                break;

            case 'Otros':
                detalleContainer.style.display = 'block';
                detalleTextoGroup.style.display = 'block';
                labelDetalleTexto.textContent = 'Especifique *';
                inputTexto.placeholder = 'Especifique quién lo refirió';
                inputTexto.setAttribute('name', 'referido_detalle');
                inputTexto.required = true;
                break;

            case 'Médico':
            case 'Psicólogo':
                detalleContainer.style.display = 'block';
                detalleTextoGroup.style.display = 'block';
                labelDetalleTexto.textContent = `Nombre del ${valor} (opcional)`;
                inputTexto.placeholder = `Ingrese el nombre del ${valor.toLowerCase()}`;
                inputTexto.setAttribute('name', 'referido_detalle');
                break;

            case 'Familiar':
                detalleContainer.style.display = 'block';
                detalleTextoGroup.style.display = 'block';
                labelDetalleTexto.textContent = 'Parentesco y nombre (opcional)';
                inputTexto.placeholder = 'Ej: Hermana - María García';
                inputTexto.setAttribute('name', 'referido_detalle');
                break;

            case 'Alumno':
            case 'Paciente':
                detalleContainer.style.display = 'block';
                detalleTextoGroup.style.display = 'block';
                labelDetalleTexto.textContent = `Nombre del ${valor.toLowerCase()} (opcional)`;
                inputTexto.placeholder = `Ingrese el nombre del ${valor.toLowerCase()}`;
                inputTexto.setAttribute('name', 'referido_detalle');
                break;
        }
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Calcular edad al cargar
        calcularEdad();

        // Listener para fecha de nacimiento
        document.getElementById('fecha_nacimiento').addEventListener('change', calcularEdad);

        // Listener para referido_por
        document.getElementById('referido_por').addEventListener('change', actualizarCampoReferidoDetalle);

        // Cargar estado inicial si hay valores old
        if (document.getElementById('referido_por').value) {
            actualizarCampoReferidoDetalle();
        }
    });
</script>
@endpush

<style>
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #3498db;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    small {
        color: #7f8c8d;
        font-size: 0.85rem;
    }

    #referido_detalle_container {
        transition: all 0.3s ease;
    }

    #detalle_texto_group input,
    #detalle_redes_group select {
        transition: all 0.3s ease;
    }

    .form-group input[type="file"] {
        padding: 0.5rem;
        border: 2px dashed #cbd5e0;
        border-radius: 4px;
        background: #f7fafc;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .form-group input[type="file"]:hover {
        border-color: #4299e1;
        background: #ebf8ff;
    }

    .form-group input[type="file"]:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
</style>
@endsection
