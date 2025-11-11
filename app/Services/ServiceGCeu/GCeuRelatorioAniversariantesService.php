<?php

namespace App\Services\ServiceGCeu;

use App\Models\GCeu;
use Illuminate\Support\Facades\DB;

class GCeuRelatorioAniversariantesService
{
    public function getList($igrejaId)
    {
        $dados =  GCeu::select(
                        'gceu_cadastros.nome as gceu',
                        'membresia_membros.id',
                        'membresia_membros.congregacao_id',
                        'membresia_membros.nome', 
                        'membresia_membros.data_nascimento',
                        DB::raw("DATE_FORMAT(data_nascimento, '%d/%m') aniversario"),
                        DB::raw("TIMESTAMPDIFF(YEAR, data_nascimento, curdate()) idade"),
                        DB::raw("CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                                    WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                                    ELSE telefone_whatsapp END contato")
                    )
                ->join('gceu_membros', 'gceu_membros.gceu_cadastro_id', 'gceu_cadastros.id')
                ->join('membresia_membros', 'membresia_membros.id', 'gceu_membros.membro_id')
                ->join('gceu_funcoes', 'gceu_funcoes.id', 'gceu_membros.gceu_funcao_id')
                ->leftJoin('membresia_contatos', 'membresia_contatos.membro_id', 'membresia_membros.id')
                ->where(['gceu_cadastros.instituicao_id' => $igrejaId, 'gceu_cadastros.status' => 'A'])
                ->orderBy('gceu_cadastros.nome', 'ASC')
                ->orderBy('membresia_membros.nome', 'ASC')
                ->get();
        return ['dados' => $dados];
    }
}
