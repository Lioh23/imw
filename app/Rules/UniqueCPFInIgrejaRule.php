<?php

namespace App\Rules;

use App\Models\MembresiaMembro;
use App\Traits\Identifiable;
use Illuminate\Contracts\Validation\Rule;

class UniqueCPFInIgrejaRule implements Rule
{
    use Identifiable;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        if (!$value) return true;

        $count = MembresiaMembro::where('cpf' , $value)
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->where('status', MembresiaMembro::STATUS_ATIVO)
            ->withTrashed()
            ->count();

        return $count > 1 ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Já existe um membro com este CPF nesta Igreja.';
    }
}
