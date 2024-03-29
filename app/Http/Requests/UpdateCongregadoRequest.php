<?php

namespace App\Http\Requests;

use App\Rules\RangeDateRule;
use App\Rules\ValidaCPF;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCongregadoRequest extends FormRequest
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
            'foto' => 'image|nullable|max:1999',
            'nome' => 'required',
            'sexo' => 'required',
            'data_nascimento' => ['required', new RangeDateRule],
            'data_conversao' => [new RangeDateRule],
            'data_batismo' => [new RangeDateRule],
            'data_batismo_espirito' => [new RangeDateRule],
            'estado_civil' => 'required',
            'nacionalidade' => 'required',
            'naturalidade' => 'required',
            'uf' => 'required',
            'cpf' => ['required', new ValidaCPF],
            'email_preferencial' => 'email|nullable',
            'email_alternativo' => 'email|nullable',
            'telefone_preferencial' => ['nullable', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/'],
            'telefone_alternativo' => ['nullable', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/'],
            'telefone_whatsapp' => ['nullable', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/'],
            'data_casamento' => [new RangeDateRule],
        ];
    }
}
