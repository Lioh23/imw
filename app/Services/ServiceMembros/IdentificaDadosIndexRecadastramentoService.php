<?php 

namespace App\Services\ServiceMembros;

use App\Models\MembresiaMembroRecadastramento;
use App\Traits\Identifiable;
use App\Traits\MemberCountableRecadastramento;

class IdentificaDadosIndexRecadastramentoService
{
    use MemberCountableRecadastramento, Identifiable;

    public function execute()
    {
        return [
            'countAtual'      => MemberCountableRecadastramento::countRolAtual(MembresiaMembroRecadastramento::VINCULO_MEMBRO),
            'countPermanente' => MemberCountableRecadastramento::countRolPermanente(MembresiaMembroRecadastramento::VINCULO_MEMBRO),
            'countHasErrors'  => MemberCountableRecadastramento::countHasErrors(MembresiaMembroRecadastramento::VINCULO_MEMBRO)
        ];
    }
}