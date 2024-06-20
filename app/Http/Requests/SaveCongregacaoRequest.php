<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCongregacaoRequest extends FormRequest
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
            'nome'           => 'required|max:100',
            'data_abertura'  => 'required|date',
            'host_dirigente' => 'required|max:100',
            'cep'            => 'required|max:10',
            'endereco'       => 'required|max:100',
            'numero'         => 'required|max:20',
            'complemento'    => 'nullable|max:30',
            'bairro'         => 'required|max:100',
            'cidade'         => 'required|max:100',
            'uf'             => 'required|max:2',
            'ddd'            => 'nullable|max:2',
            'telefone'       => 'nullable|max:15',
            'email'          => 'nullable|email|max:255',
            'site'           => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nome.required'           => 'O nome é obrigatório', 
            'nome.max'                => 'O nome deve conter no máximo 100 caracteres',
            'data_abertura.required'  => 'A data de abertura é obrigatória',
            'data_abertura.date'      => 'A data de abertura deve ser uma data válida', 
            'host_dirigente.required' => 'O nome do dirigente é obrigatório',
            'host_dirigente.max'      => 'O nome do dirigente deve conter no máximo 100 caracteres',
            'cep.required'            => 'O CEP é obrigatório',
            'cep.max'                 => 'O CEP deve conter no máximo 10 caracteres',
            'endereco.required'       => 'O endereço é obrigatório',
            'endereco.max'            => 'O endereço deve conter no máximo 100 caracteres',
            'numero.required'         => 'O número é obrigatório',
            'numero.max'              => 'O número deve conter no máximo 20 caracteres',
            'complemento.max'         => 'O complemento deve conter no máximo 30 caracteres',
            'bairro.required'         => 'O bairro é obrigatório',
            'bairro.max'              => 'O bairro deve conter no máximo 100 caracteres',
            'cidade.required'         => 'A cidade é obrigatória',
            'cidade.max'              => 'A cidade deve conter no máximo 100 caracteres',
            'uf.required'             => 'O estado é obrigatório',
            'uf.max'                  => 'O estado deve conter no máximo 2 caracteres',
            'ddd.max'                 => 'O DDD deve conter no máximo 2 caracteres',
            'telefone.max'            => 'O telefone deve conter no máximo 15 caracteres',
            'email.email'             => 'O E-Mail está em um formato inválido',
            'site.max'                => 'O site deve conter no máximo 255 caracteres'
        ];
    }
}
