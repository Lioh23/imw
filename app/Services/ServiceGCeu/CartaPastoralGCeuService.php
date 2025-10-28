<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Traits\Identifiable;

class CartaPastoralGCeuService
{
    public function getList($id): array
    {
        $cartasPastorais = GCeu::select('gceu_cartas_pastorais.*', 'pessoas_pessoas.nome as pastor')
                    ->join('gceu_cartas_pastorais','gceu_cartas_pastorais.gceu_cadastro_id', 'gceu_cadastros.id')
                    ->join('pessoas_pessoas', 'pessoas_pessoas.id', 'gceu_cartas_pastorais.pessoa_id')
                    ->where('gceu_cadastros.id', $id)->get();
        $data['gceu'] = GCeu::where('id', $id)->first();
        $data['cartasPastorais'] = $cartasPastorais;
        return $data;
    }
}
