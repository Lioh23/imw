<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CongregadosController;
use App\Http\Controllers\FinanceiroCaixasController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\FinanceiroPlanoContaController;
use App\Http\Controllers\FinanceiroRelatorioController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\MembrosController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VisitantesController;
use App\Http\Middleware\VerificaInstituicao;
use App\Http\Middleware\VerificaPerfil;
use Illuminate\Support\Facades\Route;

// Rotas de autenticação

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rota para mostrar o formulário de esqueci a senha
Route::get('/esqueci-senha', [AuthController::class, 'showResetRequestForm'])->name('password.request');

// Rota para enviar o link de redefinição de senha
Route::post('/esqueci-senha', [AuthController::class, 'submitResetRequest'])->name('password.email');

// Rota para processar a redefinição de senha (GET)
Route::get('/redefinir-senha', [AuthController::class, 'showResetForm'])->name('password.reset');

// Rota para processar a redefinição de senha
Route::post('/redefinir-senha', [AuthController::class, 'reset'])->name('password.reset-post');


// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    Route::middleware([VerificaPerfil::class])->group(function () {

        //Estas duas rotas estão com VerificaPerfil Middleware desabilitados
        Route::get('/selecionarPerfil', [HomeController::class, 'selecionarPerfil'])->withoutMiddleware([VerificaPerfil::class])->name('selecionarPerfil');
        Route::post('/postPerfil', [HomeController::class, 'postPerfil'])->withoutMiddleware([VerificaPerfil::class])->name('postPerfil');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index')->middleware(['seguranca:admin-index']);
            Route::get('/novo', [AdminController::class, 'novo'])->name('novo')->middleware(['seguranca:usuarios-cadastrar']);
            Route::post('/update/{id}', [AdminController::class, 'update'])->name('update')->middleware(['seguranca:usuarios-atualizar']);
            Route::post('/store', [AdminController::class, 'store'])->name('store')->middleware(['seguranca:usuarios-cadastrar']);
            Route::delete('/deletar/{id}', [AdminController::class, 'deletar'])->name('deletar')->middleware(['seguranca:usuarios-excluir']);
            Route::get('/editar/{id}', [AdminController::class, 'editar'])->name('editar')->middleware(['seguranca:usuarios-editar']);
        });


        // Grupo de rotas para 'membresia'
        Route::prefix('membro')->name('membro.')->group(function () {
            Route::get('', [MembrosController::class, 'index'])->name('index')->middleware(['seguranca:membros-index']);
            Route::get('list', [MembrosController::class, 'list'])->name('list')->middleware(['seguranca:membros-index']);
            Route::get('editar/{id}', [MembrosController::class, 'editar'])->name('editar')->middleware(['seguranca:membros-editar']);
            Route::get('receber-novo/{id}', [MembrosController::class, 'receberNovo'])->name('receber_novo')->middleware(['seguranca:membros-recebernovo']);
            Route::post('receber-novo-store/{id}', [MembrosController::class, 'storeReceberNovo'])->name('receber_novo.store')->middleware(['seguranca:membros-recebernovo']);
            Route::post('atualizar/{id}', [MembrosController::class, 'update'])->name('update')->middleware(['seguranca:membros-atualizar']);
            Route::get('exclusao/{id}', [MembrosController::class, 'exclusao'])->name('exclusao')->middleware(['seguranca:membros-excluir']);
            Route::delete('exclusao/store/{id}', [MembrosController::class, 'storeExclusao'])->name('exclusao.store')->middleware(['seguranca:membros-excluir']);
            Route::get('reintegrar/{id}', [MembrosController::class, 'reintegrar'])->name('reintegrar')->middleware(['seguranca:membros-reintegrar']);
            Route::post('reintegrar/store/{id}', [MembrosController::class, 'storeReintegracao'])->name('reintegrar.store')->middleware(['seguranca:membros-cadastrar']);
            Route::get('transferencia/interna/{id}', [MembrosController::class, 'transferenciaInterna'])->name('transferencia_interna')->middleware(['seguranca:membros-transferenciainterna']);
            Route::post('transferencia/interna/store/{id}', [MembrosController::class, 'storeTransferenciaInterna'])->name('transferencia_interna.store')->middleware(['seguranca:membros-transferenciainterna']);
            Route::get('exclusao/transferencia/{id}', [MembrosController::class, 'exclusaoPorTransferencia'])->name('exclusao_transferencia')->middleware(['seguranca:membros-exclusaotransferencia']);
            Route::post('exclusao/transferencia/store/{id}', [MembrosController::class, 'storeExclusaoPorTransferencia'])->name('exclusao_transferencia.store')->middleware(['seguranca:membros-exclusaotransferencia']);
            Route::delete('exclusao/transferencia/cancel/{notificacaoTransferencia}', [MembrosController::class, 'cancelExclusaoPorTransferencia'])->name('exclusao_transferencia.cancel')->middleware(['seguranca:membros-exclusaotransferencia']);
            Route::get('receber-membro-externo/{notificacao}', [MembrosController::class, 'receberMembroExterno'])->name('receber_membro_externo')->middleware(['seguranca:membros-recebermembroexterno']);
            Route::post('receber-membro-externo/store/{notificacao}', [MembrosController::class, 'storeReceberMembroExterno'])->name('receber_membro_externo.store')->middleware(['seguranca:membros-recebermembroexterno']);
            Route::get('disciplinar/{id}', [MembrosController::class, 'disciplinar'])->name('disciplinar')->middleware(['seguranca:membros-disciplinar']);
            Route::post('disciplinar/store/{id}', [MembrosController::class, 'storeDisciplinar'])->name('disciplinar.store')->middleware(['seguranca:membros-disciplinar']);
            Route::put('disciplinar/update/{id}', [MembrosController::class, 'updateDisciplinar'])->name('disciplinar.update')->middleware(['seguranca:membros-disciplinar']);

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

        Route::prefix('instituicoesLocais')->name('instituicoesLocais.')->group(function () {
            Route::get('/', [InstituicaoController::class, 'instituicoesLocais']);
        });

        // Grupo de rotas para 'visitantes'
        Route::prefix('visitante')->name('visitante.')->group(function () {
            Route::get('/', [VisitantesController::class, 'index'])->name('index')->middleware(['seguranca:visitantes-index']);
            Route::get('/novo', [VisitantesController::class, 'novo'])->name('novo')->middleware(['seguranca:visitantes-cadastrar']);
            Route::post('/salvar', [VisitantesController::class, 'store'])->name('store')->middleware(['seguranca:visitantes-cadastrar']);
            Route::get('/editar/{id}', [VisitantesController::class, 'editar'])->name('editar')->middleware(['seguranca:visitantes-atualizar']);
            Route::post('/visitante/{id}', [VisitantesController::class, 'update'])->name('update')->middleware(['seguranca:visitantes-atualizar']);
            Route::post('/deletar/{id}', [VisitantesController::class, 'deletar'])->name('deletar')->middleware(['seguranca:visitantes-excluir']);

        });

        // Grupo de rotas para 'congregado'
        Route::prefix('congregado')->name('congregado.')->group(function () {
            Route::get('/', [CongregadosController::class, 'index'])->name('index')->middleware(['seguranca:congregados-index']);
            Route::get('list', [CongregadosController::class, 'list'])->name('list')->middleware(['seguranca:congregados-index']);
            Route::get('/novo', [CongregadosController::class, 'novo'])->name('novo')->middleware(['seguranca:congregados-cadastrar']);
            Route::post('/update', [CongregadosController::class, 'update'])->name('update')->middleware(['seguranca:congregados-atualizar']);
            Route::post('/store', [CongregadosController::class, 'store'])->name('store')->middleware(['seguranca:congregados-cadastrar']);
            Route::delete('/deletar/{id}', [CongregadosController::class, 'deletar'])->name('deletar')->middleware(['seguranca:congregados-excluir']);
            Route::get('/editar/{id}', [CongregadosController::class, 'editar'])->name('editar')->middleware(['seguranca:congregados-editar']);
        });

        /* Por enquanto somente visualiações */
        Route::prefix('financeiro')->name('financeiro.')->group(function () {
            Route::get('/movimento-caixa', [FinanceiroController::class, 'movimentocaixa'])->name('movimento.caixa')->middleware(['seguranca:financeiro-movimentocaixa-index']);
            Route::get('/consolidar-caixa', [FinanceiroController::class, 'consolidarcaixa'])->name('consolidar.caixa')->middleware(['seguranca:financeiro-consolidarcaixa']);
            Route::post('/consolidar/store', [FinanceiroController::class, 'consolidarstore'])->name('consolidar.store')->middleware(['seguranca:financeiro-caixas']);
            Route::get('/entrada', [FinanceiroController::class, 'entrada'])->name('entrada')->middleware(['seguranca:financeiro-caixas']);
            Route::post('/entrada/store', [FinanceiroController::class, 'storeEntrada'])->name('entrada.store')->middleware(['seguranca:financeiro-caixas']);
            Route::put('/entrada/{id}', [FinanceiroController::class, 'updateEntrada'])->name('entrada.update')->middleware(['seguranca:financeiro-caixas']);
            Route::get('/saida', [FinanceiroController::class, 'saida'])->name('saida')->middleware(['seguranca:financeiro-caixas']);
            Route::put('/saida/{id}', [FinanceiroController::class, 'updateSaida'])->name('saida.update')->middleware(['seguranca:financeiro-caixas']);
            Route::post('/saida/store', [FinanceiroController::class, 'storeSaida'])->name('saida.store')->middleware(['seguranca:financeiro-caixas']);
            Route::get('/transferencia', [FinanceiroController::class, 'transferencia'])->name('transferencia')->middleware(['seguranca:financeiro-caixas']);
            Route::post('/transferencia/store', [FinanceiroController::class, 'storeTransferencia'])->name('transferencia.store')->middleware(['seguranca:financeiro-caixas']);
            Route::get('/saldo', [FinanceiroController::class, 'saldo'])->name('saldo')->middleware(['seguranca:financeiro-caixas']);
            Route::get('/editar-movimento/{id}/{tipo_lancamento}', [FinanceiroController::class, 'editarMovimento'])->name('editarMovimento')->middleware(['seguranca:financeiro-caixas']);
            Route::delete('/excluir-movimento/{id}', [FinanceiroController::class, 'excluirMovimento'])->name('excluirMovimento')->middleware(['seguranca:financeiro-caixas']);
            Route::get('/anexos/{id_lancamento}', [FinanceiroController::class, 'buscarAnexos'])->name('buscarAnexos')->middleware(['seguranca:financeiro-caixas']);
            //Plano de Conta
            Route::get('/plano-conta', [FinanceiroPlanoContaController::class, 'index'])->name('plano.conta')->middleware(['seguranca:financeiro-planoconta']);

            //Caixas
            Route::get('/caixas', [FinanceiroCaixasController::class, 'index'])->name('caixas')->middleware(['seguranca:financeiro-caixas']);
            Route::get('/caixas/novo', [FinanceiroCaixasController::class, 'novo'])->name('caixas.novo')->middleware(['seguranca:financeiro-caixas']);
            Route::post('/caixas/store', [FinanceiroCaixasController::class, 'store'])->name('caixas.store')->middleware(['seguranca:financeiro-caixas']);
            Route::delete('/caixas/deletar/{id}', [FinanceiroCaixasController::class, 'deletar'])->name('caixas.deletar')->middleware(['seguranca:financeiro-caixas']);
            Route::get('/editar/{id}', [FinanceiroCaixasController::class, 'editar'])->name('caixas.editar')->middleware(['seguranca:financeiro-caixas']);
            Route::post('/update/{id}', [FinanceiroCaixasController::class, 'update'])->name('caixas.update')->middleware(['seguranca:financeiro-caixas']);

            //Relatorios
            Route::get('/relatorio/movimento-diario', [FinanceiroRelatorioController::class, 'movimentodiario'])->name('relatorio-movimento-diario')->middleware(['seguranca:menu-relatorios']);
            Route::get('/relatorio/livrorazao', [FinanceiroRelatorioController::class, 'livrorazao'])->name('relatorio-livrorazao')->middleware(['seguranca:menu-relatorios']);
            Route::get('/relatorio/livrocaixa', [FinanceiroRelatorioController::class, 'livrocaixa'])->name('relatorio-livrocaixa')->middleware(['seguranca:menu-relatorios']);
            Route::get('/relatorio/livrograde', [FinanceiroRelatorioController::class, 'livrograde'])->name('relatorio-livrograde')->middleware(['seguranca:menu-relatorios']);
                Route::post('/relatorio/livrogradepost', [FinanceiroRelatorioController::class, 'livrogradepost'])->name('livrogradepost')->middleware(['seguranca:menu-relatorios']);
                Route::post('/relatorio/livrograde/store', [FinanceiroRelatorioController::class, 'livrogradestore'])->name('livrograde.store')->middleware(['seguranca:menu-relatorios']);
            Route::get('/relatorio/balancete', [FinanceiroRelatorioController::class, 'balancete'])->name('relatorio-balancete')->middleware(['seguranca:menu-relatorios']);

        });

         /* Por enquanto somente visualiações */
         Route::prefix('fornecedor')->name('fornecedor.')->group(function () {
            Route::get('/', [FornecedorController::class, 'index'])->name('index')->middleware(['seguranca:fornecedores-index']);
            Route::get('/novo', [FornecedorController::class, 'novo'])->name('novo')->middleware(['seguranca:fornecedores-cadastrar']);
            Route::delete('/deletar/{id}', [FornecedorController::class, 'deletar'])->name('deletar')->middleware(['seguranca:fornecedores-deletar']);
            Route::get('/editar/{id}', [FornecedorController::class, 'editar'])->name('editar')->middleware(['seguranca:fornecedores-editar']);
            Route::post('/store', [FornecedorController::class, 'store'])->name('store')->middleware(['seguranca:fornecedores-cadastrar']);
            Route::post('/update/{id}', [FornecedorController::class, 'update'])->name('update')->middleware(['seguranca:fornecedores-editar']);
        });

        // Grupo de rotas para 'usuarios'
        Route::prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/', [UsuarioController::class, 'index'])->name('index')->middleware(['seguranca:usuarios-index']);
            Route::get('/novo', [UsuarioController::class, 'novo'])->name('novo')->middleware(['seguranca:usuarios-cadastrar']);
            Route::post('/update/{id}', [UsuarioController::class, 'update'])->name('update')->middleware(['seguranca:usuarios-atualizar']);
            Route::post('/store', [UsuarioController::class, 'store'])->name('store')->middleware(['seguranca:usuarios-cadastrar']);
            Route::delete('/deletar/{id}', [UsuarioController::class, 'deletar'])->name('deletar')->middleware(['seguranca:usuarios-excluir']);
            Route::get('/editar/{id}', [UsuarioController::class, 'editar'])->name('editar')->middleware(['seguranca:usuarios-editar']);
            Route::get('/check-email', [UsuarioController::class, 'checkEmail'])->name('checkEmail')->middleware(['seguranca:usuarios-cadastrar']);
        });

        // Relatórios
        Route::prefix('relatorio')->name('relatorio.')->controller(RelatorioController::class)->group(function () {
            Route::get('/membresia', 'membresia')->name('membresia')->middleware('seguranca:relatorio-membresia');
            Route::get('/aniversariantes', 'aniversariantes')->name('aniversariantes')->middleware('seguranca:relatorio-aniversariantes');
            Route::get('/historico-eclesiastico', 'historicoEclesiastico')->name('historico-eclesiastico')->middleware('seguranca:relatorio-historico-eclesiastico');
        });

        // Segurança
        Route::get('/selecionarPerfil', [HomeController::class, 'selecionarPerfil'])->withoutMiddleware([VerificaPerfil::class])->name('selecionarPerfil');
    });
});
