<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFornecedorRequest extends FormRequest
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
            'cpf_cnpj' => 'required',
            'nome' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'site' => 'nullable|max:100',
            'cep' => 'required|numeric',
            'endereco' => 'nullable|max:255',
            'numero' => 'nullable|max:20',
            'complemento' => 'nullable|max:255',
            'bairro' => 'nullable|max:255',
            'cidade' => 'nullable|max:255',
            'uf' => 'nullable|in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO',
            'pais' => 'required|max:20',
            'telefone' => 'nullable|max:20',
            'celular' => 'required|max:20',
        ];
    }
}
