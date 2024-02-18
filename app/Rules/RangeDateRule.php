<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class RangeDateRule implements Rule
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
        if(!$value) return true;

        $date = Carbon::parse($value);

        return $date->greaterThanOrEqualTo('1900-01-01') && $date->lessThanOrEqualTo(Carbon::now()->format('Y-m-d'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A data deve estar entre 01/01/1900 e a data atual.';
    }
}
