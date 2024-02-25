<?php

namespace App\Rules;

use App\Models\MembresiaRolPermanente;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UniqueRolIgrejaRule implements Rule
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
        $hasRolPermanente = (booL) MembresiaRolPermanente::where('igreja_id', Auth::user()->igrejasLocais->first()->id)
            ->where('numero_rol', $value)
            ->first();
        
        return !$hasRolPermanente;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nº de Rol já existente';
    }
}
