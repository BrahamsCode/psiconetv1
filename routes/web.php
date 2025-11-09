<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsultanteController;
use App\Http\Controllers\IntervencionController;

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
