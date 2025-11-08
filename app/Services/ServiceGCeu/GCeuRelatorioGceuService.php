<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;

class GCeuRelatorioGceuService
{
    public function getList($igrejaId)
    {
        $dados =  GCeu::where(['gceu_cadastros.instituicao_id' => $igrejaId, 'gceu_cadastros.status' => 'A'])->get();
        return ['dados' => $dados];
    }
}