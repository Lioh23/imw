<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidaCPF;
use App\Models\User;

class UpdateUsuarioLocalRequest extends FormRequest
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

        $userId = $this->route('id');
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'perfil_id' => 'required',
            'cpf' => [
                'required',
                function ($attribute, $value, $fail) {
                    $cpfSemMascara = $this->removeMascaraCPF($value); // Use $this para chamar métodos dentro da classe
                    if (User::where('cpf', $cpfSemMascara)->exists()) {
                        $fail('O CPF já está sendo utilizado por outra pessoa.');
                    }
                },
                new ValidaCPF,
            ],
            'telefone' => [
                'required',
                function ($attribute, $value, $fail) {
                    $telefoneSemMascara = $this->removeMascaraTelefone($value); // Use $this para chamar métodos dentro da classe
                    if (User::where('telefone', $telefoneSemMascara)->exists()) {
                        $fail('O telefone já está sendo utilizado por outra pessoa.');
                    }
                },
                'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/',
                'min:10',
            ],
        ];
    }

    public function messages()
    {
        return [
            'perfil_id.required' => 'O campo perfil é obrigatório.',
        ];
    }

    function removeMascaraCPF($cpf)
    {
        return preg_replace('/\D/', '', $cpf);
    }

    function removeMascaraTelefone($telefone)
    {
        return preg_replace('/\D/', '', $telefone);
    }
}
