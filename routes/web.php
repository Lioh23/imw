<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CongregadosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembrosController;
use App\Http\Controllers\VisitantesController;
use Illuminate\Support\Facades\Route;

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rota para mostrar o formulário de esqueci a senha
Route::get('/esqueci-senha', [AuthController::class, 'showResetRequestForm'])->name('password.request');

// Rota para enviar o link de redefinição de senha
Route::post('/esqueci-senha', [AuthController::class, 'submitResetRequest'])->name('password.email');


// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    
    // Grupo de rotas para 'membresia'
    Route::prefix('membro')->name('membro.')->group(function () {
        Route::get('', [MembrosController::class, 'index'])->name('index');
        Route::get('editar/{id}', [MembrosController::class, 'editar'])->name('editar');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('','dashboard')->name('dashboard');
        Route::get('perfil', 'perfil')->name('perfil');
    });
    // Adicione mais rotas protegidas conforme necessário


    // Grupo de rotas para 'visitantes'
    Route::prefix('visitante')->name('visitante.')->group(function () {
        Route::get('/', [VisitantesController::class, 'index'])->name('index');
        Route::get('/novo', [VisitantesController::class, 'novo'])->name('novo');
        Route::post('/salvar', [VisitantesController::class, 'store'])->name('store');
        Route::get('/editar/{id}', [VisitantesController::class, 'editar'])->name('editar');
        Route::post('/deletar/{id}', [VisitantesController::class, 'deletar'])->name('deletar');
        Route::post('/pesquisar', [VisitantesController::class, 'pesquisar'])->name('pesquisar');
        Route::put('/visitante/{id}', [VisitantesController::class, 'update'])->name('update');
    });

    // Grupo de rotas para 'visitantes'
    Route::prefix('congregado')->name('congregado.')->group(function () {
        Route::get('/', [CongregadosController::class, 'index'])->name('index');
        Route::get('/novo', [CongregadosController::class, 'novo'])->name('novo');
        Route::post('/salvar', [CongregadosController::class, 'store'])->name('store');
    });
});
