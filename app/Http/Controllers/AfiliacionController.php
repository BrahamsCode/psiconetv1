<?php

namespace App\Http\Controllers;

use App\Models\Afiliacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AfiliacionController extends Controller
{
    public function index()
    {
        $afiliaciones = Afiliacion::with('historiaPsicologica')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('afiliaciones.index', compact('afiliaciones'));
    }

    public function create()
    {
        return view('afiliaciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres_apellidos' => 'required|string|max:255',
            'edad' => 'required|integer|min:0|max:120',
            'lugar_nacimiento' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'required|string',
            'documento_identidad' => 'nullable|string|max:20|unique:afiliaciones',
            'telefono' => 'nullable|string|max:20',
            'correo_electronico' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'grado_instruccion' => 'nullable|string',
            'ocupacion' => 'nullable|string|max:255',
            'estado_civil' => 'nullable|string',
            'religion' => 'nullable|string|max:100',
            'contacto_emergencia_nombre' => 'nullable|string|max:255',
            'contacto_emergencia_telefono' => 'nullable|string|max:20',
            'referido_por' => 'nullable|string',
            'referido_detalle' => 'nullable|required_if:referido_por,Otros|string|max:255',
            'consentimiento_informado' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'contrato_terapeutico' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'fecha_creacion_historia' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        // Procesar archivos
        if ($request->hasFile('consentimiento_informado')) {
            $validated['consentimiento_informado'] = $request->file('consentimiento_informado')
                ->store('documentos/consentimientos', 'public');
        }

        if ($request->hasFile('contrato_terapeutico')) {
            $validated['contrato_terapeutico'] = $request->file('contrato_terapeutico')
                ->store('documentos/contratos', 'public');
        }

        $afiliacion = Afiliacion::create($validated);

        return redirect()->route('afiliaciones.show', $afiliacion)
            ->with('success', 'Afiliación registrada exitosamente');
    }

    public function show(Afiliacion $afiliacion)
    {
        $afiliacion->load('historiaPsicologica');
        return view('afiliaciones.show', compact('afiliacion'));
    }

    public function edit(Afiliacion $afiliacion)
    {
        return view('afiliaciones.edit', compact('afiliacion'));
    }

    public function update(Request $request, Afiliacion $afiliacion)
    {
        $validated = $request->validate([
            'nombres_apellidos' => 'required|string|max:255',
            'edad' => 'required|integer|min:0|max:120',
            'lugar_nacimiento' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'required|string',
            'documento_identidad' => 'nullable|string|max:20|unique:afiliaciones,documento_identidad,' . $afiliacion->id,
            'telefono' => 'nullable|string|max:20',
            'correo_electronico' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'grado_instruccion' => 'nullable|string',
            'ocupacion' => 'nullable|string|max:255',
            'estado_civil' => 'nullable|string',
            'religion' => 'nullable|string|max:100',
            'contacto_emergencia_nombre' => 'nullable|string|max:255',
            'contacto_emergencia_telefono' => 'nullable|string|max:20',
            'referido_por' => 'nullable|string',
            'referido_detalle' => 'nullable|required_if:referido_por,Otros|string|max:255',
            'consentimiento_informado' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'contrato_terapeutico' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'fecha_creacion_historia' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        // Actualizar archivos si se subieron nuevos
        if ($request->hasFile('consentimiento_informado')) {
            if ($afiliacion->consentimiento_informado) {
                Storage::disk('public')->delete($afiliacion->consentimiento_informado);
            }
            $validated['consentimiento_informado'] = $request->file('consentimiento_informado')
                ->store('documentos/consentimientos', 'public');
        }

        if ($request->hasFile('contrato_terapeutico')) {
            if ($afiliacion->contrato_terapeutico) {
                Storage::disk('public')->delete($afiliacion->contrato_terapeutico);
            }
            $validated['contrato_terapeutico'] = $request->file('contrato_terapeutico')
                ->store('documentos/contratos', 'public');
        }

        $afiliacion->update($validated);

        return redirect()->route('afiliaciones.show', $afiliacion)
            ->with('success', 'Afiliación actualizada exitosamente');
    }

    public function destroy(Afiliacion $afiliacion)
    {
        // Eliminar archivos asociados
        if ($afiliacion->consentimiento_informado) {
            Storage::disk('public')->delete($afiliacion->consentimiento_informado);
        }
        if ($afiliacion->contrato_terapeutico) {
            Storage::disk('public')->delete($afiliacion->contrato_terapeutico);
        }

        $afiliacion->delete();

        return redirect()->route('afiliaciones.index')
            ->with('success', 'Afiliación eliminada exitosamente');
    }
}
