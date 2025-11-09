<?php

namespace App\Http\Controllers;

use App\Models\HistoriaPsicologica;
use App\Models\InterconsultaPsiquiatrica;
use Illuminate\Http\Request;

class InterconsultaPsiquiatricaController extends Controller
{
    /**
     * Guardar interconsulta psiquiátrica
     */
    public function store(Request $request, HistoriaPsicologica $historia)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'medico_psiquiatra' => 'required|string|max:255',
            'diagnostico' => 'nullable|string',
            'medicamento_recetado' => 'nullable|string',
            'cita_proxima' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $historia->interconsultasPsiquiatricas()->create($validated);

        return redirect()
            ->route('historias.show', $historia)
            ->with('success', 'Interconsulta psiquiátrica agregada exitosamente.');
    }

    /**
     * Actualizar interconsulta psiquiátrica
     */
    public function update(Request $request, InterconsultaPsiquiatrica $interconsulta)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'medico_psiquiatra' => 'required|string|max:255',
            'diagnostico' => 'nullable|string',
            'medicamento_recetado' => 'nullable|string',
            'cita_proxima' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $interconsulta->update($validated);

        return redirect()
            ->route('historias.show', $interconsulta->historiaPsicologica)
            ->with('success', 'Interconsulta psiquiátrica actualizada exitosamente.');
    }

    /**
     * Eliminar interconsulta psiquiátrica
     */
    public function destroy(InterconsultaPsiquiatrica $interconsulta)
    {
        $historia = $interconsulta->historiaPsicologica;
        $interconsulta->delete();

        return redirect()
            ->route('historias.show', $historia)
            ->with('success', 'Interconsulta psiquiátrica eliminada exitosamente.');
    }
}
