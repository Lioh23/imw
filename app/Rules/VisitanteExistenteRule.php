<?php

namespace App\Rules;

use App\Models\MembresiaMembro;
use Illuminate\Contracts\Validation\Rule;

class VisitanteExistenteRule implements Rule
{    
    public function __construct(private $dataNascimento) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (bool) !MembresiaMembro::where('nome', $value)->where('data_nascimento', $this->dataNascimento)->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cadastro já existente!';
    }
}
