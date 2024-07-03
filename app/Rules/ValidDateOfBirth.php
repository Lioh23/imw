<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDateOfBirth implements Rule
{
    private $conversionDate;

    /**
     *
     * @return void
     */
    public function __construct($conversionDate)
    {
        $this->conversionDate = $conversionDate;
    }

    /**
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return strtotime($value) < strtotime($this->conversionDate);
    }

    /**
     *
     * @return string
     */
    public function message()
    {
        return 'A data de conversão deve ser posterior à data de nascimento.';
    }
}