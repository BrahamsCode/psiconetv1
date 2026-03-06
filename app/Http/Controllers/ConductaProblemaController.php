<?php

namespace App\Http\Controllers;

use App\Models\HistoriaPsicologica;
use App\Models\ConductaProblema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConductaProblemaController extends Controller
{
    /**
     * Listar todas las historias para seleccionar
     */
    public function index()
    {
        $historias = HistoriaPsicologica::with('consultante', 'conductasProblema')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('conductas.index', compact('historias'));
    }

    /**
     * Mostrar formulario para crear/editar procedimiento terapéutico
     */
    public function create(HistoriaPsicologica $historia)
    {
        $historia->load(['consultante', 'conductasProblema']);
        return view('conductas.create', compact('historia'));
    }

    /**
     * Guardar/actualizar procedimiento terapéutico
     */
    public function store(Request $request, HistoriaPsicologica $historia)
    {
        $validated = $request->validate([
            'conductas' => 'required|array|min:1',
            'conductas.*.conducta_problema' => 'required|string',
            'conductas.*.objetivo_terapeutico' => 'nullable|string',
            'conductas.*.procedimiento' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Eliminar conductas anteriores
            $historia->conductasProblema()->delete();

            // Crear nuevas conductas
            foreach ($validated['conductas'] as $index => $conducta) {
                $historia->conductasProblema()->create([
                    'numero_orden' => $index + 1,
                    'conducta_problema' => $conducta['conducta_problema'],
                    'objetivo_terapeutico' => $conducta['objetivo_terapeutico'] ?? null,
                    'procedimiento' => $conducta['procedimiento'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('conductas.index')
                ->with('success', 'Procedimiento terapéutico guardado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
}
