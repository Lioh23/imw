<?php

namespace App\Http\Requests;

use App\Rules\RangeDateRule;
use App\Rules\ValidaCPF;
use Illuminate\Validation\Rule;
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
        $membroId = $this->input('membro_id');

        return [
            'foto' => 'image|nullable|max:1999',
            'nome' => 'required',
            'sexo' => 'required',
            'data_nascimento' => 'required|date',
            'data_conversao' => [new RangeDateRule],
            'data_batismo' => [new RangeDateRule],
            'data_batismo_espirito' => [new RangeDateRule],
            'estado_civil' => 'required',
            'nacionalidade' => 'required',
            'naturalidade' => 'required',
            'uf' => 'required',
            'cpf' => [
                'nullable',
                Rule::unique('membresia_membros', 'cpf')->ignore($membroId),
                new ValidaCPF,
            ],
            'email_preferencial' => ['nullable', 'email', function ($attribute, $value, $fail) {
                if ($value) {
                    if (!preg_match('/@.*\.\w{2,}$/', $value)) {
                        $fail('O campo e-mail deve conter um sufixo de domínio válido com pelo menos dois caracteres após o ponto.');
                    }
                }
            }],
            'email_alternativo' => 'email|nullable',
            'telefone_preferencial' => ['nullable', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', 'min:10'],
            'telefone_alternativo' => ['nullable', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', 'min:10'],
            'telefone_whatsapp' => ['nullable', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', 'min:10'],
            'data_casamento' => [new RangeDateRule],
            'congregacao_id' => 'nullable|exists:congregacoes_congregacoes,id'
        ];
    }

    public function messages()
    {
        return [
            'cpf.unique' => 'Este CPF já está sendo utilizado por outra pessoa'
        ];
    }
}
