<?php

namespace App\Services\ServicePrebendas;

use App\Models\PessoasPrebenda;
use App\Models\Prebenda;
use App\Traits\Identifiable;

class StorePrebendasService
{
    use Identifiable;
    public function execute($request)
    {

        PessoasPrebenda::create([
            'pessoa_id' => Identifiable::fetchSessionPessoa()->id,
            'ano' => $request['ano'],
            'valor' => $request['valor'],
        ]);
    }
}
