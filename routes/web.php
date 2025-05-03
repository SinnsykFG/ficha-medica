<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;

Route::get('/pacientes/crear', [PacienteController::class, 'create'])->name('pacientes.create');
Route::post('/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
Route::post('/pacientes/buscar', [PacienteController::class, 'search'])->name('pacientes.search');
Route::get('/pacientes/buscar', [PacienteController::class, 'buscar'])->name('pacientes.buscar');