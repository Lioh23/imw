<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\PessoasPessoa;


class ValidDataGreaterThanCreationClerigo implements Rule
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

        $clerg = PessoasPessoa::find($this->clergId);
       
        if (strtotime(date('Y-m-d', strtotime($value))) >= strtotime(date('Y-m-d', strtotime($clerg->created_at)))) {
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
