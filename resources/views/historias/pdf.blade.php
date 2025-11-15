<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Historia Psicológica #{{ $historia->numero_historia }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2c5aa0;
        }

        .header h1 {
            color: #2c5aa0;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #2c5aa0;
            color: white;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .section-content {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .field-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .field-row {
            display: table-row;
        }

        .field {
            display: table-cell;
            padding: 5px;
            width: 50%;
            vertical-align: top;
        }

        .field strong {
            color: #2c5aa0;
            display: block;
            margin-bottom: 2px;
            font-size: 10px;
        }

        .field-value {
            color: #333;
        }

        .divider {
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }

        .subsection-title {
            color: #2c5aa0;
            font-weight: bold;
            margin: 10px 0 5px 0;
            font-size: 11px;
        }

        .text-content {
            white-space: pre-wrap;
            line-height: 1.6;
        }

        .problema-item {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f9f9f9;
            border-left: 3px solid #2c5aa0;
        }

        .problema-item strong {
            color: #2c5aa0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background-color: #2c5aa0;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }

        table td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #999;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .page-number:before {
            content: "Página " counter(page);
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>HISTORIA PSICOLÓGICA</h1>
        <p>N°: {{ $historia->numero_historia }} | Fecha: {{ $historia->fecha_historia->format('d/m/Y') }}</p>
    </div>

    <!-- A) DATOS DE FILIACIÓN -->
    <div class="section">
        <div class="section-title">A) DATOS DE FILIACIÓN</div>
        <div class="section-content">
            <div class="field-grid">
                <div class="field-row">
                    <div class="field">
                        <strong>Nombre:</strong>
                        <span class="field-value">{{ $historia->consultante->nombre }}</span>
                    </div>
                    <div class="field">
                        <strong>Edad:</strong>
                        <span class="field-value">{{ $historia->consultante->edad }} años</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <strong>Género:</strong>
                        <span class="field-value">{{ $historia->genero ?? '-' }}</span>
                    </div>
                    <div class="field">
                        <strong>Grado de Instrucción:</strong>
                        <span class="field-value">{{ $historia->grado_instruccion ?? '-' }}</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <strong>Estado Civil:</strong>
                        <span class="field-value">{{ $historia->estado_civil ?? '-' }}</span>
                    </div>
                    <div class="field">
                        <strong>Ocupación:</strong>
                        <span class="field-value">{{ $historia->ocupacion ?? '-' }}</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <strong>Teléfono:</strong>
                        <span class="field-value">{{ $historia->telefono ?? '-' }}</span>
                    </div>
                    <div class="field">
                        <strong>Residencia:</strong>
                        <span class="field-value">{{ $historia->residencia ?? '-' }}</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <strong>Religión:</strong>
                        <span class="field-value">{{ $historia->religion ?? '-' }}</span>
                    </div>
                    <div class="field">
                        <strong>Natural de:</strong>
                        <span class="field-value">{{ $historia->natural_de ?? '-' }}</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <strong>Tiempo en Lima:</strong>
                        <span class="field-value">{{ $historia->tiempo_residencia_lima ?? '-' }}</span>
                    </div>
                    <div class="field">
                        <strong>DNI:</strong>
                        <span class="field-value">{{ $historia->consultante->dni ?? '-' }}</span>
                    </div>
                </div>
            </div>

            @if($historia->persona_responsable)
            <div class="divider"></div>
            <div class="subsection-title">Persona Responsable</div>
            <div class="field-grid">
                <div class="field-row">
                    <div class="field">
                        <strong>Nombre:</strong>
                        <span class="field-value">{{ $historia->persona_responsable }}</span>
                    </div>
                    <div class="field">
                        <strong>Parentesco:</strong>
                        <span class="field-value">{{ $historia->parentesco_responsable ?? '-' }}</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <strong>Teléfono:</strong>
                        <span class="field-value">{{ $historia->telefono_responsable ?? '-' }}</span>
                    </div>
                    <div class="field"></div>
                </div>
            </div>
            @endif

            @if($historia->asisten_primera_consulta)
            <div class="divider"></div>
            <div class="subsection-title">Primera Consulta</div>
            <div class="field-grid">
                <div class="field-row">
                    <div class="field">
                        <strong>Asisten:</strong>
                        <span class="field-value">{{ $historia->asisten_primera_consulta }}</span>
                    </div>
                    <div class="field">
                        <strong>Teléfono:</strong>
                        <span class="field-value">{{ $historia->telefono_primera_consulta ?? '-' }}</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="divider"></div>
            <div class="subsection-title">Datos de la Entrevista</div>
            <div class="field-grid">
                <div class="field-row">
                    <div class="field">
                        <strong>Lugar:</strong>
                        <span class="field-value">{{ $historia->lugar_entrevista ?? '-' }}</span>
                    </div>
                    <div class="field">
                        <strong>Fecha:</strong>
                        <span class="field-value">{{ $historia->fecha_historia->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <strong>Terapeuta:</strong>
                        <span class="field-value">{{ $historia->terapeuta ?? '-' }}</span>
                    </div>
                    <div class="field">
                        <strong>Recomendado por:</strong>
                        <span class="field-value">
                            {{ $historia->recomendado_por ?? '-' }}
                            @if($historia->recomendado_detalle)
                                ({{ $historia->recomendado_detalle }})
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- B) MOTIVO DE CONSULTA -->
    <div class="section">
        <div class="section-title">B) MOTIVO DE CONSULTA</div>
        <div class="section-content">
            <p class="text-content">{{ $historia->motivo_consulta ?? 'No especificado' }}</p>
        </div>
    </div>

    <!-- C) PROBLEMA ACTUAL -->
    @if($historia->problemas_actuales && count($historia->problemas_actuales) > 0)
    <div class="section">
        <div class="section-title">C) PROBLEMA ACTUAL</div>
        <div class="section-content">
            @foreach($historia->problemas_actuales as $index => $problema)
            <div class="problema-item">
                <strong>Problema {{ $index + 1 }}:</strong>
                <p class="text-content" style="margin-top: 5px;">{{ $problema }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- D) CONSUMO DE SUSTANCIAS -->
    @if($historia->consumoSustancias && $historia->consumoSustancias->count() > 0)
    <div class="section">
        <div class="section-title">D) CONSUMO DE SUSTANCIAS</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Droga</th>
                        <th>Edad Inicio</th>
                        <th>Frecuencia</th>
                        <th>Última Vez</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historia->consumoSustancias as $consumo)
                    <tr>
                        <td>{{ $consumo->tipo_droga }}</td>
                        <td>{{ $consumo->edad_inicio ?? '-' }}</td>
                        <td>{{ $consumo->frecuencia ?? '-' }}</td>
                        <td>{{ $consumo->ultima_vez ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- E) TRATAMIENTOS PREVIOS -->
    @if($historia->tratamientosPrevios && $historia->tratamientosPrevios->count() > 0)
    <div class="section">
        <div class="section-title">E) TRATAMIENTOS PREVIOS</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Lugar</th>
                        <th>Duración</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historia->tratamientosPrevios as $tratamiento)
                    <tr>
                        <td>{{ $tratamiento->tipo_tratamiento }}</td>
                        <td>{{ $tratamiento->lugar ?? '-' }}</td>
                        <td>{{ $tratamiento->duracion ?? '-' }}</td>
                        <td>{{ $tratamiento->resultado ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- F) CONDUCTAS PROBLEMA -->
    @if($historia->conductasProblema && $historia->conductasProblema->count() > 0)
    <div class="section">
        <div class="section-title">F) CONDUCTAS PROBLEMA Y OBJETIVOS TERAPÉUTICOS</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Conducta Problema</th>
                        <th>Objetivo Terapéutico</th>
                        <th>Procedimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historia->conductasProblema as $conducta)
                    <tr>
                        <td>{{ $conducta->numero_orden }}</td>
                        <td>{{ $conducta->conducta_problema }}</td>
                        <td>{{ $conducta->objetivo_terapeutico ?? '-' }}</td>
                        <td>{{ $conducta->procedimiento ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Pie de página -->
    <div class="footer">
        <p>Historia Psicológica N° {{ $historia->numero_historia }} | Generado: {{ now()->format('d/m/Y H:i') }}</p>
        <p class="page-number"></p>
    </div>
</body>
</html>
