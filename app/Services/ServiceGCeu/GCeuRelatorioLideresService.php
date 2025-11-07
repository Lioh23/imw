<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Models\GCeuDiario;
use Illuminate\Support\Facades\Redirect;

class GCeuRelatorioLideresService
{
    public function getList($igrejaId)
    {
        $dados =  GCeu::select('gceu_cadastros.*', 'membresia_membros.nome as lider', 'membresia_contatos.telefone_preferencial')
                ->join('gceu_membros', 'gceu_membros.gceu_cadastro_id', 'gceu_cadastros.id')
                ->join('membresia_membros', 'membresia_membros.id', 'gceu_membros.membro_id' )
                ->leftJoin('membresia_contatos', 'membresia_contatos.membro_id', 'membresia_membros.id')
                ->where(['gceu_cadastros.instituicao_id' => $igrejaId, 'gceu_cadastros.status' => 'A', 'gceu_membros.gceu_funcao_id' => 1])->get();
        return ['dados' => $dados];
    }
}