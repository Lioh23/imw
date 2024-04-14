<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinanceiroTransferenciaRequest extends FormRequest
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
            'caixa_origem_id' => 'required',
            'caixa_destino_id' => 'required',
            'plano_conta_id' => 'required',
            'valor'          => 'required',
            'data_movimento' => 'required',
            'descricao'      => 'required',
        ];
    }
}
