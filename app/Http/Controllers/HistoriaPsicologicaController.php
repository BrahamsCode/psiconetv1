<?php

namespace App\Http\Controllers;

use App\Models\Consultante;
use App\Models\HistoriaPsicologica;
use App\Models\ConsumoSustancia;
use App\Models\TratamientoPrevio;
use App\Models\ConductaProblema;
use App\Models\EvaluacionPsicologica;
use App\Models\InterconsultaPsiquiatrica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaPsicologicaController extends Controller
{
    /**
     * Mostrar el formulario para crear historia psicológica
     */
    public function create(Consultante $consultante)
    {
        // Verificar si ya tiene historia
        if ($consultante->tieneHistoria()) {
            return redirect()
                ->route('historias.show', $consultante->historiaPsicologica)
                ->with('info', 'Este consultante ya tiene una historia psicológica creada.');
        }

        return view('historias.create', compact('consultante'));
    }

    /**
     * Guardar la historia psicológica
     */
    public function store(Request $request, Consultante $consultante)
    {
        $validated = $request->validate([
            'fecha_historia' => 'required|date',
            'motivo_consulta' => 'required|string',
            'problema_actual_1' => 'nullable|string',
            'problema_actual_2' => 'nullable|string',
            'problema_actual_3' => 'nullable|string',
            'problema_actual_4' => 'nullable|string',
            'problema_actual_5' => 'nullable|string',
            'diagrama_familiar_observaciones' => 'nullable|string',
            'lazos_familiares' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // Crear historia psicológica
            $historia = new HistoriaPsicologica($validated);
            $historia->consultante_id = $consultante->id;
            $historia->numero_historia = HistoriaPsicologica::generarNumeroHistoria();
            $historia->save();

            // Guardar consumo de sustancias
            if ($request->has('consumo_sustancias')) {
                foreach ($request->consumo_sustancias as $consumo) {
                    if (!empty($consumo['tipo_droga'])) {
                        $historia->consumoSustancias()->create($consumo);
                    }
                }
            }

            // Guardar tratamientos previos
            if ($request->has('tratamientos_previos')) {
                foreach ($request->tratamientos_previos as $tratamiento) {
                    if (!empty($tratamiento['tipo_tratamiento'])) {
                        $historia->tratamientosPrevios()->create($tratamiento);
                    }
                }
            }

            // Guardar conductas problema
            if ($request->has('conductas_problema')) {
                foreach ($request->conductas_problema as $index => $conducta) {
                    if (!empty($conducta['conducta_problema'])) {
                        $historia->conductasProblema()->create([
                            'numero_orden' => $index + 1,
                            'conducta_problema' => $conducta['conducta_problema'],
                            'objetivo_terapeutico' => $conducta['objetivo_terapeutico'] ?? null,
                            'procedimiento' => $conducta['procedimiento'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('historias.show', $historia)
                ->with('success', 'Historia psicológica creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear la historia psicológica: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar la historia psicológica completa
     */
    public function show(HistoriaPsicologica $historia)
    {
        $historia->load([
            'consultante',
            'consumoSustancias',
            'tratamientosPrevios',
            'conductasProblema',
            'evaluacionesPsicologicas',
            'interconsultasPsiquiatricas'
        ]);

        return view('historias.show', compact('historia'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(HistoriaPsicologica $historia)
    {
        $historia->load([
            'consultante',
            'consumoSustancias',
            'tratamientosPrevios',
            'conductasProblema'
        ]);

        return view('historias.edit', compact('historia'));
    }

    /**
     * Actualizar historia psicológica
     */
    public function update(Request $request, HistoriaPsicologica $historia)
    {
        $validated = $request->validate([
            'fecha_historia' => 'required|date',
            'motivo_consulta' => 'required|string',
            'problema_actual_1' => 'nullable|string',
            'problema_actual_2' => 'nullable|string',
            'problema_actual_3' => 'nullable|string',
            'problema_actual_4' => 'nullable|string',
            'problema_actual_5' => 'nullable|string',
            'diagrama_familiar_observaciones' => 'nullable|string',
            'lazos_familiares' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $historia->update($validated);

            // Actualizar consumo de sustancias (eliminar y recrear)
            if ($request->has('consumo_sustancias')) {
                $historia->consumoSustancias()->delete();
                foreach ($request->consumo_sustancias as $consumo) {
                    if (!empty($consumo['tipo_droga'])) {
                        $historia->consumoSustancias()->create($consumo);
                    }
                }
            }

            // Actualizar tratamientos previos
            if ($request->has('tratamientos_previos')) {
                $historia->tratamientosPrevios()->delete();
                foreach ($request->tratamientos_previos as $tratamiento) {
                    if (!empty($tratamiento['tipo_tratamiento'])) {
                        $historia->tratamientosPrevios()->create($tratamiento);
                    }
                }
            }

            // Actualizar conductas problema
            if ($request->has('conductas_problema')) {
                $historia->conductasProblema()->delete();
                foreach ($request->conductas_problema as $index => $conducta) {
                    if (!empty($conducta['conducta_problema'])) {
                        $historia->conductasProblema()->create([
                            'numero_orden' => $index + 1,
                            'conducta_problema' => $conducta['conducta_problema'],
                            'objetivo_terapeutico' => $conducta['objetivo_terapeutico'] ?? null,
                            'procedimiento' => $conducta['procedimiento'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('historias.show', $historia)
                ->with('success', 'Historia psicológica actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la historia psicológica: ' . $e->getMessage());
        }
    }

    /**
     * Exportar historia a PDF
     */
    public function exportarPdf(HistoriaPsicologica $historia)
    {
        $historia->load([
            'consultante',
            'consumoSustancias',
            'tratamientosPrevios',
            'conductasProblema',
            'evaluacionesPsicologicas',
            'interconsultasPsiquiatricas'
        ]);

        // Aquí implementarías la generación del PDF
        // Podrías usar una librería como DomPDF o mPDF
        
        return view('historias.pdf', compact('historia'));
    }
}
