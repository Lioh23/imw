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
            'descricao'      => 'nullable|string',
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

            $instituicaoId = session()->get('session_perfil')->instituicao_id;

            // Obter a última data consolidada para a instituição
            $ultimaDataConsolidada = DB::table('financeiro_saldo_consolidado_mensal')
                ->where('instituicao_id', $instituicaoId)
                ->orderBy('ano', 'desc')
                ->orderBy('mes', 'desc')
                ->first(['mes', 'ano']);

            if ($ultimaDataConsolidada) {
                $ultimoMesConsolidado = Carbon::create($ultimaDataConsolidada->ano, $ultimaDataConsolidada->mes, 1);

                if ($data->lessThanOrEqualTo($ultimoMesConsolidado)) {
                    $validator->errors()->add('data_movimento', 'A data de movimento deve ser superior ao último mês consolidado.');
                }
            }
        });
    }
}
