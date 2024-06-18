<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class FinanceiroStoreEntradaRequest extends FormRequest
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
            'tipo_pagante_favorecido_id' => 'required'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $dataMovimento = $this->input('data_movimento');
            $data = Carbon::parse($dataMovimento);
            $mes = $data->month;
            $ano = $data->year;

            $consolidado = DB::table('financeiro_saldo_consolidado_mensal')
                ->where('mes', $mes)
                ->where('ano', $ano)
                ->count();

            if ($consolidado > 0) {
                $validator->errors()->add('data_movimento', 'Este mês já foi consolidado.');
            }
        });
    }
}
