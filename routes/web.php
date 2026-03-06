<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsultanteController;
use App\Http\Controllers\IntervencionController;
use App\Http\Controllers\HistoriaPsicologicaController;
use App\Http\Controllers\EvaluacionPsicologicaController;
use App\Http\Controllers\InterconsultaPsiquiatricaController;
use App\Http\Controllers\ConsumoSustanciaController;
use App\Http\Controllers\TratamientoPrevioController;
use App\Http\Controllers\ConductaProblemaController;

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
Route::get('historias', [HistoriaPsicologicaController::class, 'index'])
    ->name('historias.index');
Route::get('/historias/nueva', [HistoriaPsicologicaController::class, 'selectConsultante'])
    ->name('historias.nueva');
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

// Rutas para Consumo de Sustancias
Route::get('consumo/fase', [ConsumoSustanciaController::class, 'index'])
    ->name('consumo.index'); // Lista de consultantes
Route::get('consumo/fase/{consultante}', [ConsumoSustanciaController::class, 'faseConsumo'])
    ->name('consumo.fase'); // Gráfico de fase de consumo
Route::post('historias/{historia}/consumo', [ConsumoSustanciaController::class, 'store'])
    ->name('consumo.store');
Route::put('consumo/{consumo}', [ConsumoSustanciaController::class, 'update'])
    ->name('consumo.update');
Route::delete('consumo/{consumo}', [ConsumoSustanciaController::class, 'destroy'])
    ->name('consumo.destroy');

// Rutas para Tratamientos Previos
Route::get('tratamientos', [TratamientoPrevioController::class, 'index'])
    ->name('tratamientos.index'); // Lista de consultantes
Route::get('tratamientos/{consultante}', [TratamientoPrevioController::class, 'show'])
    ->name('tratamientos.show'); // Ver/Editar tratamientos
Route::put('tratamientos/{consultante}', [TratamientoPrevioController::class, 'update'])
    ->name('tratamientos.update'); // Guardar/Actualizar tratamientos


// Rutas para Procedimiento Terapéutico (Conductas Problema)
Route::prefix('conductas')->group(function () {
    Route::get('/', [ConductaProblemaController::class, 'index'])
        ->name('conductas.index');
    Route::get('/{historia}/crear', [ConductaProblemaController::class, 'create'])
        ->name('conductas.create');
    Route::post('/{historia}', [ConductaProblemaController::class, 'store'])
        ->name('conductas.store');
});
