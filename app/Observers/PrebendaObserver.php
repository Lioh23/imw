<?php

namespace App\Observers;

use App\Models\Prebenda;

class PrebendaObserver
{

    public function creating(Prebenda $prebenda)
    {
        if ($prebenda->valor) {
            $valor = str_replace(['R$', '.'], '', $prebenda->valor);
            $prebenda->valor = str_replace(',', '.', $valor);
        }
    }

    public function updating(Prebenda $prebenda)
    {
        if ($prebenda->valor) {
            $valor = str_replace(['R$', '.'], '', $prebenda->valor);
            $prebenda->valor = str_replace(',', '.', $valor);
        }
    }
}
