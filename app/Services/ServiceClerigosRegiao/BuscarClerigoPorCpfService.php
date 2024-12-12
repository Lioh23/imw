<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Exceptions\PessoaNotFoundException;
use App\Models\PessoasPessoa;

class BuscarClerigoPorCpfService
{
    public function execute(string $cpf): PessoasPessoa|null
    {
        return PessoasPessoa::where('cpf', $cpf)
            ->firstOr(fn () => throw new PessoaNotFoundException('Nenhuma pessoa encontrada com o CPF informado'));
    }
}
