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
        <canvas id="consumoChart" style="max-height: 500px;"></canvas>
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
                <th>Fase</th>
                <th>Edad Inicio</th>
                <th>Edad Fin</th>
                <th>Tiempo Consumo</th>
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
                <td>{{ $consumo->tiempo_consumo ?? '-' }}</td>
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
                <label for="fase_consumo">Fase de Consumo *</label>
                <select name="fase_consumo" id="fase_consumo" required>
                    <option value="">Seleccionar...</option>
                    @foreach(App\Models\ConsumoSustancia::FASES as $key => $nombre)
                        <option value="{{ $key }}">{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="edad_inicio">Edad de Inicio *</label>
                    <input type="number" name="edad_inicio" id="edad_inicio" min="1" max="100" required>
                </div>

                <div class="form-group">
                    <label for="edad_fin">Edad de Fin</label>
                    <input type="number" name="edad_fin" id="edad_fin" min="1" max="100">
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

function drawChart() {
    const ctx = document.getElementById('consumoChart').getContext('2d');

    // Destruir gráfico anterior si existe
    if (myChart) {
        myChart.destroy();
    }

    // Calcular rango de edades - CORREGIDO
    let minAge = 0;
    let maxAge = 80;

    if (consumoData.length > 0) {
        const ages = [];
        consumoData.forEach(d => {
            ages.push(d.edad_inicio);
            if (d.edad_fin) ages.push(d.edad_fin);
        });

        if (ages.length > 0) {
            // Permitir cualquier edad, no forzar mínimo de 10
            const minEdad = Math.min(...ages);
            const maxEdad = Math.max(...ages);

            // Redondear hacia abajo y arriba en múltiplos de 5
            minAge = Math.max(0, Math.floor(minEdad / 5) * 5);
            maxAge = Math.min(100, Math.ceil(maxEdad / 5) * 5 + 5); // +5 para dar espacio
        }
    }

    // Si el rango es muy pequeño, expandirlo un poco
    if (maxAge - minAge < 10) {
        maxAge = minAge + 10;
    }

    // Agrupar por droga y ordenar por edad
    const grouped = {};
    consumoData.forEach(d => {
        if (!grouped[d.tipo_droga]) {
            grouped[d.tipo_droga] = {
                nombre: d.droga_nombre,
                puntos: []
            };
        }
        grouped[d.tipo_droga].puntos.push(d);
    });

    // Ordenar puntos por edad_inicio dentro de cada droga
    Object.values(grouped).forEach(drug => {
        drug.puntos.sort((a, b) => a.edad_inicio - b.edad_inicio);
    });

    // Preparar datasets
    const datasets = [];

    Object.keys(grouped).forEach(drugType => {
        const drug = grouped[drugType];
        const color = COLORES_DROGAS[drugType] || '#6B7280';
        const points = [];

        drug.puntos.forEach((punto, index) => {
            // Punto de inicio de esta fase
            points.push({
                x: punto.edad_inicio,
                y: POSICION_FASES[punto.fase_consumo],
                label: `${punto.fase_nombre} - ${punto.edad_inicio} años`,
                metadata: punto
            });

            // Punto de fin de esta fase
            const edadFin = punto.edad_fin || maxAge;
            points.push({
                x: edadFin,
                y: POSICION_FASES[punto.fase_consumo],
                label: `${punto.fase_nombre} - ${edadFin} años`,
                metadata: punto
            });
        });

        datasets.push({
            label: drug.nombre,
            data: points,
            borderColor: color,
            backgroundColor: color,
            borderWidth: 4,
            pointRadius: 6,
            pointHoverRadius: 8,
            showLine: true,
            tension: 0,
            fill: false
        });
    });

    // Configuración del gráfico
    myChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2.5,
            plugins: {
                title: {
                    display: true,
                    text: 'Fase del Consumo - Edad - Droga - Tiempo de consumo',
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    padding: 20
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 13
                        },
                        padding: 12,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.85)',
                    titleFont: {
                        size: 15,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 12,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            const labels = [];
                            const point = context.raw;

                            if (point.metadata) {
                                labels.push('Fase: ' + point.metadata.fase_nombre);
                                labels.push('Edad: ' + Math.round(context.parsed.x) + ' años');

                                if (point.metadata.tiempo_consumo) {
                                    labels.push('Tiempo: ' + point.metadata.tiempo_consumo);
                                }
                                if (point.metadata.observaciones) {
                                    labels.push('Obs: ' + point.metadata.observaciones);
                                }
                            } else {
                                labels.push('Edad: ' + Math.round(context.parsed.x) + ' años');
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
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        padding: 10
                    },
                    ticks: {
                        stepSize: 1, // Mostrar cada año
                        font: {
                            size: 13
                        },
                        callback: function(value) {
                            // Mostrar solo algunos valores para no saturar
                            if (maxAge - minAge <= 20) {
                                return value; // Mostrar todos
                            } else if (value % 2 === 0) {
                                return value; // Mostrar cada 2
                            }
                            return '';
                        }
                    },
                    grid: {
                        color: '#e5e7eb',
                        lineWidth: 1
                    }
                },
                y: {
                    type: 'linear',
                    min: -0.2,
                    max: 3.2,
                    title: {
                        display: true,
                        text: 'Fase del consumo',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        padding: 10
                    },
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            const fases = ['Experimental', 'Social', 'Habitual', 'Adicto'];
                            if (Number.isInteger(value) && value >= 0 && value <= 3) {
                                return fases[value] || '';
                            }
                            return '';
                        },
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        color: function(context) {
                            const fases = ['experimental', 'social', 'habitual', 'adicto'];
                            const value = context.tick.value;
                            if (Number.isInteger(value) && value >= 0 && value <= 3) {
                                return COLORES_FASES[fases[value]] || '#374151';
                            }
                            return '#374151';
                        }
                    },
                    grid: {
                        color: function(context) {
                            return Number.isInteger(context.tick.value) ? '#e5e7eb' : 'transparent';
                        },
                        lineWidth: 1
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

    // Agrupar por tipo de droga
    const grouped = {};
    consumoData.forEach(d => {
        if (!grouped[d.tipo_droga]) {
            grouped[d.tipo_droga] = {
                nombre: d.droga_nombre,
                count: 0
            };
        }
        grouped[d.tipo_droga].count++;
    });

    Object.keys(grouped).forEach(drugType => {
        const color = COLORES_DROGAS[drugType] || '#6B7280';
        const data = grouped[drugType];

        const item = document.createElement('div');
        item.style.cssText = `
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            background: ${color}15;
            border-radius: 10px;
            border: 2px solid ${color};
        `;

        const colorBox = document.createElement('div');
        colorBox.style.cssText = `
            width: 28px;
            height: 28px;
            background: ${color};
            border-radius: 6px;
        `;

        const label = document.createElement('span');
        label.innerHTML = `<strong>${data.nombre}</strong> <small class="text-muted">(${data.count} registro${data.count > 1 ? 's' : ''})</small>`;
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

// Inicializar
window.addEventListener('load', drawChart);
window.addEventListener('resize', function() {
    if (myChart) {
        myChart.resize();
    }
});
</script>
@endsection
