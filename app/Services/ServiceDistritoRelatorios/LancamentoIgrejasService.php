<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LancamentoIgrejasService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dtano, $igrejasID)
    {
        if (empty($dtano)) {
            $dtano = Carbon::now()->format('Y');
        } 

        $igrejaSelect  = $this->handleListaIgrejas();


        return [
            'igrejaSelect' => $igrejaSelect
        ];
    }


    private function handleListaIgrejas()
    {
        return DB::table('instituicoes_instituicoes as ii')
        ->join('instituicoes_tiposinstituicao as it', 'it.id', '=', 'ii.tipo_instituicao_id')
        ->select('ii.id', 'ii.nome as descricao')
        ->where('ii.instituicao_pai_id', '=', session()->get('session_perfil')->instituicao_id) // id específico fornecido
        ->where('ii.tipo_instituicao_id', '=', 1) // Tipo de instituição específico Igreja
        ->where('ii.ativo', '=', 1) // Apenas ativos
        ->orderBy('ii.nome', 'ASC') // Ordenar por nome em ordem ascendente
        ->get();
    
    }

}
