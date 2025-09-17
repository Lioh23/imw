<?php

namespace App\Services\ServiceRegiaoRelatorios;

use App\Models\InstituicoesInstituicao;
use App\Traits\SaldoIgrejasUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;

class SaldoIgrejasService
{
    use SaldoIgrejasUtils;
    use Identifiable;

    public function execute($dt, $distritoId)
    {
        $dt ??= Carbon::now()->format('Y/m');

        $regiao = Identifiable::fetchtSessionRegiao();
        if($distritoId == 'all'){
            $distritos = Identifiable::fetchDistritosByRegiao($regiao->id);
            foreach($distritos as $distrito){
                $distritoId = $distrito->id;
                $saldosDistritos[] = [
                    'lancamentos' => SaldoIgrejasUtils::fetch($dt, $distritoId),
                    'instituicao' => InstituicoesInstituicao::find($distritoId)
                ];
            }
            $dados = [
                'saldosDistritos' =>  $saldosDistritos,
                'distritos'   => $distritos,
                'titulo' => "SALDO DE CAIXAS - Todos Distritos $dt"
            ];
        }else{
            $instituicao = InstituicoesInstituicao::find($distritoId);
            $nomeInstituicao = isset($instituicao->nome) ? $instituicao->nome : '';
            $dados = [
                'lancamentos' => SaldoIgrejasUtils::fetch($dt, $distritoId),
                'distritos'   => Identifiable::fetchDistritosByRegiao($regiao->id),
                'instituicao' => $instituicao,
                'titulo' => "SALDO DE CAIXAS - $nomeInstituicao $dt"
            ];
        }       

        return $dados;

    }
}
