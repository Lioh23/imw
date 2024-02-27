<?php 

namespace App\Services\ServiceMembros;

use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Illuminate\Support\Facades\Auth;

class IdentificaDadosTransferenciaPorExclusaoService
{
    use Identifiable;

    public function execute($id)
    {
        return [
            'pessoa'   => $this->fetchPessoa($id, MembresiaMembro::VINCULO_MEMBRO),
            'pastores' => Identifiable::fetchPastores(),
            'igrejas'  => $this->fetchIgrejas()
        ];
    }

    private function fetchIgrejas() 
    {
        return InstituicoesInstituicao::where('tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_LOCAL)
            ->where('id', '<>', Auth::user()->igrejasLocais->first()->id)
            ->get();
    }
}