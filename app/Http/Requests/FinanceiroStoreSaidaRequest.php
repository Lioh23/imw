<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinanceiroStoreSaidaRequest extends FormRequest
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
            'plano_conta_id' => 'required',
            'caixa_id'       => 'required',
            'valor'          => 'required',
            'data_movimento' => 'required',
            'descricao'      => 'required',
            'tipo_pagante_favorecido_id' => 'required',
            'anexo1' => 'nullable|file|max:2048|mimes:pdf,doc,docx',
            'descricao_anexo1' => 'nullable|string|max:255',
            'anexo2' => 'nullable|file|max:2048|mimes:pdf,doc,docx',
            'descricao_anexo2' => 'nullable|string|max:255',
            'anexo3' => 'nullable|file|max:2048|mimes:pdf,doc,docx',
            'descricao_anexo3' => 'nullable|string|max:255',
        ];
    }
}
