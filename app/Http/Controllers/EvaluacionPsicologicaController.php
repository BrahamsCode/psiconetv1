<?php

namespace App\Http\Controllers;

use App\Models\HistoriaPsicologica;
use App\Models\EvaluacionPsicologica;
use Illuminate\Http\Request;

class EvaluacionPsicologicaController extends Controller
{
    /**
     * Guardar evaluación psicológica
     */
    public function store(Request $request, HistoriaPsicologica $historia)
    {
        $validated = $request->validate([
            'test_psicologico' => 'required|string|max:255',
            'fecha_programada' => 'nullable|date',
            'fecha_ejecutada' => 'nullable|date',
            'evaluador' => 'nullable|string|max:255',
            'observacion' => 'nullable|string',
            'resultados' => 'nullable|string',
        ]);

        $historia->evaluacionesPsicologicas()->create($validated);

        return redirect()
            ->route('historias.show', $historia)
            ->with('success', 'Evaluación psicológica agregada exitosamente.');
    }

    /**
     * Actualizar evaluación psicológica
     */
    public function update(Request $request, EvaluacionPsicologica $evaluacion)
    {
        $validated = $request->validate([
            'test_psicologico' => 'required|string|max:255',
            'fecha_programada' => 'nullable|date',
            'fecha_ejecutada' => 'nullable|date',
            'evaluador' => 'nullable|string|max:255',
            'observacion' => 'nullable|string',
            'resultados' => 'nullable|string',
        ]);

        $evaluacion->update($validated);

        return redirect()
            ->route('historias.show', $evaluacion->historiaPsicologica)
            ->with('success', 'Evaluación psicológica actualizada exitosamente.');
    }

    /**
     * Eliminar evaluación psicológica
     */
    public function destroy(EvaluacionPsicologica $evaluacion)
    {
        $historia = $evaluacion->historiaPsicologica;
        $evaluacion->delete();

        return redirect()
            ->route('historias.show', $historia)
            ->with('success', 'Evaluación psicológica eliminada exitosamente.');
    }
}
