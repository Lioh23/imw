<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeuCartaPastoral;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\DB;

class CartaPastoralGCeuRegiaoService
{

    public function getList($regiaoId): array
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
            ->join('instituicoes_instituicoes as regiao', function ($join) {
                $join->on('regiao.id', '=', 'distrito.instituicao_pai_id');
            })
            ->join('gceu_cartas_pastorais as cartas', function ($join) {
                $join->on('cartas.instituicao_id', '=', 'igreja.id');
            })
            ->join('pessoas_pessoas', 'pessoas_pessoas.id', 'cartas.pessoa_id')
            ->where(['regiao.id' => $regiaoId, 'cartas.status' => 'A'])
            ->when(request()->get('instituicao_id'), function ($query) {
                $query->where('igreja.id', request()->get('instituicao_id'));
            })
            ->when(request()->get('distrito_id'), function ($query) {
                $query->where('distrito.id', request()->get('distrito_id'));
            })
            ->when(request()->get('igreja_id'), function ($query) {
                $query->where('igreja.id', request()->get('igreja_id'));
            })
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();

            $distritos = DB::table('instituicoes_instituicoes as distrito')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
            )->join('instituicoes_instituicoes as regiao', function ($join) {
                $join->on('regiao.id', '=', 'distrito.instituicao_pai_id');
            })
            ->where(['regiao.id' => $regiaoId, 'distrito.tipo_instituicao_id' => 2])
            ->orderBy('distrito.nome')
            ->get();
        
            $igrejas = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })->join('instituicoes_instituicoes as regiao', function ($join) {
                $join->on('regiao.id', '=', 'distrito.instituicao_pai_id');
            })
            ->where(['regiao.id' => $regiaoId, 'igreja.tipo_instituicao_id' => 1])
            ->orderBy('igreja.nome')
            ->get();
            
        $data['cartasPastorais'] = $cartasPastorais;
        $data['instituicao'] = Identifiable::fetchtSessionRegiao()->nome;
        $data['instituicao_id'] = Identifiable::fetchtSessionRegiao()->id;
        $data['igrejas'] = $igrejas;
        $data['distritos'] = $distritos;
        return $data;
    }
}