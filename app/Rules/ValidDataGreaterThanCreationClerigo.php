<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\PessoasPessoa; // Ou o nome correto do seu model


class ValidDataGreaterThanCreationClerigo implements Rule
{
    protected $clergId;

    // Passa o id do clérigo ao criar a regra
    public function __construct($clergId)
    {
        $this->clergId = $clergId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Encontre o clérigo pelo ID
        $clerg = PessoasPessoa::find($this->clergId);

        // Se o clérigo não existir ou a data de nomeação for anterior à data de criação
        if (!$clerg || strtotime($value) < strtotime($clerg->created_at)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A data de nomeação não pode ser anterior à data de criação do clérigo.';
    }
}
