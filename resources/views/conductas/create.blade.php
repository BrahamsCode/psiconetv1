@extends('layouts.app')

@section('title', 'Procedimiento Terapéutico')

@section('page-title', 'Gestionar Procedimiento Terapéutico')

@section('content')
<div class="card" style="margin-bottom: 1rem;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <span>Historia N°: {{ $historia->numero_historia }}</span>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <strong style="color: var(--primary-dark);">
                {{ $historia->consultante->nombre }}
            </strong>
            <span style="color: var(--text-secondary);">
                {{ $historia->consultante->edad }} años
            </span>
        </div>
    </div>
</div>

<form action="{{ route('conductas.store', $historia) }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>PROCEDIMIENTO TERAPÉUTICO</span>
            <button type="button" onclick="agregarConducta()" class="btn btn-sm btn-primary">
                ➕ Agregar Conducta
            </button>
        </div>

        <div id="conductas-container">
            @if($historia->conductasProblema->count() > 0)
                @foreach($historia->conductasProblema as $index => $conducta)
                <div class="conducta-item" data-index="{{ $index }}">
                    <div style="display: grid; grid-template-columns: 60px 1fr 1fr 1fr 60px; gap: 1rem; align-items: start; margin-bottom: 1rem; padding: 1rem; background: var(--bg-secondary); border-radius: 8px;">
                        <div style="text-align: center; font-weight: bold; padding-top: 0.5rem;">
                            <span class="numero-orden">{{ $index + 1 }}</span>
                        </div>

                        <div class="form-group" style="margin: 0;">
                            <label>Conducta Problema *</label>
                            <textarea name="conductas[{{ $index }}][conducta_problema]"
                                      rows="3"
                                      required
                                      placeholder="Describa la conducta problema...">{{ old("conductas.$index.conducta_problema", $conducta->conducta_problema) }}</textarea>
                        </div>

                        <div class="form-group" style="margin: 0;">
                            <label>Objetivo Terapéutico</label>
                            <textarea name="conductas[{{ $index }}][objetivo_terapeutico]"
                                      rows="3"
                                      placeholder="Objetivo a alcanzar...">{{ old("conductas.$index.objetivo_terapeutico", $conducta->objetivo_terapeutico) }}</textarea>
                        </div>

                        <div class="form-group" style="margin: 0;">
                            <label>Procedimiento</label>
                            <textarea name="conductas[{{ $index }}][procedimiento]"
                                      rows="3"
                                      placeholder="Procedimiento a seguir...">{{ old("conductas.$index.procedimiento", $conducta->procedimiento) }}</textarea>
                        </div>

                        <div style="text-align: center; padding-top: 1.8rem;">
                            <button type="button" onclick="eliminarConducta(this)" class="btn btn-sm btn-danger" title="Eliminar">
                                🗑️
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="conducta-item" data-index="0">
                    <div style="display: grid; grid-template-columns: 60px 1fr 1fr 1fr 60px; gap: 1rem; align-items: start; margin-bottom: 1rem; padding: 1rem; background: var(--bg-secondary); border-radius: 8px;">
                        <div style="text-align: center; font-weight: bold; padding-top: 0.5rem;">
                            <span class="numero-orden">1</span>
                        </div>

                        <div class="form-group" style="margin: 0;">
                            <label>Conducta Problema *</label>
                            <textarea name="conductas[0][conducta_problema]"
                                      rows="3"
                                      required
                                      placeholder="Describa la conducta problema...">{{ old('conductas.0.conducta_problema') }}</textarea>
                        </div>

                        <div class="form-group" style="margin: 0;">
                            <label>Objetivo Terapéutico</label>
                            <textarea name="conductas[0][objetivo_terapeutico]"
                                      rows="3"
                                      placeholder="Objetivo a alcanzar...">{{ old('conductas.0.objetivo_terapeutico') }}</textarea>
                        </div>

                        <div class="form-group" style="margin: 0;">
                            <label>Procedimiento</label>
                            <textarea name="conductas[0][procedimiento]"
                                      rows="3"
                                      placeholder="Procedimiento a seguir...">{{ old('conductas.0.procedimiento') }}</textarea>
                        </div>

                        <div style="text-align: center; padding-top: 1.8rem;">
                            <button type="button" onclick="eliminarConducta(this)" class="btn btn-sm btn-danger" title="Eliminar">
                                🗑️
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div style="padding: 0 1rem 1rem;">
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">
                💡 Los números se actualizan automáticamente al agregar o eliminar conductas
            </p>
        </div>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
        <a href="{{ route('conductas.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
            💾 Guardar Procedimiento Terapéutico
        </button>
    </div>
</form>

<script>
let conductaIndex = {{ $historia->conductasProblema->count() > 0 ? $historia->conductasProblema->count() : 1 }};

function agregarConducta() {
    const container = document.getElementById('conductas-container');
    const newItem = document.createElement('div');
    newItem.className = 'conducta-item';
    newItem.setAttribute('data-index', conductaIndex);

    newItem.innerHTML = `
        <div style="display: grid; grid-template-columns: 60px 1fr 1fr 1fr 60px; gap: 1rem; align-items: start; margin-bottom: 1rem; padding: 1rem; background: var(--bg-secondary); border-radius: 8px;">
            <div style="text-align: center; font-weight: bold; padding-top: 0.5rem;">
                <span class="numero-orden">${conductaIndex + 1}</span>
            </div>

            <div class="form-group" style="margin: 0;">
                <label>Conducta Problema *</label>
                <textarea name="conductas[${conductaIndex}][conducta_problema]"
                          rows="3"
                          required
                          placeholder="Describa la conducta problema..."></textarea>
            </div>

            <div class="form-group" style="margin: 0;">
                <label>Objetivo Terapéutico</label>
                <textarea name="conductas[${conductaIndex}][objetivo_terapeutico]"
                          rows="3"
                          placeholder="Objetivo a alcanzar..."></textarea>
            </div>

            <div class="form-group" style="margin: 0;">
                <label>Procedimiento</label>
                <textarea name="conductas[${conductaIndex}][procedimiento]"
                          rows="3"
                          placeholder="Procedimiento a seguir..."></textarea>
            </div>

            <div style="text-align: center; padding-top: 1.8rem;">
                <button type="button" onclick="eliminarConducta(this)" class="btn btn-sm btn-danger" title="Eliminar">
                    🗑️
                </button>
            </div>
        </div>
    `;

    container.appendChild(newItem);
    conductaIndex++;
    actualizarNumeros();
}

function eliminarConducta(btn) {
    const item = btn.closest('.conducta-item');
    const container = document.getElementById('conductas-container');

    if (container.children.length === 1) {
        alert('Debe haber al menos una conducta problema');
        return;
    }

    item.remove();
    actualizarNumeros();
}

function actualizarNumeros() {
    const items = document.querySelectorAll('.conducta-item');
    items.forEach((item, index) => {
        const numeroSpan = item.querySelector('.numero-orden');
        if (numeroSpan) {
            numeroSpan.textContent = index + 1;
        }
    });
}
</script>
@endsection
