<?php

namespace App\Http\Controllers;

use App\Models\HistoriaPsicologica;
use App\Models\ConsumoSustancia;
use App\Models\Consultante;
use Illuminate\Http\Request;

class ConsumoSustanciaController extends Controller
{
    /**
     * Listar consultantes para seleccionar
     */
    public function index()
    {
        $consultantes = Consultante::with('historiaPsicologica')->orderBy('nombre')->get();

        return view('consumo.index', compact('consultantes'));
    }

    /**
     * Mostrar vista de fase del consumo para un consultante específico
     */
    public function faseConsumo(Consultante $consultante)
    {
        // Verificar si el consultante tiene historia psicológica
        $historia = $consultante->historiaPsicologica;

        if (!$historia) {
            return redirect()
                ->route('consumo.index')
                ->with('error', 'El consultante no tiene Historia Psicológica. Por favor créela primero.');
        }

        $consumos = $historia->consumoSustancias()->get();

        return view('consumo.fase', compact('historia', 'consumos', 'consultante'));
    }

    /**
     * Guardar información de consumo
     */
    public function store(Request $request, HistoriaPsicologica $historia)
    {
        $validated = $request->validate([
            'tipo_droga' => 'required|string|in:1,2,3,4,5,6,7,8,9',
            'droga_detalle' => 'nullable|required_if:tipo_droga,9|string|max:255',
            'fase_consumo' => 'required|in:experimental,social,habitual,adicto',
            'edad_inicio' => 'required|integer|min:1|max:100',
            'edad_fin' => 'nullable|integer|min:1|max:100|gte:edad_inicio',
            'tiempo_consumo' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string'
        ], [
            'droga_detalle.required_if' => 'El detalle de la droga es requerido cuando selecciona "Otros"',
            'edad_fin.gte' => 'La edad de fin debe ser mayor o igual a la edad de inicio'
        ]);

        $historia->consumoSustancias()->create($validated);

        return redirect()
            ->route('consumo.fase', $historia->consultante)
            ->with('success', 'Información de consumo agregada exitosamente.');
    }

    /**
     * Actualizar información de consumo
     */
    public function update(Request $request, ConsumoSustancia $consumo)
    {
        $validated = $request->validate([
            'tipo_droga' => 'required|string|in:1,2,3,4,5,6,7,8,9',
            'droga_detalle' => 'nullable|required_if:tipo_droga,9|string|max:255',
            'fase_consumo' => 'required|in:experimental,social,habitual,adicto',
            'edad_inicio' => 'required|integer|min:1|max:100',
            'edad_fin' => 'nullable|integer|min:1|max:100|gte:edad_inicio',
            'tiempo_consumo' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string'
        ], [
            'droga_detalle.required_if' => 'El detalle de la droga es requerido cuando selecciona "Otros"',
            'edad_fin.gte' => 'La edad de fin debe ser mayor o igual a la edad de inicio'
        ]);

        $consumo->update($validated);

        return redirect()
            ->route('consumo.fase', $consumo->historiaPsicologica->consultante)
            ->with('success', 'Información de consumo actualizada exitosamente.');
    }

    /**
     * Eliminar información de consumo
     */
    public function destroy(ConsumoSustancia $consumo)
    {
        $consultante = $consumo->historiaPsicologica->consultante;
        $consumo->delete();

        return redirect()
            ->route('consumo.fase', $consultante)
            ->with('success', 'Información de consumo eliminada exitosamente.');
    }
}
