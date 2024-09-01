<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait QuantidadeMembrosUtils
{
	public static function fetch($dataInicial, $dataFinal, $tipo, $distritoId): Collection
	{
        $vinculoCondition = $tipo === 'C' ? ['C', 'M'] : ['M'];

        $results = DB::table('instituicoes_instituicoes as ii')
			->select('ii.id', 'ii.nome')
			->selectRaw("
				COUNT(CASE 
					WHEN mr.dt_recepcao <= '{$dataInicial}' AND (mr.dt_exclusao IS NULL OR mr.dt_exclusao >= '{$dataInicial}') THEN mm.id
					ELSE NULL
				END) AS total_ate_datainicial,
				COUNT(CASE 
					WHEN mr.dt_recepcao <= '{$dataFinal}' AND (mr.dt_exclusao IS NULL OR mr.dt_exclusao >= '{$dataFinal}') THEN mm.id
					ELSE NULL
				END) AS total_ate_datafinal
			")
			->leftJoin('membresia_membros as mm', function ($join) use ($vinculoCondition) {
				$join->on('ii.id', '=', 'mm.igreja_id')
					->whereIn('mm.vinculo', $vinculoCondition);
			})
			->leftJoin('membresia_rolpermanente as mr', function ($join) {
				$join->on('mr.membro_id', '=', 'mm.id');
			})
			->where('ii.instituicao_pai_id', $distritoId)
			->groupBy('ii.id', 'ii.nome')
			->get();

        return $results;
	}
}