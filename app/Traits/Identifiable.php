<?php 

namespace App\Traits;

use App\Exceptions\CongregadoNotFoundException;
use App\Exceptions\FetchRolAtualException;
use App\Exceptions\MembroNotFoundException;
use App\Exceptions\MissingSessionDistritoException;
use App\Exceptions\MissingSessionIgrejaLocalException;
use App\Exceptions\VisitanteNotFoundException;
use App\Models\CongregacoesCongregacao;
use App\Models\InstituicoesInstituicao;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use App\Models\MembresiaSituacao;
use App\Models\PessoasPessoa;

trait Identifiable
{
    public static function fetchPastores()
    {
        return PessoasPessoa::with('nomeacoes')
            ->whereHas('nomeacoes', fn ($query) => $query->where('instituicao_id', self::fetchSessionIgrejaLocal()->id)->whereNull('data_termino'))
            ->get();
    }

    public static function fetchPessoa($id, $vinculo, $trashed = false)
    {
        $membro = MembresiaMembro::where('id', $id)
            ->when($trashed, fn($query) => $query->onlyTrashed())
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

    public static function fetchCongregacoes($unlessCongregacaoId = null)
    {
        $igrejaId = optional(session()->get('session_perfil')->instituicoes->igrejaLocal)->id;

        return CongregacoesCongregacao::when((bool) $igrejaId, function ($query) use ($igrejaId) {
            $query->where('instituicao_id', $igrejaId);
        })
        ->when((bool) $unlessCongregacaoId, function ($query) use ($unlessCongregacaoId) {
            $query->where('id', '<>', $unlessCongregacaoId);
        })
        ->get();
    }

    public static function fetchSessionInstituicoesStoreMembresia(): array
    {
        /** @var SessionInstituicoesDto $sessionInstituicoes */
        $sessionInstituicoes = session('session_perfil')->instituicoes;

        if(! ($sessionInstituicoes->igrejaLocal) ) 
            throw new MissingSessionIgrejaLocalException();

        return [
            'regiao_id'   => $sessionInstituicoes->regiao->id,
            'distrito_id' => $sessionInstituicoes->distrito->id,
            'igreja_id'   => $sessionInstituicoes->igrejaLocal->id
        ];
    }

    public static function fetchSessionIgrejaLocal(): InstituicoesInstituicao
    {
        $igrejaLocal = session('session_perfil')->instituicoes->igrejaLocal;

        if (!$igrejaLocal) throw new MissingSessionIgrejaLocalException();

        return $igrejaLocal;
    }

    public static function fetchtSessionDistrito(): InstituicoesInstituicao
    {
        $distrito = session('session_perfil')->instituicoes->distrito;

        if (!$distrito) throw new MissingSessionDistritoException();

        return $distrito;
    }

    public static function fetchRolAtual($membroId, $numeroRol)
    {
        return MembresiaRolPermanente::where('membro_id', $membroId)
            ->where('numero_rol', $numeroRol)
            ->orderByDesc('id')
            ->firstOr(fn() => throw new FetchRolAtualException());
    }

    public static function fetchSugestaoRol()
    {
        return MembresiaRolPermanente::selectRaw('IFNULL(MAX(numero_rol), 0) + 1 sugestao_rol')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->first()->sugestao_rol;
    }
}
