<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeuDiario;

class GCeuDiarioPresencaFaltaService
{
    public function salvarDiario($data)
    {
        $diario = [
            $data
        ];
        return GCeuDiario::create($diario);
    }
}