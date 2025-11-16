@extends('layouts.app')

@section('title', 'Fase del Consumo')

@section('page-title', 'Fase del Consumo')

@section('content')
<!-- Breadcrumb -->
<div style="margin-bottom: 1rem;">
    <a href="{{ route('consumo.index') }}" class="btn btn-secondary btn-sm">
        ← Volver a Lista de Consultantes
    </a>
</div>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <strong style="font-size: 1.25rem;">Gráfico de Fase del Consumo</strong>
            <br>
            <small class="text-muted">Las fases progresan automáticamente según tiempo de consumo</small>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn btn-sm" style="background: var(--info); color: white;" onclick="exportChart()">
                📸 Descargar Imagen
            </button>
            <button class="btn btn-primary btn-sm" onclick="toggleFormModal()">
                ➕ Agregar Consumo
            </button>
        </div>
    </div>

    <!-- Canvas para Chart.js -->
    <div style="padding: 2rem; background: white;">
        <canvas id="consumoChart" style="max-height: 550px;"></canvas>
    </div>
</div>

<!-- Información de Progresión -->
<div class="card">
    <div class="card-header">ℹ️ Cómo se Calcula la Progresión de Fases</div>
    <div style="padding: 1rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div style="padding: 1rem; background: var(--primary-light); border-radius: 8px;">
            <strong>🟢 Experimental</strong><br>
            <small>0 - 1 año de consumo</small>
        </div>
        <div style="padding: 1rem; background: var(--info-light); border-radius: 8px;">
            <strong>🔵 Social</strong><br>
            <small>1 - 2 años de consumo</small>
        </div>
        <div style="padding: 1rem; background: var(--warning-light); border-radius: 8px;">
            <strong>🟡 Habitual</strong><br>
            <small>2 - 4 años de consumo</small>
        </div>
        <div style="padding: 1rem; background: var(--error-light); border-radius: 8px;">
            <strong>🔴 Adicto</strong><br>
            <small>4+ años de consumo</small>
        </div>
    </div>
</div>

<!-- Leyenda de Drogas -->
<div class="card">
    <div class="card-header">Drogas Registradas</div>
    <div id="drugLegend" style="display: flex; flex-wrap: wrap; gap: 1rem; padding: 1rem;">
        @if($consumos->isEmpty())
            <p class="text-muted">No hay drogas registradas aún.</p>
        @endif
    </div>
</div>

<!-- Tabla de datos registrados -->
<div class="card">
    <div class="card-header">Datos Registrados</div>
    <table>
        <thead>
            <tr>
                <th>Sustancia</th>
                <th>Fase Inicial</th>
                <th>Edad Inicio</th>
                <th>Edad Fin</th>
                <th>Años de Consumo</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consumos as $consumo)
            <tr>
                <td><strong>{{ $consumo->nombre_droga }}</strong></td>
                <td>
                    <span class="badge badge-{{
                        $consumo->fase_consumo === 'adicto' ? 'error' :
                        ($consumo->fase_consumo === 'habitual' ? 'warning' :
                        ($consumo->fase_consumo === 'social' ? 'info' : 'secondary'))
                    }}">
                        {{ $consumo->nombre_fase }}
                    </span>
                </td>
                <td>{{ $consumo->edad_inicio }} años</td>
                <td>{{ $consumo->edad_fin ? $consumo->edad_fin . ' años' : 'Actualidad' }}</td>
                <td>
                    @php
                        $aniosConsumo = $consumo->edad_fin
                            ? ($consumo->edad_fin - $consumo->edad_inicio)
                            : '(en curso)';
                    @endphp
                    {{ is_numeric($aniosConsumo) ? $aniosConsumo . ' años' : $aniosConsumo }}
                </td>
                <td>{{ $consumo->observaciones ?? '-' }}</td>
                <td class="actions">
                    <button class="btn btn-sm btn-secondary"
                            onclick="editConsumo({{ $consumo->id }}, '{{ $consumo->tipo_droga }}', '{{ addslashes($consumo->droga_detalle ?? '') }}', '{{ $consumo->fase_consumo }}', {{ $consumo->edad_inicio }}, {{ $consumo->edad_fin ?? 'null' }}, '{{ addslashes($consumo->tiempo_consumo ?? '') }}', '{{ addslashes($consumo->observaciones ?? '') }}')">
                        ✏️ Editar
                    </button>
                    <form action="{{ route('consumo.destroy', $consumo) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Eliminar este registro?')">
                            🗑️ Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                    No hay datos registrados. Agregue información de consumo usando el botón "Agregar Consumo".
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal para agregar/editar -->
<div id="formModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="card" style="width: 90%; max-width: 600px; margin: 2rem auto; max-height: 90vh; overflow-y: auto;">
        <div class="card-header">
            <span id="modalTitle">Agregar Consumo</span>
            <button onclick="toggleFormModal()" style="float: right; background: none; border: none; font-size: 1.5rem; cursor: pointer;">×</button>
        </div>

        <form id="consumoForm" method="POST" action="{{ route('consumo.store', $historia) }}" style="padding: 1.5rem;">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="form-group">
                <label for="tipo_droga">Tipo de Droga *</label>
                <select name="tipo_droga" id="tipo_droga" required onchange="toggleDrogaDetalle()">
                    <option value="">Seleccionar...</option>
                    @foreach(App\Models\ConsumoSustancia::DROGAS as $key => $nombre)
                        <option value="{{ $key }}">{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="droga_detalle_group" style="display: none;">
                <label for="droga_detalle">Especifique la droga *</label>
                <input type="text" name="droga_detalle" id="droga_detalle" placeholder="Ej: Éxtasis, MDMA, etc.">
                <small class="text-muted">Requerido cuando selecciona "Otros"</small>
            </div>

            <div class="form-group">
                <label for="fase_consumo">Fase de Consumo Inicial *</label>
                <select name="fase_consumo" id="fase_consumo" required>
                    <option value="">Seleccionar...</option>
                    @foreach(App\Models\ConsumoSustancia::FASES as $key => $nombre)
                        <option value="{{ $key }}">{{ $nombre }}</option>
                    @endforeach
                </select>
                <small class="text-muted">El gráfico mostrará la progresión automática según el tiempo</small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="edad_inicio">Edad de Inicio *</label>
                    <input type="number" name="edad_inicio" id="edad_inicio" min="0" max="100" required>
                </div>

                <div class="form-group">
                    <label for="edad_fin">Edad de Fin</label>
                    <input type="number" name="edad_fin" id="edad_fin" min="0" max="100">
                    <small class="text-muted">Dejar vacío si continúa</small>
                </div>
            </div>

            <div class="form-group">
                <label for="tiempo_consumo">Tiempo de Consumo</label>
                <input type="text" name="tiempo_consumo" id="tiempo_consumo" placeholder="Ej: 2 años, 6 meses">
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="3" placeholder="Notas adicionales..."></textarea>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="toggleFormModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<style>
    #formModal.active {
        display: flex !important;
    }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Constantes del modelo
const DROGAS = @json(App\Models\ConsumoSustancia::DROGAS);
const FASES = @json(App\Models\ConsumoSustancia::FASES);
const COLORES_DROGAS = @json(App\Models\ConsumoSustancia::COLORES_DROGAS);
const COLORES_FASES = @json(App\Models\ConsumoSustancia::COLORES_FASES);
const POSICION_FASES = @json(App\Models\ConsumoSustancia::POSICION_FASES);

// Datos del servidor
const consumoData = [
    @foreach($consumos as $consumo)
    {
        id: {{ $consumo->id }},
        tipo_droga: '{{ $consumo->tipo_droga }}',
        droga_nombre: '{{ $consumo->nombre_droga }}',
        fase_consumo: '{{ $consumo->fase_consumo }}',
        fase_nombre: '{{ $consumo->nombre_fase }}',
        edad_inicio: {{ $consumo->edad_inicio }},
        edad_fin: {{ $consumo->edad_fin ?? 'null' }},
        tiempo_consumo: '{{ $consumo->tiempo_consumo ?? '' }}',
        observaciones: '{{ addslashes($consumo->observaciones ?? '') }}'
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
];

const historiaId = {{ $historia->id }};
let myChart = null;

// FUNCIÓN CLAVE: Calcular progresión automática de fases basada en años de consumo
function calcularProgresionFases(edadInicio, edadFin, faseInicial) {
    const puntos = [];
    const edadFinal = edadFin || (edadInicio + 10); // Si no hay fin, proyectar 10 años
    const aniosConsumo = edadFinal - edadInicio;

    // Definir rangos de años para cada fase
    const RANGOS_FASES = {
        experimental: { min: 0, max: 1 },
        social: { min: 1, max: 2 },
        habitual: { min: 2, max: 4 },
        adicto: { min: 4, max: 999 }
    };

    // Orden de progresión
    const ordenFases = ['experimental', 'social', 'habitual', 'adicto'];
    const faseInicialIndex = ordenFases.indexOf(faseInicial);

    // Generar puntos de progresión
    let edadActual = edadInicio;
    let aniosAcumulados = 0;

    for (let i = faseInicialIndex; i < ordenFases.length; i++) {
        const fase = ordenFases[i];
        const rango = RANGOS_FASES[fase];

        // Calcular cuánto tiempo pasa en esta fase
        let tiempoEnFase;
        if (i === ordenFases.length - 1) {
            // Última fase: todo el tiempo restante
            tiempoEnFase = aniosConsumo - aniosAcumulados;
        } else {
            // Otras fases: máximo del rango o tiempo restante
            tiempoEnFase = Math.min(rango.max - rango.min, aniosConsumo - aniosAcumulados);
        }

        if (tiempoEnFase <= 0) break;

        // Punto de inicio de esta fase
        puntos.push({
            edad: edadActual,
            fase: fase,
            aniosEnFase: 0
        });

        // Punto de fin de esta fase
        const edadFinFase = edadActual + tiempoEnFase;
        if (edadFinFase <= edadFinal) {
            puntos.push({
                edad: edadFinFase,
                fase: fase,
                aniosEnFase: tiempoEnFase
            });
        }

        edadActual = edadFinFase;
        aniosAcumulados += tiempoEnFase;

        if (edadActual >= edadFinal) break;
    }

    return puntos;
}

// Detectar superposiciones y calcular offsets
function calcularOffsets(allPoints) {
    const offsets = {};

    allPoints.forEach((punto, index) => {
        let offset = 0;

        // Comparar con puntos anteriores
        for (let i = 0; i < index; i++) {
            const otroPunto = allPoints[i];

            // Si están en la misma edad (±0.5 años) y misma fase
            if (Math.abs(punto.edad - otroPunto.edad) < 0.5 && punto.fase === otroPunto.fase) {
                offset += 0.08;
            }
        }

        offsets[index] = offset;
    });

    return offsets;
}

function drawChart() {
    const ctx = document.getElementById('consumoChart').getContext('2d');

    if (myChart) {
        myChart.destroy();
    }

    // Calcular rango de edades
    let minAge = 0;
    let maxAge = 80;

    if (consumoData.length > 0) {
        const ages = [];
        consumoData.forEach(d => {
            ages.push(d.edad_inicio);
            if (d.edad_fin) ages.push(d.edad_fin);
        });

        if (ages.length > 0) {
            const minEdad = Math.min(...ages);
            const maxEdad = Math.max(...ages);
            minAge = Math.max(0, Math.floor(minEdad / 5) * 5);
            maxAge = Math.min(100, Math.ceil(maxEdad / 5) * 5 + 5);
        }
    }

    if (maxAge - minAge < 10) {
        maxAge = minAge + 10;
    }

    // Preparar datasets con progresión automática
    const datasets = [];
    const allPoints = [];

    consumoData.forEach((droga, drugIndex) => {
        const color = COLORES_DROGAS[droga.tipo_droga] || '#6B7280';

        // Calcular progresión de fases
        const puntosProgresion = calcularProgresionFases(
            droga.edad_inicio,
            droga.edad_fin,
            droga.fase_consumo
        );

        // Guardar puntos para cálculo de offsets
        puntosProgresion.forEach(p => {
            allPoints.push({
                ...p,
                drugIndex: drugIndex,
                droga: droga
            });
        });
    });

    // Calcular offsets
    const offsets = calcularOffsets(allPoints);

    // Agrupar puntos por droga
    const pointsByDrug = {};
    allPoints.forEach((punto, index) => {
        const drugIdx = punto.drugIndex;
        if (!pointsByDrug[drugIdx]) {
            pointsByDrug[drugIdx] = [];
        }

        const offset = offsets[index] || 0;
        pointsByDrug[drugIdx].push({
            x: punto.edad,
            y: POSICION_FASES[punto.fase] + offset,
            metadata: {
                droga: punto.droga.droga_nombre,
                fase: FASES[punto.fase],
                edad: punto.edad,
                aniosEnFase: punto.aniosEnFase,
                observaciones: punto.droga.observaciones
            }
        });
    });

    // Crear datasets
    Object.keys(pointsByDrug).forEach(drugIdx => {
        const droga = consumoData[drugIdx];
        const color = COLORES_DROGAS[droga.tipo_droga] || '#6B7280';

        datasets.push({
            label: droga.droga_nombre,
            data: pointsByDrug[drugIdx],
            borderColor: color,
            backgroundColor: color,
            borderWidth: 4,
            pointRadius: 5,
            pointHoverRadius: 7,
            showLine: true,
            tension: 0.1,
            fill: false,
            segment: {
                borderDash: ctx => {
                    // Línea punteada si no tiene edad_fin
                    if (!droga.edad_fin && ctx.p1DataIndex === pointsByDrug[drugIdx].length - 1) {
                        return [8, 4];
                    }
                    return [];
                }
            }
        });
    });

    // Configuración del gráfico
    myChart = new Chart(ctx, {
        type: 'line',
        data: { datasets: datasets },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2.3,
            plugins: {
                title: {
                    display: true,
                    text: 'Fase del Consumo - Edad - Droga - Tiempo de consumo',
                    font: { size: 18, weight: 'bold' },
                    padding: 20
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: { size: 13 },
                        padding: 12,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.85)',
                    titleFont: { size: 15, weight: 'bold' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    callbacks: {
                        title: ctx => ctx[0].raw.metadata.droga,
                        label: ctx => {
                            const meta = ctx.raw.metadata;
                            const labels = [];
                            labels.push('Fase: ' + meta.fase);
                            labels.push('Edad: ' + Math.round(meta.edad) + ' años');
                            if (meta.aniosEnFase > 0) {
                                labels.push('Años en esta fase: ' + meta.aniosEnFase.toFixed(1));
                            }
                            if (meta.observaciones) {
                                labels.push('Obs: ' + meta.observaciones);
                            }
                            return labels;
                        }
                    }
                }
            },
            scales: {
                x: {
                    type: 'linear',
                    min: minAge,
                    max: maxAge,
                    title: {
                        display: true,
                        text: 'Edad',
                        font: { size: 16, weight: 'bold' },
                        padding: 10
                    },
                    ticks: {
                        stepSize: 1,
                        font: { size: 13 },
                        callback: value => {
                            if (maxAge - minAge <= 20) return value;
                            else if (value % 2 === 0) return value;
                            return '';
                        }
                    },
                    grid: { color: '#e5e7eb' }
                },
                y: {
                    type: 'linear',
                    min: -0.3,
                    max: 3.5,
                    title: {
                        display: true,
                        text: 'Fase del consumo',
                        font: { size: 16, weight: 'bold' },
                        padding: 10
                    },
                    ticks: {
                        stepSize: 1,
                        callback: value => {
                            const fases = ['Experimental', 'Social', 'Habitual', 'Adicto'];
                            if (Number.isInteger(value) && value >= 0 && value <= 3) {
                                return fases[value];
                            }
                            return '';
                        },
                        font: { size: 14, weight: 'bold' },
                        color: ctx => {
                            const fases = ['experimental', 'social', 'habitual', 'adicto'];
                            const value = ctx.tick.value;
                            if (Number.isInteger(value) && value >= 0 && value <= 3) {
                                return COLORES_FASES[fases[value]];
                            }
                            return '#374151';
                        }
                    },
                    grid: {
                        color: ctx => Number.isInteger(ctx.tick.value) ? '#e5e7eb' : 'transparent'
                    }
                }
            }
        }
    });

    updateLegend();
}

function updateLegend() {
    const legend = document.getElementById('drugLegend');
    legend.innerHTML = '';

    if (consumoData.length === 0) {
        legend.innerHTML = '<p class="text-muted">No hay drogas registradas aún.</p>';
        return;
    }

    const grouped = {};
    consumoData.forEach(d => {
        if (!grouped[d.tipo_droga]) {
            grouped[d.tipo_droga] = { nombre: d.droga_nombre, count: 0 };
        }
        grouped[d.tipo_droga].count++;
    });

    Object.keys(grouped).forEach(drugType => {
        const color = COLORES_DROGAS[drugType] || '#6B7280';
        const data = grouped[drugType];

        const item = document.createElement('div');
        item.style.cssText = `
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1.25rem; background: ${color}15;
            border-radius: 10px; border: 2px solid ${color};
        `;

        const colorBox = document.createElement('div');
        colorBox.style.cssText = `
            width: 28px; height: 28px; background: ${color};
            border-radius: 6px;
        `;

        const label = document.createElement('span');
        label.innerHTML = `<strong>${data.nombre}</strong> <small class="text-muted">(${data.count})</small>`;
        label.style.fontWeight = '600';
        label.style.color = '#374151';

        item.appendChild(colorBox);
        item.appendChild(label);
        legend.appendChild(item);
    });
}

function exportChart() {
    const link = document.createElement('a');
    link.download = 'fase-consumo-{{ $historia->numero_historia }}.png';
    link.href = myChart.toBase64Image();
    link.click();
}

function toggleFormModal() {
    const modal = document.getElementById('formModal');
    modal.classList.toggle('active');
    if (!modal.classList.contains('active')) resetForm();
}

function resetForm() {
    document.getElementById('consumoForm').reset();
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('consumoForm').action = '/historias/' + historiaId + '/consumo';
    document.getElementById('modalTitle').textContent = 'Agregar Consumo';
    document.getElementById('droga_detalle_group').style.display = 'none';
    document.getElementById('droga_detalle').removeAttribute('required');
}

function toggleDrogaDetalle() {
    const tipoDroga = document.getElementById('tipo_droga').value;
    const drogaDetalleGroup = document.getElementById('droga_detalle_group');
    const drogaDetalleInput = document.getElementById('droga_detalle');

    if (tipoDroga === '9') {
        drogaDetalleGroup.style.display = 'block';
        drogaDetalleInput.setAttribute('required', 'required');
    } else {
        drogaDetalleGroup.style.display = 'none';
        drogaDetalleInput.removeAttribute('required');
        drogaDetalleInput.value = '';
    }
}

function editConsumo(id, tipoDroga, drogaDetalle, faseConsumo, edadInicio, edadFin, tiempoConsumo, observaciones) {
    document.getElementById('modalTitle').textContent = 'Editar Consumo';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('consumoForm').action = '/consumo/' + id;
    document.getElementById('tipo_droga').value = tipoDroga;
    toggleDrogaDetalle();
    document.getElementById('droga_detalle').value = drogaDetalle || '';
    document.getElementById('fase_consumo').value = faseConsumo;
    document.getElementById('edad_inicio').value = edadInicio;
    document.getElementById('edad_fin').value = edadFin !== null ? edadFin : '';
    document.getElementById('tiempo_consumo').value = tiempoConsumo || '';
    document.getElementById('observaciones').value = observaciones || '';
    toggleFormModal();
}

window.addEventListener('load', drawChart);
window.addEventListener('resize', () => myChart && myChart.resize());
</script>
@endsection
