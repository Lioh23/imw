<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeuCartaPastoral;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\DB;

class CartaPastoralGCeuDistritoService
{
    public function getList($distritoId): array
    {
        $cartasPastorais = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
                'cartas.*',
                'pessoas_pessoas.nome as pastor'
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })
            ->join('gceu_cartas_pastorais as cartas', function ($join) {
                $join->on('cartas.instituicao_id', '=', 'igreja.id');
            })
            ->join('pessoas_pessoas', 'pessoas_pessoas.id', 'cartas.pessoa_id')
            ->where(['distrito.id' => $distritoId, 'cartas.status' => 'A'])
            ->when(request()->get('instituicao_id'), function ($query) {
                $query->where('igreja.id', request()->get('instituicao_id'));
            })
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();

        
            $igrejas = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })
            ->where(['distrito.id' => $distritoId])
            ->orderBy('igreja.nome')
            ->get();
            
        $data['cartasPastorais'] = $cartasPastorais;
        $data['instituicao'] = Identifiable::fetchtSessionDistrito()->nome;
        $data['instituicao_id'] = Identifiable::fetchtSessionDistrito()->id;
        $data['igrejas'] = $igrejas;
        return $data;
    }
}