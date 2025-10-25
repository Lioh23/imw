<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Traits\Identifiable;

class CartaPastoralGCeuService
{
    public function getList($id): array
    {
        $data['gceu'] = GCeu::where('id', $id)->first();
        $data['cartasPastorais'] = GCeu::join('gceu_cartas_pastorais','gceu_cartas_pastorais.gceu_cadastro_id', 'gceu_cadastros.id')->where('gceu_cadastros.id', $id)->first();
        return $data;
    }
}
