<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use App\Models\GCeuFuncoes;

class GCeuRelatorioFuncoesService
{
    public function getList($igrejaId, $funcaoId)
    {
        $dados =  GCeu::select('gceu_cadastros.*', 'gceu_funcoes.funcao', 'membresia_membros.nome as lider', 'membresia_contatos.telefone_preferencial')
                ->join('gceu_membros', 'gceu_membros.gceu_cadastro_id', 'gceu_cadastros.id')
                ->join('membresia_membros', 'membresia_membros.id', 'gceu_membros.membro_id')
                ->join('gceu_funcoes', 'gceu_funcoes.id', 'gceu_membros.gceu_funcao_id')
                ->leftJoin('membresia_contatos', 'membresia_contatos.membro_id', 'membresia_membros.id')
                ->where(['gceu_cadastros.instituicao_id' => $igrejaId, 'gceu_cadastros.status' => 'A'])
                ->when($funcaoId, function ($query) use ($funcaoId) {
                        $query->where('gceu_membros.gceu_funcao_id', $funcaoId);
                    })
                ->get();
        $funcoes = GCeuFuncoes::get();
        return ['dados' => $dados, 'funcoes' => $funcoes];
    }

     public function getFuncao($id)
    {
        return  GCeuFuncoes::find($id);
    }
    
}