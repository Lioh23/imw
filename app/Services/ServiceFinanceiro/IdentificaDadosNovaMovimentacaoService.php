<?php

namespace App\Services\ServiceFinanceiro;

use App\Models\FinanceiroFornecedores;
use App\Models\FinanceiroTipoPaganteFavorecido;
use App\Models\InstituicoesInstituicao;
use App\Models\MembresiaMembro;
use App\Models\Mes;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use PhpParser\Node\Expr\Cast\Object_;

class IdentificaDadosNovaMovimentacaoService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($tipo = null)
    {

        $instituicao = InstituicoesInstituicao::where('id', session()->get('session_perfil')->instituicao_id)->first();

        if($instituicao->tipoInstituicao->sigla == 'I') {
            $clerigos = Identifiable::fetchPastores();
            $membros = FinanceiroUtils::membros();
        } else {
            $membros = [];
            $clerigos = [];
        }
        
        return [
            'planoContas'              => FinanceiroUtils::planoContas($tipo),
            'caixas'                   => FinanceiroUtils::caixas(),
            'tiposPagantesFavorecidos' => FinanceiroTipoPaganteFavorecido::all(),
            'membros'                  => $membros,
            'fornecedores'             => FinanceiroUtils::fornecedores(),
            'clerigos'                 => $clerigos,
            'tipoInstituicao'          => $instituicao,
            'meses'                    => (Object) Mes::get(),
        ];
    }
}