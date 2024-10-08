<?php

namespace App\Http\Requests;

use App\Rules\TodaysDeadlineRule;
use Illuminate\Foundation\Http\FormRequest;

class FinanceiroUpdateEntradaRequest extends FormRequest
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
            'data_movimento' =>  ['required', new TodaysDeadlineRule],
            'descricao'      => 'nullable|string',
            'tipo_pagante_favorecido_id' => 'nullable|string'
        ];
    }
}
