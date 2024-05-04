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
        $resultado = MembresiaMembro::leftJoin('financeiro_grades as fg', function ($join) use ($ano) {
            $join->on('membresia_membros.id', '=', 'fg.membro_id')
                 ->where('fg.ano', '=', $ano);
        })
        ->select(
            'membresia_membros.id',
            \DB::raw('IFNULL(membresia_membros.rol_atual, "-") as rol_atual'),
            'membresia_membros.nome',
            \DB::raw('FORMAT(SUM(COALESCE(fg.jan, 0.00)), 2, "de_DE") as jan'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.fev, 0.00)), 2, "de_DE") as fev'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.mar, 0.00)), 2, "de_DE") as mar'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.abr, 0.00)), 2, "de_DE") as abr'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.mai, 0.00)), 2, "de_DE") as mai'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.jun, 0.00)), 2, "de_DE") as jun'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.jul, 0.00)), 2, "de_DE") as jul'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.ago, 0.00)), 2, "de_DE") as ago'),
            \DB::raw('FORMAT(COALESCE(SUM(fg.`set`), 0.00), 2, "de_DE") as `set`'),
            \DB::raw('FORMAT(COALESCE(SUM(fg.`out`), 0.00), 2, "de_DE") as `out`'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.nov, 0.00)), 2, "de_DE") as nov'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.dez, 0.00)), 2, "de_DE") as dez'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.o13, 0.00)), 2, "de_DE") as o13'),
            \DB::raw('FORMAT(SUM(COALESCE(fg.jan, 0.00) + COALESCE(fg.fev, 0.00) + COALESCE(fg.mar, 0.00) + COALESCE(fg.abr, 0.00) + COALESCE(fg.mai, 0.00) + COALESCE(fg.jun, 0.00) + COALESCE(fg.jul, 0.00) + COALESCE(fg.ago, 0.00) + COALESCE(fg.set, 0.00) + COALESCE(fg.out, 0.00) + COALESCE(fg.nov, 0.00) + COALESCE(fg.dez, 0.00) + COALESCE(fg.o13, 0.00)), 2, "de_DE") as valor_total')
        )
        ->groupBy('membresia_membros.id', 'rol_atual', 'membresia_membros.nome')
        ->orderBy('membresia_membros.nome')
        ->get();


            
        return $resultado;
    }
    
    


}
