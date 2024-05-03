<?php

namespace App\Services\ServiceFinanceiroRelatorios;

use App\Models\MembresiaMembro;
use App\Models\FinanceiroGrade;
use App\Traits\Identifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LivroGradeService
{
    use Identifiable;

    public function execute($ano)
    {
      
        $grades =  $this->handleGrades($ano);
      
        return $grades;
    }


    private function handleGrades($ano)
    {
        $grade =  MembresiaMembro::leftJoin('financeiro_grades as fg', function ($join) use ($ano) {
            $join->on('membresia_membros.id', '=', 'fg.membro_id')
                 ->where('fg.ano', '=', $ano);
        })
        ->select(
            \DB::raw('membresia_membros.id'),
            \DB::raw('IFNULL(membresia_membros.rol_atual, "-") as rol_atual'),
            'membresia_membros.nome',
            \DB::raw('COALESCE(fg.jan, "0,00") as jan'),
            \DB::raw('COALESCE(fg.fev, "0,00") as fev'),
            \DB::raw('COALESCE(fg.mar, "0,00") as mar'),
            \DB::raw('COALESCE(fg.abr, "0,00") as abr'),
            \DB::raw('COALESCE(fg.mai, "0,00") as mai'),
            \DB::raw('COALESCE(fg.jun, "0,00") as jun'),
            \DB::raw('COALESCE(fg.jul, "0,00") as jul'),
            \DB::raw('COALESCE(fg.ago, "0,00") as ago'),
            \DB::raw('COALESCE(fg.`set`, "0,00") as `set`'),
            \DB::raw('COALESCE(fg.`out`, "0,00") as `out`'),
            \DB::raw('COALESCE(fg.nov, "0,00") as nov'),
            \DB::raw('COALESCE(fg.dez, "0,00") as dez'),
            \DB::raw('COALESCE(fg.o13, "0,00") as o13'),
            \DB::raw('COALESCE(fg.jan, 0.00) + COALESCE(fg.fev, 0.00) + COALESCE(fg.mar, 0.00) + COALESCE(fg.abr, 0.00) + COALESCE(fg.mai, 0.00) + COALESCE(fg.jun, 0.00) + COALESCE(fg.jul, 0.00) + COALESCE(fg.ago, 0.00) + COALESCE(fg.`set`, 0.00) + COALESCE(fg.`out`, 0.00) + COALESCE(fg.nov, 0.00) + COALESCE(fg.dez, 0.00) + COALESCE(fg.o13, 0.00) as valor_total')
        )
        ->get();
        return $grade;
    }
    


}
