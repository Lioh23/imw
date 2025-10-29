<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeuCartaPastoral;
use App\Traits\Identifiable;

class CartaPastoralGCeuService
{
    public function getList($id): array
    {
        $cartasPastorais = GCeuCartaPastoral::select('gceu_cartas_pastorais.*', 'pessoas_pessoas.nome as pastor')
                    ->join('pessoas_pessoas', 'pessoas_pessoas.id', 'gceu_cartas_pastorais.pessoa_id')
                    ->where('gceu_cartas_pastorais.instituicao_id', $id)->get();
        $data['cartasPastorais'] = $cartasPastorais;
        $data['instituicao'] = Identifiable::fetchSessionIgrejaLocal()->nome;
        $data['instituicao_id'] = Identifiable::fetchSessionIgrejaLocal()->id;
        return $data;
    }
}
