<?php

namespace App\Traits;

use App\Services\ServiceIgrejas\Igrejas;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait AspirantesIgrejasDadosDistrito
{
    public static function fetchAspirantesPorIgrejas($params)
    {
        $distritoId = $params['distritoId'];
        $aspirantes = DB::table('instituicoes_instituicoes as igreja')
            ->select(
                'distrito.id',
                'distrito.nome as distrito_nome',
                'igreja.id as id_igreja',
                'igreja.nome as igreja_nome',
                'mm.nome as membro_nome',
                'mm.sexo',
                'mm.estado_civil',
                'mm.cpf',
                DB::raw("DATE_FORMAT(mm.data_nascimento, '%d/%m/%Y') data_nascimento"),
                DB::raw("CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_whatsapp IS NOT NULL AND telefone_whatsapp <> '' THEN telefone_whatsapp
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE '' END contato"),
                DB::raw("CASE WHEN email_preferencial IS NOT NULL AND email_preferencial <> '' THEN email_preferencial
                              WHEN email_alternativo IS NOT NULL AND email_alternativo <> '' THEN email_alternativo
                              ELSE '' END email"),
            )->join('instituicoes_instituicoes as distrito', function ($join) {
                $join->on('distrito.id', '=', 'igreja.instituicao_pai_id');
            })
            ->join('membresia_membros as mm', function ($join) {
                $join->on('mm.igreja_id', '=', 'igreja.id');
            })
             ->join('membresia_contatos as mc', function ($join) {
                $join->on('mc.membro_id', '=', 'mm.id');
            })
            ->where(['distrito.id' => $distritoId, 'mm.funcao_eclesiastica_id' => 7])
            ->orderBy('distrito.nome')
            ->orderBy('igreja.id')
            ->get();
        return $aspirantes;
    }
}
