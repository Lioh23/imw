<?php

namespace App\Http\Requests;

use App\Rules\RangeDateRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCongregadoRequest extends FormRequest
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
            'nome' => 'required',
            'sexo' => 'required',
            'data_nascimento' => ['required', new RangeDateRule],
            'estado_civil',
            'nacionalidade',
            'naturalidade',
            'uf',
            'cpf',
            'data_conversao',
        ];
    }
}
