<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembrosController;
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
    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/perfil', [HomeController::class, 'perfil'])->name('perfil');
    // Adicione mais rotas protegidas conforme necessário

    // Grupo de rotas para 'membresia'
    Route::prefix('membros')->name('membros')->group(function () {
        Route::get('/', [MembrosController::class, 'index'])->name('index');
        Route::get('/create', [MembrosController::class, 'create'])->name('create');
        Route::post('/', [MembrosController::class, 'store'])->name('store');
        Route::get('/{membros}', [MembrosController::class, 'show'])->name('show');
        Route::get('/{membros}/edit', [MembrosController::class, 'edit'])->name('edit');
        Route::put('/{membros}', [MembrosController::class, 'update'])->name('update');
        Route::delete('/{membros}', [MembrosController::class, 'destroy'])->name('destroy');
    });
});
