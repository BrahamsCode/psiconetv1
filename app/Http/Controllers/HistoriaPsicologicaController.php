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
use Barryvdh\DomPDF\Facade\Pdf;

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
            'genero' => 'required|string',
            'grado_instruccion' => 'nullable|string',
            'estado_civil' => 'nullable|string',
            'ocupacion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'residencia' => 'nullable|string',
            'religion' => 'nullable|string|max:100',
            'natural_de' => 'nullable|string|max:255',
            'tiempo_residencia_lima' => 'nullable|string|max:100',
            'persona_responsable' => 'nullable|string|max:255',
            'parentesco_responsable' => 'nullable|string|max:100',
            'telefono_responsable' => 'nullable|string|max:20',
            'asisten_primera_consulta' => 'nullable|string',
            'telefono_primera_consulta' => 'nullable|string|max:20',
            'lugar_entrevista' => 'nullable|string|max:255',
            'terapeuta' => 'nullable|string|max:255',
            'recomendado_por' => 'nullable|string',
            'recomendado_detalle' => 'nullable|required_if:recomendado_por,Otros|string|max:255',

        ]);

        DB::beginTransaction();
        try {
            $historia = new HistoriaPsicologica($validated);
            $historia->consultante_id = $consultante->id;
            $historia->numero_historia = HistoriaPsicologica::generarNumeroHistoria();
            $historia->save();

            DB::commit();

            return redirect()
                ->route('historias.show', $historia)
                ->with('success', 'Historia psicológica creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear la historia: ' . $e->getMessage());
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
     * Listar historias psicológicas
     */
    public function index()
    {
        $historias = HistoriaPsicologica::with('consultante')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('historias.index', compact('historias'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(HistoriaPsicologica $historia)
    {
        $historia->load('consultante');

        return view('historias.edit', compact('historia'));
    }

    /**
     * Actualizar historia psicológica
     */
    public function update(Request $request, HistoriaPsicologica $historia)
    {
        $validated = $request->validate([
            'fecha_historia' => 'required|date',
            'genero' => 'required|string',
            'grado_instruccion' => 'nullable|string',
            'estado_civil' => 'nullable|string',
            'ocupacion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'residencia' => 'nullable|string',
            'religion' => 'nullable|string|max:100',
            'natural_de' => 'nullable|string|max:255',
            'tiempo_residencia_lima' => 'nullable|string|max:100',
            'persona_responsable' => 'nullable|string|max:255',
            'parentesco_responsable' => 'nullable|string|max:100',
            'telefono_responsable' => 'nullable|string|max:20',
            'asisten_primera_consulta' => 'nullable|string',
            'telefono_primera_consulta' => 'nullable|string|max:20',
            'lugar_entrevista' => 'nullable|string|max:255',
            'terapeuta' => 'nullable|string|max:255',
            'recomendado_por' => 'nullable|string',
            'recomendado_detalle' => 'nullable|required_if:recomendado_por,Otros|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $historia->update($validated);

            DB::commit();

            return redirect()
                ->route('historias.show', $historia)
                ->with('success', 'Historia psicológica actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la historia: ' . $e->getMessage());
        }
    }

    /*
    *Mostrar lista de consultantes sin historia psicológica
     */
    public function selectConsultante()
    {
        $consultantes = Consultante::whereDoesntHave('historiaPsicologica')
            ->orderBy('nombres')
            ->get();

        return view('historias.selectConsultante', compact('consultantes'));
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

        $pdf = Pdf::loadView('historias.pdf', compact('historia'))
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'DejaVu Sans');

        $filename = 'Historia_' . $historia->numero_historia . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
