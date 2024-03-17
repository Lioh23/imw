<?php

namespace App\Http\Requests;

use App\Rules\DisciplinarTerminoRule;
use App\Rules\RangeDateRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDisciplinarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'dt_termino' => ['required', 'date', new RangeDateRule, new DisciplinarTerminoRule]
        ];
    }
}
