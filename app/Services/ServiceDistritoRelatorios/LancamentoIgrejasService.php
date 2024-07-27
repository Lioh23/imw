<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Models\FinanceiroCaixa;
use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LancamentoIgrejasService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dtano, $distritoID)
    {
        if (empty($dtano)) {
            $dtano = Carbon::now()->format('Y');
        } 

        $distritoSelect  = $this->handleListaDistritos();


        return [
            'distritoSelect' => $distritoSelect
        ];
    }


    private function handleListaDistritos()
    {
        return DB::table('instituicoes_instituicoes as ii')
            ->join('instituicoes_tiposinstituicao as it', 'it.id', '=', 'ii.tipo_instituicao_id')
            ->select('ii.id', 'ii.nome as descricao')
            ->where('ii.tipo_instituicao_id', '=', 2) //Distrito
            ->where('ii.ativo', '=', 1) //Ativo
            ->where('it.sigla', '=', 'D') //Distrito
            ->where('ii.instituicao_pai_id', '=', 23) //id da 6 Regiao
            ->orderBy('ii.nome', 'ASC')
            ->get();
    }

}
