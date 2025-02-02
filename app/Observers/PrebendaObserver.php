<?php

namespace App\Observers;

use App\Models\Prebenda;

class PrebendaObserver
{

    public function creating(Prebenda $prebenda)
    {
        if (!empty($prebenda->valor)) {
            $valor = preg_replace('/[^0-9,]/', '', $prebenda->valor);
            $valor = str_replace(',', '.', $valor);
            $prebenda->valor = (float) $valor;
        }
    }

    public function updating(Prebenda $prebenda): void
    {

        if (!empty($prebenda->valor)) {
            $valor = preg_replace('/[^0-9,]/', '', $prebenda->valor);
            $valor = str_replace(',', '.', $valor);
            $prebenda->valor = (float) $valor;
        }
    }
}
