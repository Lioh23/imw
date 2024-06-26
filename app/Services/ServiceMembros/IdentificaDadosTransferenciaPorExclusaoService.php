<?php

namespace App\Services\ServiceMembros;

use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Models\MembresiaMembro;
use App\Traits\Identifiable;

class IdentificaDadosTransferenciaPorExclusaoService
{
    use Identifiable;

    public function execute($id)
    {
        return [
            'pessoa'   => $this->fetchPessoa($id, MembresiaMembro::VINCULO_MEMBRO),
            'igrejas'  => $this->fetchIgrejas()
        ];
    }

    private function fetchIgrejas()
    {
        return InstituicoesInstituicao::where('tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_LOCAL)
        ->where('id', '<>', Identifiable::fetchSessionIgrejaLocal()->id)
        ->where('ativo', 1)
        ->orderBy('nome', 'asc')
        ->get();
    
    }
}
