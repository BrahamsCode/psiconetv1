<?php

namespace App\Http\Controllers;

use App\Models\Consultante;
use App\Models\Intervencion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalConsultantes = Consultante::count();
        $totalIntervenciones = Intervencion::count();
        
        $intervencionesHoy = Intervencion::whereDate('fecha', today())->count();
        
        $nuevosEsteMes = Consultante::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count();
        
        $ultimosConsultantes = Consultante::withCount('intervenciones')
                                          ->latest()
                                          ->take(5)
                                          ->get();
        
        $proximasIntervenciones = Intervencion::with('consultante')
                                              ->latest('fecha')
                                              ->take(5)
                                              ->get();

        return view('dashboard', compact(
            'totalConsultantes',
            'totalIntervenciones',
            'intervencionesHoy',
            'nuevosEsteMes',
            'ultimosConsultantes',
            'proximasIntervenciones'
        ));
    }
}
