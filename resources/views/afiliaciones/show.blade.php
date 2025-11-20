@extends('layouts.app')

@section('title', 'Ver Afiliación')
@section('page-title', 'Detalles de Afiliación')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/document-preview.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span>👤 Información de Afiliación</span>
            <div>
                <a href="{{ route('afiliaciones.edit', $afiliacion) }}" class="btn btn-warning">
                    ✏️ Editar
                </a>
                <a href="{{ route('afiliaciones.index') }}" class="btn btn-secondary">
                    ← Volver
                </a>
            </div>
        </div>
    </div>

    <!-- DATOS PERSONALES -->
    <div class="info-section">
        <h3 class="section-title">📋 Datos Personales</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Nombres y Apellidos:</label>
                <span>{{ $afiliacion->nombres_apellidos }}</span>
            </div>
            <div class="info-item">
                <label>Edad:</label>
                <span>{{ $afiliacion->edad_calculada ?? $afiliacion->edad }} años</span>
            </div>
            <div class="info-item">
                <label>Fecha de Nacimiento:</label>
                <span>{{ $afiliacion->fecha_nacimiento ? $afiliacion->fecha_nacimiento->format('d/m/Y') : '-' }}</span>
            </div>
            <div class="info-item">
                <label>Lugar de Nacimiento:</label>
                <span>{{ $afiliacion->lugar_nacimiento ?? '-' }}</span>
            </div>
            <div class="info-item">
                <label>Sexo:</label>
                <span>{{ $afiliacion->sexo }}</span>
            </div>
            <div class="info-item">
                <label>Documento de Identidad:</label>
                <span>{{ $afiliacion->documento_identidad ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- CONTACTO -->
    <div class="info-section">
        <h3 class="section-title">📞 Información de Contacto</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Teléfono:</label>
                <span>{{ $afiliacion->telefono ?? '-' }}</span>
            </div>
            <div class="info-item">
                <label>Correo Electrónico:</label>
                <span>{{ $afiliacion->correo_electronico ?? '-' }}</span>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
                <label>Dirección:</label>
                <span>{{ $afiliacion->direccion ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- INFORMACIÓN ACADÉMICA Y LABORAL -->
    <div class="info-section">
        <h3 class="section-title">🎓 Información Académica y Laboral</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Grado de Instrucción:</label>
                <span>{{ $afiliacion->grado_instruccion ?? '-' }}</span>
            </div>
            <div class="info-item">
                <label>Ocupación:</label>
                <span>{{ $afiliacion->ocupacion ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- INFORMACIÓN PERSONAL -->
    <div class="info-section">
        <h3 class="section-title">💑 Información Personal</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Estado Civil:</label>
                <span>{{ $afiliacion->estado_civil ?? '-' }}</span>
            </div>
            <div class="info-item">
                <label>Religión:</label>
                <span>{{ $afiliacion->religion ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- CONTACTO DE EMERGENCIA -->
    <div class="info-section">
        <h3 class="section-title">🚨 Contacto de Emergencia</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Nombre:</label>
                <span>{{ $afiliacion->contacto_emergencia_nombre ?? '-' }}</span>
            </div>
            <div class="info-item">
                <label>Teléfono:</label>
                <span>{{ $afiliacion->contacto_emergencia_telefono ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- REFERENCIA -->
    <div class="info-section">
        <h3 class="section-title">🔗 Referencia</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Referido por:</label>
                <span>{{ $afiliacion->referido_por ?? '-' }}</span>
            </div>
            @if($afiliacion->referido_detalle)
            <div class="info-item">
                <label>
                    @if($afiliacion->referido_por == 'Redes Sociales')
                        Red Social:
                    @elseif($afiliacion->referido_por == 'Amigo')
                        Nombre del amigo:
                    @elseif($afiliacion->referido_por == 'Médico' || $afiliacion->referido_por == 'Psicólogo')
                        Nombre del {{ strtolower($afiliacion->referido_por) }}:
                    @elseif($afiliacion->referido_por == 'Familiar')
                        Parentesco y nombre:
                    @else
                        Detalle:
                    @endif
                </label>
                <span>{{ $afiliacion->referido_detalle }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- DOCUMENTOS -->
    <div class="info-section">
        <h3 class="section-title">📎 Documentos Adjuntos</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Consentimiento Informado:</label>
                @if($afiliacion->consentimiento_informado)
                    <div class="document-actions">
                        <a href="{{ $afiliacion->consentimiento_url }}" target="_blank" class="btn btn-sm btn-info">
                            📄 Ver Documento
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-preview"
                                onclick="previewDocument('{{ $afiliacion->consentimiento_url }}', 'Consentimiento Informado', '{{ pathinfo($afiliacion->consentimiento_informado, PATHINFO_EXTENSION) }}')">
                            <i class="fas fa-eye"></i> Vista Previa
                        </button>
                    </div>
                @else
                    <span class="text-muted">No adjuntado</span>
                @endif
            </div>
            <div class="info-item">
                <label>Contrato Terapéutico:</label>
                @if($afiliacion->contrato_terapeutico)
                    <div class="document-actions">
                        <a href="{{ $afiliacion->contrato_url }}" target="_blank" class="btn btn-sm btn-info">
                            📄 Ver Documento
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-preview"
                                onclick="previewDocument('{{ $afiliacion->contrato_url }}', 'Contrato Terapéutico', '{{ pathinfo($afiliacion->contrato_terapeutico, PATHINFO_EXTENSION) }}')">
                            <i class="fas fa-eye"></i> Vista Previa
                        </button>
                    </div>
                @else
                    <span class="text-muted">No adjuntado</span>
                @endif
            </div>
        </div>
    </div>

    <!-- METADATA -->
    <div class="info-section">
        <h3 class="section-title">📅 Información de Registro</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Fecha de Creación de Historia:</label>
                <span>{{ $afiliacion->fecha_creacion_historia->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <label>Fecha de Registro en Sistema:</label>
                <span>{{ $afiliacion->created_at->format('d/m/Y H:i') }}</span>
            </div>
            @if($afiliacion->observaciones)
            <div class="info-item" style="grid-column: 1 / -1;">
                <label>Observaciones:</label>
                <span>{{ $afiliacion->observaciones }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- HISTORIA PSICOLÓGICA -->
    <div class="info-section">
        <h3 class="section-title">📋 Historia Psicológica</h3>
        @if($afiliacion->tieneHistoria())
            <div class="alert alert-success">
                <p>✅ Esta afiliación tiene una historia psicológica registrada.</p>
                <a href="{{ route('historias.show', $afiliacion->historiaPsicologica) }}" class="btn btn-info">
                    📄 Ver Historia Completa
                </a>
            </div>
        @else
            <div class="alert alert-warning">
                <p>⚠️ Esta afiliación aún no tiene una historia psicológica.</p>
                <a href="{{ route('historias.create', $afiliacion) }}" class="btn btn-primary">
                    ➕ Crear Historia Psicológica
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/document-preview.js') }}"></script>
<script>
    function previewDocument(url, title, extension) {
        if (!documentPreview) {
            console.error('El sistema de previsualización no está disponible');
            return;
        }

        // Determinar el tipo de archivo basado en la extensión
        let fileType = 'unknown';
        if (['jpg', 'jpeg', 'png', 'gif'].includes(extension.toLowerCase())) {
            fileType = 'image';
        } else if (extension.toLowerCase() === 'pdf') {
            fileType = 'pdf';
        } else if (['doc', 'docx'].includes(extension.toLowerCase())) {
            fileType = 'word';
        }

        documentPreview.previewExistingFile(url, title, fileType);
    }
</script>
@endpush

@push('styles')
<style>
    .info-section {
        padding: 1.5rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .info-section:last-child {
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

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-item label {
        font-weight: 600;
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    .info-item span {
        color: #2c3e50;
        font-size: 1rem;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        display: inline-block;
    }

    .document-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-preview {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .btn-preview:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .text-muted {
        color: #95a5a6;
        font-style: italic;
    }
</style>
@endpush
