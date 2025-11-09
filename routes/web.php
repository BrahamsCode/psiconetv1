<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsultanteController;
use App\Http\Controllers\IntervencionController;
use App\Http\Controllers\HistoriaPsicologicaController;
use App\Http\Controllers\EvaluacionPsicologicaController;
use App\Http\Controllers\InterconsultaPsiquiatricaController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rutas para Consultantes
Route::resource('consultantes', ConsultanteController::class);

// Rutas para Intervenciones
Route::get('consultantes/{consultante}/intervenciones/create', [IntervencionController::class, 'create'])
    ->name('intervenciones.create');
Route::post('consultantes/{consultante}/intervenciones', [IntervencionController::class, 'store'])
    ->name('intervenciones.store');
Route::get('intervenciones/{intervencion}/edit', [IntervencionController::class, 'edit'])
    ->name('intervenciones.edit');
Route::put('intervenciones/{intervencion}', [IntervencionController::class, 'update'])
    ->name('intervenciones.update');
Route::delete('intervenciones/{intervencion}', [IntervencionController::class, 'destroy'])
    ->name('intervenciones.destroy');

// Rutas para Historias Psicológicas
Route::get('consultantes/{consultante}/historia/create', [HistoriaPsicologicaController::class, 'create'])
    ->name('historias.create');
Route::post('consultantes/{consultante}/historia', [HistoriaPsicologicaController::class, 'store'])
    ->name('historias.store');
Route::get('historias/{historia}', [HistoriaPsicologicaController::class, 'show'])
    ->name('historias.show');
Route::get('historias/{historia}/edit', [HistoriaPsicologicaController::class, 'edit'])
    ->name('historias.edit');
Route::put('historias/{historia}', [HistoriaPsicologicaController::class, 'update'])
    ->name('historias.update');
Route::get('historias/{historia}/pdf', [HistoriaPsicologicaController::class, 'exportarPdf'])
    ->name('historias.pdf');

// Rutas para Evaluaciones Psicológicas
Route::post('historias/{historia}/evaluaciones', [EvaluacionPsicologicaController::class, 'store'])
    ->name('evaluaciones.store');
Route::put('evaluaciones/{evaluacion}', [EvaluacionPsicologicaController::class, 'update'])
    ->name('evaluaciones.update');
Route::delete('evaluaciones/{evaluacion}', [EvaluacionPsicologicaController::class, 'destroy'])
    ->name('evaluaciones.destroy');

// Rutas para Interconsultas Psiquiátricas
Route::post('historias/{historia}/interconsultas', [InterconsultaPsiquiatricaController::class, 'store'])
    ->name('interconsultas.store');
Route::put('interconsultas/{interconsulta}', [InterconsultaPsiquiatricaController::class, 'update'])
    ->name('interconsultas.update');
Route::delete('interconsultas/{interconsulta}', [InterconsultaPsiquiatricaController::class, 'destroy'])
    ->name('interconsultas.destroy');
