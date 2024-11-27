<?php
namespace App\Rules;

use App\Models\PessoaNomeacao;
use Illuminate\Contracts\Validation\Rule;
use App\Models\PessoasPessoa;


class ValidDataGreaterThanNomeacaoClerigo implements Rule
{
    protected $clergId;


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
        $clerg = PessoaNomeacao::withTrashed()->find($this->clergId);
        if (!$clerg || strtotime($value) < strtotime($clerg->data_nomeacao)) {
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
        return 'A data de finalizacão não pode ser anterior à data de nomeação do clérigo.';
    }
}
