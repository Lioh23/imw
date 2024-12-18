<?php

namespace App\Services\ServiceClerigosPrebendas;


use App\Models\Prebenda;

class StorePrebendasClerigosService
{
    public function execute($request)
    {
        // Verifica se existe uma prebenda com o ano fornecido
        $prebendaExist = Prebenda::where('ano', $request->ano)->first();

        if ($prebendaExist) {
            // Se existir, atualiza esse único registro
            $prebendaExist->update(['ativo' => 0]);
        }

        // Cria uma nova prebenda
        Prebenda::create([
            'ano' => $request['ano'],
            'valor' => $request['valor'],
            'ativo' => 1,
        ]);
    }
}
