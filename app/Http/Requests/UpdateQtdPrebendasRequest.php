<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQtdPrebendasRequest extends FormRequest
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
            'qtd_prebendas' => 'required|min:1',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Você precisa informar a quantidade de prebendas.',
            'min'      => 'A quantidade de prebendas deve ser no mínimo 1.',
        ];
    }
}
