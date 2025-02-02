<?php

namespace App\Services\ServiceClerigosPrebendas;

use App\Models\Prebenda;

class UpdatePrebendaClerigosService
{
    public function execute($request)
    {
        $prebenda = Prebenda::where('ano', $request->ano)->first();
        $prebenda->update([
            'ano' => $request->input('ano'),
            'valor' => $request->input('valor'),
        ]);
    }
}
