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
        // Subconsulta para obter IDs
        $subQuery = InstituicoesInstituicao::select('id')
            ->where('instituicao_pai_id', 23);

        // Consulta principal
        return InstituicoesInstituicao::whereIn('instituicao_pai_id', $subQuery)
            ->where('ativo', 1)
            ->where('tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_LOCAL)
            ->where('id', '<>', Identifiable::fetchSessionIgrejaLocal()->id)
            ->orderBy('nome', 'asc')
            ->get();
    }
}
