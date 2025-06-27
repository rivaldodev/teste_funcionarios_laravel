<?php

use App\Http\Controllers\FuncionarioController;
use Illuminate\Support\Facades\Route;

// Rotas principais do sistema de funcionários
// Todas as rotas utilizam o controller FuncionarioController

// Rota inicial: exibe a listagem de funcionários
Route::get('/', [FuncionarioController::class, 'index']);

// Rotas RESTful para CRUD de funcionários
Route::resource('funcionarios', FuncionarioController::class);

// Rota para reativar funcionário inativo (soft delete reverso)
Route::put('funcionarios/{id}/reativar', [FuncionarioController::class, 'reativar']);
