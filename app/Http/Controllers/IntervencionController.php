<?php

namespace App\Http\Controllers;

use App\Models\Consultante;
use App\Models\Intervencion;
use Illuminate\Http\Request;

class IntervencionController extends Controller
{
    public function create(Consultante $consultante)
    {
        $numero_sesion = $consultante->intervenciones()->count() + 1;
        return view('intervenciones.create', compact('consultante', 'numero_sesion'));
    }

    public function store(Request $request, Consultante $consultante)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'asistidos' => 'required|string',
            'actividades' => 'required|string',
            'terapeuta' => 'required|string|max:255',
        ]);

        $numero_sesion = $consultante->intervenciones()->count() + 1;
        
        $consultante->intervenciones()->create([
            'numero_sesion' => $numero_sesion,
            'fecha' => $validated['fecha'],
            'asistidos' => $validated['asistidos'],
            'actividades' => $validated['actividades'],
            'terapeuta' => $validated['terapeuta'],
        ]);

        return redirect()->route('consultantes.show', $consultante)
            ->with('success', 'Intervención registrada exitosamente');
    }

    public function edit(Intervencion $intervencion)
    {
        return view('intervenciones.edit', compact('intervencion'));
    }

    public function update(Request $request, Intervencion $intervencion)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'asistidos' => 'required|string',
            'actividades' => 'required|string',
            'terapeuta' => 'required|string|max:255',
        ]);

        $intervencion->update($validated);

        return redirect()->route('consultantes.show', $intervencion->consultante)
            ->with('success', 'Intervención actualizada exitosamente');
    }

    public function destroy(Intervencion $intervencion)
    {
        $consultante = $intervencion->consultante;
        $intervencion->delete();
        
        return redirect()->route('consultantes.show', $consultante)
            ->with('success', 'Intervención eliminada exitosamente');
    }
}
