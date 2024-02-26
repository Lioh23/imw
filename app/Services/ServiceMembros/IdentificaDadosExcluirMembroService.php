<?php 

namespace App\Services\ServiceMembros;

use App\Exceptions\IdentificaDadosExcluirMembroException;
use App\Models\CongregacoesCongregacao;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use App\Models\MembresiaSituacao;
use App\Models\PessoasPessoa;
use Illuminate\Support\Facades\Auth;

class IdentificaDadosExcluirMembroService
{
    public function execute($id)
    {
        return [
            'pessoa'       => $this->fetchPessoa($id),
            'sugestao_rol' => $this->fetchSugestaoRol(),
            'pastores'     => $this->fetchPastores(),
            'modos'        => $this->fetchModos(),
        ];
    }

    private function fetchPessoa($id)
    {
        $membro = MembresiaMembro::where('id', $id)
            ->where('vinculo', MembresiaMembro::VINCULO_MEMBRO)
            ->firstOr(fn() => throw new IdentificaDadosExcluirMembroException());

        if($membro->rolAtual->dt_exclusao) {
            throw new IdentificaDadosExcluirMembroException();
        }

        return $membro;
    }

    private function fetchSugestaoRol()
    {
        return MembresiaRolPermanente::selectRaw('IFNULL(MAX(numero_rol), 0) + 1 sugestao_rol')
            ->where('igreja_id', Auth::user()->igrejasLocais->first()->id)
            ->first()->sugestao_rol;
    }

    private function fetchPastores()
    {
        return PessoasPessoa::all();
    }

    private function fetchModos()
    {
        return MembresiaSituacao::where('tipo', MembresiaSituacao::TIPO_EXCLUSAO)->get();
    }
}