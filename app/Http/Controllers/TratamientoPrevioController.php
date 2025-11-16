<?php

namespace App\Http\Controllers;

use App\Models\Consultante;
use App\Models\HistoriaPsicologica;
use App\Models\TratamientoPrevio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TratamientoPrevioController extends Controller
{
    /**
     * Listar consultantes para seleccionar y ver tratamientos
     */
    public function index()
    {
        $consultantes = Consultante::with('historiaPsicologica.tratamientosPrevios')
            ->orderBy('nombre')
            ->get();

        return view('tratamientos.index', compact('consultantes'));
    }

    /**
     * Mostrar/Editar tratamientos de un consultante específico
     */
    public function show(Consultante $consultante)
    {
        // Verificar si tiene historia psicológica
        if (!$consultante->tieneHistoria()) {
            return redirect()
                ->route('tratamientos.index')
                ->with('warning', 'Este consultante no tiene historia psicológica. Créala primero.');
        }

        $historia = $consultante->historiaPsicologica;
        $historia->load('tratamientosPrevios');

        // Tipos de tratamiento desde el modelo
        $tiposTratamiento = TratamientoPrevio::TIPOS;

        return view('tratamientos.show', compact('consultante', 'historia', 'tiposTratamiento'));
    }

    /**
     * Guardar/Actualizar tratamientos
     */
    public function update(Request $request, Consultante $consultante)
    {
        if (!$consultante->tieneHistoria()) {
            return back()->with('error', 'Este consultante no tiene historia psicológica.');
        }

        $validated = $request->validate([
            'tratamientos' => 'nullable|array',
            'tratamientos.*.tipo_tratamiento' => 'required|string|in:' . implode(',', array_keys(TratamientoPrevio::TIPOS)),
            'tratamientos.*.edad' => 'nullable|integer|min:0|max:120',
            'tratamientos.*.motivo' => 'nullable|string',
            'tratamientos.*.lugar' => 'nullable|string|max:255',
            'tratamientos.*.tiempo' => 'nullable|string|max:100',
            'tratamientos.*.motivo_termino' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $historia = $consultante->historiaPsicologica;

            // Eliminar tratamientos anteriores
            $historia->tratamientosPrevios()->delete();

            // Crear nuevos tratamientos
            if ($request->has('tratamientos')) {
                foreach ($request->tratamientos as $tratamiento) {
                    // Solo crear si al menos tiene tipo de tratamiento
                    if (!empty($tratamiento['tipo_tratamiento'])) {
                        $historia->tratamientosPrevios()->create($tratamiento);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('tratamientos.show', $consultante)
                ->with('success', 'Tratamientos actualizados exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar tratamientos: ' . $e->getMessage());
        }
    }
}
