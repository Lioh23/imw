<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CongregadosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\MembrosController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\VisitantesController;
use App\Http\Middleware\VerificaInstituicao;
use App\Http\Middleware\VerificaPerfil;
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
    Route::middleware([VerificaPerfil::class])->group(function () { 
        
        //Estas duas rotas estão com VerificaPerfil Middleware desabilitados
        Route::get('/selecionarPerfil', [HomeController::class, 'selecionarPerfil'])->withoutMiddleware([VerificaPerfil::class])->name('selecionarPerfil');
        Route::post('/postPerfil', [HomeController::class, 'postPerfil'])->withoutMiddleware([VerificaPerfil::class])->name('postPerfil');
       
        // Grupo de rotas para 'membresia'
        Route::prefix('membro')->name('membro.')->group(function () {
            Route::get('', [MembrosController::class, 'index'])->name('index');
            Route::get('editar/{id}', [MembrosController::class, 'editar'])->name('editar');
            Route::get('receber-novo/{id}', [MembrosController::class, 'receberNovo'])->name('receber_novo');
            Route::post('receber-novo-store/{id}', [MembrosController::class, 'storeReceberNovo'])->name('receber_novo.store');
            Route::post('atualizar/{id}', [MembrosController::class, 'update'])->name('update');
            Route::get('exclusao/{id}', [MembrosController::class, 'exclusao'])->name('exclusao');
            Route::delete('exclusao/store/{id}', [MembrosController::class, 'storeExclusao'])->name('exclusao.store');
            Route::get('reintegrar/{id}', [MembrosController::class, 'reintegrar'])->name('reintegrar');
            Route::post('reintegrar/store/{id}', [MembrosController::class, 'storeReintegracao'])->name('reintegrar.store');
            Route::get('transferencia/interna/{id}', [MembrosController::class, 'transferenciaInterna'])->name('transferencia_interna');
            Route::post('transferencia/interna/store/{id}', [MembrosController::class, 'storeTransferenciaInterna'])->name('transferencia_interna.store');
            Route::get('exclusao/transferencia/{id}', [MembrosController::class, 'exclusaoPorTransferencia'])->name('exclusao_transferencia');
            Route::post('exclusao/transferencia/store/{id}', [MembrosController::class, 'storeExclusaoPorTransferencia'])->name('exclusao_transferencia.store');
            Route::get('disciplinar/{id}', [MembrosController::class, 'disciplinar'])->name('disciplinar');
            Route::post('disciplinar/store/{id}', [MembrosController::class, 'storeDisciplinar'])->name('disciplinar.store');
            Route::put('disciplinar/update/{id}', [MembrosController::class, 'updateDisciplinar'])->name('disciplinar.update');
            
        });

        Route::controller(HomeController::class)->group(function () {
            Route::get('','dashboard')->name('dashboard');
            Route::get('perfil', 'perfil')->name('perfil');
        });

        Route::prefix('perfil')->name('perfil.')->group(function () {
            Route::get('/', [PerfilController::class, 'index'])->name('index');
            Route::post('/perfil/{id}', [PerfilController::class, 'update'])->name('update');
        });
        
        Route::prefix('instituicoes')->name('instituicoes.')->group(function () {
            Route::get('/', [InstituicaoController::class, 'index']);
        });

        // Grupo de rotas para 'visitantes'
        Route::prefix('visitante')->name('visitante.')->group(function () {
            Route::get('/', [VisitantesController::class, 'index'])->name('index');
            Route::get('/novo', [VisitantesController::class, 'novo'])->name('novo');
            Route::post('/salvar', [VisitantesController::class, 'store'])->name('store');
            Route::get('/editar/{id}', [VisitantesController::class, 'editar'])->name('editar');
            Route::post('/deletar/{id}', [VisitantesController::class, 'deletar'])->name('deletar');
            Route::post('/visitante/{id}', [VisitantesController::class, 'update'])->name('update');
            
        });

        // Grupo de rotas para 'congregado'
        Route::prefix('congregado')->name('congregado.')->group(function () {
            Route::get('/', [CongregadosController::class, 'index'])->name('index');
            Route::get('/novo', [CongregadosController::class, 'novo'])->name('novo');
            Route::post('/update', [CongregadosController::class, 'update'])->name('update');
            Route::post('/store', [CongregadosController::class, 'store'])->name('store');
            Route::delete('/deletar/{id}', [CongregadosController::class, 'deletar'])->name('deletar');
            Route::get('/editar/{id}', [CongregadosController::class, 'editar'])->name('editar');
        });
    });
});
