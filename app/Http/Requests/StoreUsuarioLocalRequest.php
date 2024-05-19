<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioLocalRequest extends FormRequest
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
            'name' => 'required|string|min:4',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'perfil_id' => 'required',
        ];

        return [
            'name.required' => 'O campo Nome completo é obrigatório.',
            'name.min' => 'O campo Nome completo deve ter no mínimo :min caracteres.',

            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de e-mail válido.',

            'password.required' => 'O campo Senha é obrigatório.',
            'password.min' => 'O campo Senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',

            'perfil_id.required' => 'O campo Perfil é obrigatório.',
        ];
    }
}
