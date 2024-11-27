<?php

namespace App\Http\Requests;

use App\Rules\TodaysDeadlineRule;
use App\Rules\ValidDataGreaterThanNomeacaoClerigo;
use Illuminate\Foundation\Http\FormRequest;

class FinalizarNomeacoesRequest extends FormRequest
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
        $clergId = $this->route('id');
        return [
            'data_termino' =>
            ['required', new TodaysDeadlineRule, new ValidDataGreaterThanNomeacaoClerigo($clergId)]

        ];
    }

    public function messages()
    {
        return [
            'modo_exclusao_id.required' => 'Você precisa preencher esta informação.',

        ];
    }
}
