@extends('layouts.app')

@section('title', 'Fase del Consumo')

@section('page-title', 'Fase del Consumo - Edad - Droga')

@section('content')
<div class="card">
    <div class="card-header">
        Gráfico de Fase del Consumo
        <button class="btn btn-primary btn-sm" style="float:right;" onclick="toggleFormModal()">
            ➕ Agregar Consumo
        </button>
    </div>

    <!-- Canvas para el gráfico -->
    <div style="padding: 2rem; background: white; overflow-x: auto;">
        <canvas id="consumoChart" style="width: 100%; min-height: 500px;"></canvas>
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
                            onclick='editConsumo(@json($consumo))'>
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
                <small class="text-muted">Opcional: puede calcularse automáticamente</small>
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="3" placeholder="Notas adicionales sobre el consumo..."></textarea>
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

    .badge {
        text-transform: capitalize;
    }
</style>

<script>
// Datos del servidor
const consumoData = @json($consumos->map(function($c) {
    return [
        'id' => $c->id,
        'tipo_droga' => $c->tipo_droga,
        'droga_nombre' => $c->nombre_droga,
        'droga_detalle' => $c->droga_detalle,
        'fase_consumo' => $c->fase_consumo,
        'fase_nombre' => $c->nombre_fase,
        'edad_inicio' => $c->edad_inicio,
        'edad_fin' => $c->edad_fin,
        'tiempo_consumo' => $c->tiempo_consumo,
        'observaciones' => $c->observaciones
    ];
}));

const historiaId = {{ $historia->id }};

// Configuración de colores para cada tipo de droga
const drugColors = {
    '1': '#FF6B6B',      // OH - Rojo
    '2': '#4ECDC4',      // TUCCI - Turquesa
    '3': '#45B7D1',      // MH - Azul claro
    '4': '#FFA07A',      // Tabaco - Naranja claro
    '5': '#98D8C8',      // Cocaína - Verde agua
    '6': '#F7DC6F',      // PBC - Amarillo
    '7': '#BB8FCE',      // LSD - Púrpura
    '8': '#85C1E2',      // Clonazepam - Azul cielo
    '9': '#95A5A6'       // Otros - Gris
};

// Mapeo de nombres de drogas para abreviar
const drugShortNames = {
    '1': 'OH',
    '2': 'TUCCI',
    '3': 'MH',
    '4': 'Tabaco',
    '5': 'Cocaína',
    '6': 'PBC',
    '7': 'LSD',
    '8': 'Clonazepam',
    '9': 'Otros'
};

// Fase a número (para posición Y)
const faseToY = {
    'experimental': 0,
    'social': 1,
    'habitual': 2,
    'adicto': 3
};

// Función para dibujar el gráfico
function drawChart() {
    const canvas = document.getElementById('consumoChart');
    const ctx = canvas.getContext('2d');

    // Obtener rango de edades de los datos
    let minAge = 10;
    let maxAge = 70;

    if (consumoData.length > 0) {
        const ages = consumoData.flatMap(d => {
            const edadFin = d.edad_fin || (new Date().getFullYear() - 2000); // Año actual aproximado
            return [d.edad_inicio, edadFin];
        });
        minAge = Math.max(10, Math.floor(Math.min(...ages) / 5) * 5);
        maxAge = Math.min(100, Math.ceil(Math.max(...ages) / 5) * 5);
    }

    // Configuración del canvas
    const padding = 100;
    const width = Math.max(1000, (maxAge - minAge + 1) * 50);
    const height = 600;

    canvas.width = width;
    canvas.height = height;

    const chartWidth = width - padding * 2;
    const chartHeight = height - padding * 2;

    // Limpiar canvas
    ctx.clearRect(0, 0, width, height);
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, width, height);

    // Dibujar grid
    ctx.strokeStyle = '#e5e7eb';
    ctx.lineWidth = 1;

    // Líneas verticales (edades)
    const edadStep = (maxAge - minAge) > 30 ? 5 : ((maxAge - minAge) > 15 ? 2 : 1);
    for (let age = minAge; age <= maxAge; age += edadStep) {
        const x = padding + ((age - minAge) / (maxAge - minAge)) * chartWidth;
        ctx.beginPath();
        ctx.moveTo(x, padding);
        ctx.lineTo(x, height - padding);
        ctx.stroke();

        // Etiquetas de edad
        ctx.fillStyle = '#6b7280';
        ctx.font = 'bold 13px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(age, x, height - padding + 25);
    }

    // Etiqueta del eje X
    ctx.fillStyle = '#374151';
    ctx.font = 'bold 14px sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('EDAD', width / 2, height - padding + 50);

    // Líneas horizontales (fases)
    const phases = [
        { key: 'experimental', label: 'Experimental', color: '#9CA3AF' },
        { key: 'social', label: 'Social', color: '#3B82F6' },
        { key: 'habitual', label: 'Habitual', color: '#F59E0B' },
        { key: 'adicto', label: 'Adicto', color: '#EF4444' }
    ];

    phases.forEach((phase, i) => {
        const y = padding + (i / (phases.length - 1)) * chartHeight;

        // Línea de fase con color sutil
        ctx.strokeStyle = phase.color + '20';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(padding, y);
        ctx.lineTo(width - padding, y);
        ctx.stroke();

        // Etiquetas de fase
        ctx.fillStyle = phase.color;
        ctx.font = 'bold 15px sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText(phase.label, padding - 15, y + 6);
    });

    // Etiqueta del eje Y
    ctx.save();
    ctx.translate(20, height / 2);
    ctx.rotate(-Math.PI / 2);
    ctx.fillStyle = '#374151';
    ctx.font = 'bold 14px sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('FASE DEL CONSUMO', 0, 0);
    ctx.restore();

    // Dibujar líneas de consumo
    const groupedByDrug = {};
    consumoData.forEach(data => {
        const drugKey = data.tipo_droga;
        if (!groupedByDrug[drugKey]) {
            groupedByDrug[drugKey] = [];
        }
        groupedByDrug[drugKey].push(data);
    });

    Object.keys(groupedByDrug).forEach(drugType => {
        const color = drugColors[drugType] || '#95A5A6';
        const points = groupedByDrug[drugType];

        // Ordenar por edad
        points.sort((a, b) => a.edad_inicio - b.edad_inicio);

        ctx.strokeStyle = color;
        ctx.fillStyle = color;
        ctx.lineWidth = 4;
        ctx.lineCap = 'round';

        points.forEach((point, index) => {
            const startX = padding + ((point.edad_inicio - minAge) / (maxAge - minAge)) * chartWidth;
            const endX = point.edad_fin
                ? padding + ((point.edad_fin - minAge) / (maxAge - minAge)) * chartWidth
                : width - padding;
            const y = padding + (faseToY[point.fase_consumo] / (phases.length - 1)) * chartHeight;

            // Dibujar línea
            ctx.beginPath();
            ctx.moveTo(startX, y);
            ctx.lineTo(endX, y);
            ctx.stroke();

            // Puntos de inicio y fin
            ctx.beginPath();
            ctx.arc(startX, y, 8, 0, Math.PI * 2);
            ctx.fill();

            // Borde blanco para mejor visibilidad
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 2;
            ctx.stroke();
            ctx.strokeStyle = color;
            ctx.lineWidth = 4;

            if (point.edad_fin) {
                ctx.fillStyle = color;
                ctx.beginPath();
                ctx.arc(endX, y, 8, 0, Math.PI * 2);
                ctx.fill();

                ctx.strokeStyle = '#ffffff';
                ctx.lineWidth = 2;
                ctx.stroke();
                ctx.strokeStyle = color;
                ctx.lineWidth = 4;
            } else {
                // Flecha indicando que continúa
                ctx.fillStyle = color;
                ctx.beginPath();
                ctx.moveTo(endX - 10, y - 6);
                ctx.lineTo(endX, y);
                ctx.lineTo(endX - 10, y + 6);
                ctx.fill();
            }

            // Etiqueta de droga sobre la línea
            ctx.fillStyle = color;
            ctx.font = 'bold 12px sans-serif';
            ctx.textAlign = 'center';
            const labelX = (startX + endX) / 2;
            ctx.fillText(drugShortNames[drugType] || 'Otros', labelX, y - 15);
        });
    });

    // Actualizar leyenda
    updateLegend(groupedByDrug);
}

// Actualizar leyenda de drogas
function updateLegend(groupedByDrug) {
    const legend = document.getElementById('drugLegend');
    legend.innerHTML = '';

    if (Object.keys(groupedByDrug).length === 0) {
        legend.innerHTML = '<p class="text-muted">No hay drogas registradas aún.</p>';
        return;
    }

    Object.keys(groupedByDrug).forEach(drugType => {
        const color = drugColors[drugType] || '#95A5A6';
        const drugName = consumoData.find(d => d.tipo_droga === drugType)?.droga_nombre || 'Desconocido';

        const item = document.createElement('div');
        item.style.display = 'flex';
        item.style.alignItems = 'center';
        item.style.gap = '0.5rem';
        item.style.padding = '0.5rem 1rem';
        item.style.backgroundColor = color + '15';
        item.style.borderRadius = '8px';
        item.style.border = `2px solid ${color}`;

        const colorBox = document.createElement('div');
        colorBox.style.width = '24px';
        colorBox.style.height = '24px';
        colorBox.style.backgroundColor = color;
        colorBox.style.borderRadius = '6px';
        colorBox.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';

        const label = document.createElement('span');
        label.textContent = drugName;
        label.style.fontWeight = '600';
        label.style.color = '#374151';

        item.appendChild(colorBox);
        item.appendChild(label);
        legend.appendChild(item);
    });
}

// Modal functions
function toggleFormModal() {
    const modal = document.getElementById('formModal');
    modal.classList.toggle('active');

    if (!modal.classList.contains('active')) {
        resetForm();
    }
}

function resetForm() {
    document.getElementById('consumoForm').reset();
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('consumoForm').action = `/historias/${historiaId}/consumo`;
    document.getElementById('modalTitle').textContent = 'Agregar Consumo';
    document.getElementById('droga_detalle_group').style.display = 'none';
    document.getElementById('droga_detalle').removeAttribute('required');
}

function toggleDrogaDetalle() {
    const tipoDroga = document.getElementById('tipo_droga').value;
    const drogaDetalleGroup = document.getElementById('droga_detalle_group');
    const drogaDetalleInput = document.getElementById('droga_detalle');

    if (tipoDroga === '9') { // "Otros"
        drogaDetalleGroup.style.display = 'block';
        drogaDetalleInput.setAttribute('required', 'required');
    } else {
        drogaDetalleGroup.style.display = 'none';
        drogaDetalleInput.removeAttribute('required');
        drogaDetalleInput.value = '';
    }
}

function editConsumo(consumo) {
    document.getElementById('modalTitle').textContent = 'Editar Consumo';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('consumoForm').action = `/consumo/${consumo.id}`;

    document.getElementById('tipo_droga').value = consumo.tipo_droga;
    toggleDrogaDetalle();
    document.getElementById('droga_detalle').value = consumo.droga_detalle || '';
    document.getElementById('fase_consumo').value = consumo.fase_consumo;
    document.getElementById('edad_inicio').value = consumo.edad_inicio;
    document.getElementById('edad_fin').value = consumo.edad_fin || '';
    document.getElementById('tiempo_consumo').value = consumo.tiempo_consumo || '';
    document.getElementById('observaciones').value = consumo.observaciones || '';

    toggleFormModal();
}

// Dibujar al cargar
window.addEventListener('load', drawChart);
window.addEventListener('resize', drawChart);
</script>
@endsection
