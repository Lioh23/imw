<?php

namespace App\Http\Requests;

use App\Rules\RangeDateRule;
use App\Rules\VisitanteExistenteRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVisitanteRequest extends FormRequest
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
            'nome' => ['required', new VisitanteExistenteRule($this->input('data_nascimento'))],
            'sexo' => 'required',
            'data_nascimento' => 'nullable|date',
            'data_conversao' => [new RangeDateRule],
            'email_preferencial' => 'email|nullable',
            'email_alternativo' => 'email|nullable'
        ];
    }
}
