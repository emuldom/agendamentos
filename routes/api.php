<?php

use App\Http\Controllers\Api\AgendamentoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\FuncionarioController;
use App\Http\Controllers\Api\TipoAgendamentoController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Empresas
    Route::apiResource('empresas', EmpresaController::class);
    
    // Clientes
    Route::apiResource('clientes', ClienteController::class);
    Route::post('/clientes/create-or-update', [ClienteController::class, 'createOrUpdate']);
    
    // Funcionários
    Route::apiResource('funcionarios', FuncionarioController::class);
    
    // Tipos de Agendamento
    Route::apiResource('tipos-agendamento', TipoAgendamentoController::class);
    
    // Agendamentos
    Route::apiResource('agendamentos', AgendamentoController::class);
});