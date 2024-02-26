<?php 

namespace App\Services\ServiceMembros;

use App\Exceptions\ReceberNovoMembroException;
use App\Models\CongregacoesCongregacao;
use App\Models\MembresiaMembro;
use App\Models\MembresiaRolPermanente;
use App\Models\MembresiaSituacao;
use App\Models\PessoasPessoa;
use Illuminate\Support\Facades\Auth;

class IdentificaDadosReintegrarMembroService
{
    public function execute($id)
    {
        return [
            'pessoa'       => $this->fetchPessoa($id),
            'sugestao_rol' => $this->fetchSugestaoRol(),
            'pastores'     => $this->fetchPastores(),
            'modos'        => $this->fetchModos(),
            'congregacoes' => $this->fetchCongregacoes()
        ];
    }

    private function fetchPessoa($id)
    {
        return MembresiaMembro::where('id', $id)
            ->where('vinculo', MembresiaMembro::VINCULO_CONGREGADO)
            ->firstOr(fn () => throw new ReceberNovoMembroException());
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
        return MembresiaSituacao::where('tipo', 'R')->get();
    }

    private function fetchCongregacoes()
    {
        return CongregacoesCongregacao::where('instituicao_id', Auth::user()->igrejasLocais->first()->id)->get();
    }
}