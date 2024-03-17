<?php

namespace App\Rules;

use App\Exceptions\DisciplinaNotFoundException;
use App\Models\MembresiaDisciplina;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DisciplinarTerminoRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $disciplina = MembresiaDisciplina::findOr(request()->route('id'), fn() => throw new DisciplinaNotFoundException());
        $dtTermino  = Carbon::parse($value);

        return $disciplina->dt_inicio->lt($dtTermino);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A data de término da disciplina precisa ser maior que a data de início da disciplina.';
    }
}
