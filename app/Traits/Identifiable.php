<?php 

namespace App\Traits;

use App\Exceptions\CongregadoNotFoundException;
use App\Exceptions\MembroNotFoundException;
use App\Exceptions\VisitanteNotFoundException;
use App\Models\MembresiaMembro;
use App\Models\MembresiaSituacao;
use App\Models\PessoasPessoa;

trait Identifiable
{
    public static function fetchPastores()
    {
        return PessoasPessoa::all();
    }

    public static function fetchPessoa($id, $vinculo)
    {
        $membro = MembresiaMembro::where('id', $id)
            ->where('vinculo', $vinculo)
            ->firstOr(function() use ($vinculo) {
                switch ($vinculo) {
                    case MembresiaMembro::VINCULO_MEMBRO:
                        throw new MembroNotFoundException();
                    
                    case MembresiaMembro::VINCULO_CONGREGADO:
                        throw new CongregadoNotFoundException();

                    case MembresiaMembro::VINCULO_VISITANTE:
                        throw new VisitanteNotFoundException();
                }
            });

        return $membro;
    }

    public static function fetchModos($modo = null)
    {
        return MembresiaSituacao::when((bool) $modo, function ($query) use ($modo) {
            $query->where('tipo', $modo);
        })->get();
    }
}