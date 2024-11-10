<?php

namespace App\Http\Requests;

use App\Rules\RangeDateRule;
use App\Rules\UniqueCPFInIgrejaRule;
use App\Rules\UniqueRolIgrejaRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReceberNovoClerigoRequest extends FormRequest
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
            'nome' => 'required|string|max:255',
            'identidade' => 'required|string|max:20',
            'orgao_emissor' => 'required|string|max:50',
            'data_emissao' => 'required|date',
            'cpf' => 'required|string', // Supondo que você tenha uma regra de validação para CPF
            'endereco' => 'required|string|max:255',
            'numero' => 'required|integer',
            'complemento' => 'nullable|string|max:50',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'uf' => 'required|string|max:2',
            'pais' => 'required|string|max:100',
            'cep' => 'required|string|size:8', // Se o CEP for de 8 caracteres
            'email' => 'required|email|max:255',
            'estado_civil' => 'required|string|max:20',
            'regiao_id' => 'required|integer', // Supondo que você tenha uma tabela de regiões
            'sexo' => 'required|string|in:M,F', // M ou F
            'nome_mae' => 'nullable|string|max:255',
            'nome_pai' => 'nullable|string|max:255',
            'telefone_preferencial' => 'required|string|max:15',
            'ctps' => 'required|string|max:20',
            'ctps_emissao' => 'required|date',
            'habilitacao' => 'required|string|max:20',
            'habilitacao_categoria' => 'required|string|max:5',
            'habilitacao_emissor' => 'required|string|max:50',
            'habilitacao_uf' => 'required|string|max:2',
            'identidade_uf' => 'required|string|max:2',
            'pispasep' => 'required|string|max:20',
            'pispasep_emissao' => 'required|date',
            'residencia_propria' => 'required|boolean',
            'residencia_propria_fgts' => 'nullable|boolean',
            'titulo_eleitor' => 'required|string|max:20',
            'titulo_eleitor_secao' => 'required|string|max:10',
            'titulo_eleitor_zona' => 'required|string|max:10',
            'formacao_id' => 'required|integer',
            'categoria' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'tipo.required' => 'O campo tipo é obrigatório.',
            'nome.required' => 'O campo nome é obrigatório.',
            'identidade.required' => 'O campo identidade é obrigatório.',
            'orgao_emissor.required' => 'O campo órgão emissor é obrigatório.',
            'data_emissao.required' => 'O campo data de emissão é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'endereco.required' => 'O campo endereço é obrigatório.',
            'numero.required' => 'O campo número é obrigatório.',
            'bairro.required' => 'O campo bairro é obrigatório.',
            'cidade.required' => 'O campo cidade é obrigatório.',
            'uf.required' => 'O campo estado é obrigatório.',
            'pais.required' => 'O campo país é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'estado_civil.required' => 'O campo estado civil é obrigatório.',
            'regiao_id.required' => 'O campo região é obrigatório.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'escolaridade.required' => 'O campo escolaridade é obrigatório.',
            'telefone_preferencial.required' => 'O campo telefone preferencial é obrigatório.',
            'ctps.required' => 'O campo CTPS é obrigatório.',
            'ctps_emissao.required' => 'O campo data de emissão da CTPS é obrigatório.',
            'habilitacao.required' => 'O campo habilitação é obrigatório.',
            'habilitacao_categoria.required' => 'O campo categoria da habilitação é obrigatório.',
            'habilitacao_emissor.required' => 'O campo órgão emissor da habilitação é obrigatório.',
            'habilitacao_uf.required' => 'O campo estado da habilitação é obrigatório.',
            'identidade_uf.required' => 'O campo estado da identidade é obrigatório.',
            'pispasep.required' => 'O campo PIS/PASEP é obrigatório.',
            'pispasep_emissao.required' => 'O campo data de emissão do PIS/PASEP é obrigatório.',
            'titulo_eleitor.required' => 'O campo título de eleitor é obrigatório.',
            'titulo_eleitor_secao.required' => 'O campo seção do título de eleitor é obrigatório.',
            'titulo_eleitor_zona.required' => 'O campo zona do título de eleitor é obrigatório.',
            'formacao_id.required' => 'O campo formação é obrigatório.',
        ];
    }

}
