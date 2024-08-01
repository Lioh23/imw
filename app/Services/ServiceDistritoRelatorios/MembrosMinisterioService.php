<?php

namespace App\Services\ServiceDistritoRelatorios;

use App\Traits\FinanceiroUtils;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MembrosMinisterioService
{
    use FinanceiroUtils;
    use Identifiable;

    public function execute($dtano, $tipo)
    {
        if (empty($dtano)) {
            $dtano = Carbon::now()->format('Y');
        }


        $lancamentos = $this->handleLancamentos($dtano, $tipo);

        return [
            'lancamentos' => $lancamentos
        ];
    }

    private function handleLancamentos($dtano, $tipo)
    {
        $instituicaoPaiId = session()->get('session_perfil')->instituicao_id;

        $vinculoCondition = $tipo === 'C' ? ['C', 'M'] : ['M'];

        $results = DB::table('instituicoes_instituicoes as ii')
            ->select('ii.nome')
            ->selectRaw("
            COUNT(CASE 
                WHEN TIMESTAMPDIFF(YEAR, mm.data_nascimento, CURDATE()) BETWEEN 0 AND 9 THEN mm.id
                ELSE NULL
            END) AS Kids,
            COUNT(CASE 
                WHEN TIMESTAMPDIFF(YEAR, mm.data_nascimento, CURDATE()) BETWEEN 10 AND 13 THEN mm.id
                ELSE NULL
            END) AS Conexao,
            COUNT(CASE 
                WHEN TIMESTAMPDIFF(YEAR, mm.data_nascimento, CURDATE()) BETWEEN 14 AND 17 THEN mm.id
                ELSE NULL
            END) AS Fire,
            COUNT(CASE 
                WHEN TIMESTAMPDIFF(YEAR, mm.data_nascimento, CURDATE()) BETWEEN 18 AND 29 THEN mm.id
                ELSE NULL
            END) AS Move,
            COUNT(CASE 
                WHEN TIMESTAMPDIFF(YEAR, mm.data_nascimento, CURDATE()) BETWEEN 30 AND 59 AND mm.sexo = 'M' THEN mm.id
                ELSE NULL
            END) AS Homens,
            COUNT(CASE 
                WHEN TIMESTAMPDIFF(YEAR, mm.data_nascimento, CURDATE()) BETWEEN 30 AND 59 AND mm.sexo = 'F' THEN mm.id
                ELSE NULL
            END) AS Mulheres,
            COUNT(CASE 
                WHEN TIMESTAMPDIFF(YEAR, mm.data_nascimento, CURDATE()) >= 60 THEN mm.id
                ELSE NULL
            END) AS '60+'
        ")
            ->leftJoin('membresia_membros as mm', function ($join) use ($vinculoCondition) {
                $join->on('ii.id', '=', 'mm.igreja_id')
                    ->where('mm.status', '=', 'A')
                    ->whereIn('mm.vinculo', $vinculoCondition);
            })
            ->leftJoin('membresia_rolpermanente as mr', function ($join) use ($dtano) {
                $join->on('mr.membro_id', '=', 'mm.id')
                    ->whereYear('mr.dt_recepcao', '=', $dtano);
            })
            ->where('ii.instituicao_pai_id', $instituicaoPaiId)
            ->groupBy('ii.nome')
            ->get();

        return $results;
    }
}
