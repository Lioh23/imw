<?php

namespace App\Traits;

use App\Models\VwIgreja;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait GetIgrejasAll
{
    public static function fetchIgrejas($regiao, $params)
    {
        // $igrejas = DB::table('instituicoes_instituicoes as igreja')
        //     ->select(
        //         'distrito.id',
        //         'distrito.nome as distrito_nome',
        //         'igreja.id as id_igreja',
        //         'igreja.nome as igreja_nome',
        //         'igreja.email',
        //         'igreja.ddd', 
        //         'igreja.telefone',
        //     )->join('instituicoes_instituicoes as distrito', function ($join) {
        //         $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
        //     })
        //     ->where(['distrito.instituicao_pai_id' => $regiao])
        //     ->orderBy('distrito.nome')
        //     ->orderBy('igreja.id')
        //     ->get();

        $igrejas = VwIgreja::whereIn('distrito_id', Identifiable::fetchDistritosIdByRegiao(Identifiable::fetchtSessionRegiao()->id))
            ->whereNull('deleted_at')
            ->where('ativo', 1)->get();
        return $igrejas;
    }

}
