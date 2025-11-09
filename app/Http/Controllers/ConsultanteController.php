<?php

namespace App\Http\Controllers;

use App\Models\Consultante;
use Illuminate\Http\Request;

class ConsultanteController extends Controller
{
    public function index()
    {
        $consultantes = Consultante::with('intervenciones')->orderBy('created_at', 'desc')->get();
        return view('consultantes.index', compact('consultantes'));
    }

    public function create()
    {
        return view('consultantes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer|min:0|max:120',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'observaciones' => 'nullable|string',
            'fecha_registro' => 'required|date',
        ]);

        Consultante::create($validated);

        return redirect()->route('consultantes.index')
            ->with('success', 'Consultante registrado exitosamente');
    }

    public function show(Consultante $consultante)
    {
        $consultante->load('intervenciones');
        return view('consultantes.show', compact('consultante'));
    }

    public function edit(Consultante $consultante)
    {
        return view('consultantes.edit', compact('consultante'));
    }

    public function update(Request $request, Consultante $consultante)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer|min:0|max:120',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'observaciones' => 'nullable|string',
            'fecha_registro' => 'required|date',
        ]);

        $consultante->update($validated);

        return redirect()->route('consultantes.show', $consultante)
            ->with('success', 'Consultante actualizado exitosamente');
    }

    public function destroy(Consultante $consultante)
    {
        $consultante->delete();
        return redirect()->route('consultantes.index')
            ->with('success', 'Consultante eliminado exitosamente');
    }
}
