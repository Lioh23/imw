<?php

namespace App\Traits;

use App\Exceptions\CongregadoNotFoundException;
use App\Exceptions\FetchRolAtualException;
use App\Exceptions\MembroNotFoundException;
use App\Exceptions\MissingSessionDistritoException;
use App\Exceptions\MissingSessionIgrejaLocalException;
use App\Exceptions\MissingSessionRegiaoException;
use App\Exceptions\VisitanteNotFoundException;
use App\Models\CongregacoesCongregacao;
use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use App\Models\MembresiaSituacao;
use App\Models\PessoasPessoa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            ->select('imwpgahml.membresia_membros.*', DB::raw("(SELECT CASE WHEN telefone_preferencial IS NOT NULL AND telefone_preferencial <> '' THEN telefone_preferencial
                              WHEN telefone_alternativo IS NOT NULL AND telefone_alternativo <> '' THEN telefone_alternativo
                              ELSE telefone_whatsapp END contato FROM membresia_contatos WHERE membro_id = '$id') AS telefone") )
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

    public static function fetchtSessionRegiao(): InstituicoesInstituicao
    {
        $distrito = session('session_perfil')->instituicoes->regiao;

        if (!$distrito) throw new MissingSessionRegiaoException();

        return $distrito;
    }

    public static function fetchSessionPessoa(): PessoasPessoa
    {
        return Auth::user()->pessoa;
    }

    public static function fetchRolAtual($membroId, $numeroRol)
    {
        return MembresiaRolPermanente::where('membro_id', $membroId)
            ->where('numero_rol', $numeroRol)
            ->orderByDesc('id')
            ->firstOr(fn() => throw new FetchRolAtualException());
    }

    public static function fetchSugestaoRol($membroId = null)
    {
        if ($membroId) {
            $rolExistente = MembresiaRolPermanente::where('membro_id', $membroId)
                ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
                ->whereNotNull('numero_rol')
                ->first();

            if ($rolExistente) {
                return $rolExistente->numero_rol;
            }
        }

        return MembresiaRolPermanente::selectRaw('IFNULL(MAX(numero_rol), 0) + 1 sugestao_rol')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->first()->sugestao_rol;
    }

    public static function fetchDistritosByRegiao(int $regiaoId): Collection
    {
        return InstituicoesInstituicao::where('instituicao_pai_id', $regiaoId)
            ->where('tipo_instituicao_id', InstituicoesTipoInstituicao::DISTRITO)
            ->get();
    }

    public static function fetchIgrejasByDistrito(int|null $distritoId)
    {
        return InstituicoesInstituicao::where('instituicao_pai_id', $distritoId)
            ->where('tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_LOCAL)
            ->get();
    }

    public static function fetchDistritosIdByRegiao(int $regiaoId): array
    {
        return static::fetchDistritosByRegiao($regiaoId)->pluck('id')->toArray();
    }

}
