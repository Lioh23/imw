<?php

namespace App\Http\Requests;

use App\Rules\TodaysDeadlineRule;
use App\Rules\UniqueRolIgrejaRule;
use App\Rules\ValidDataGreaterThanCreationClerigo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

class StoreNomeacoesClerigosInstiruicoesRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $clergId = $request->pessoa_id;
        return [
            'data_nomeacao' => ['required', new TodaysDeadlineRule, new ValidDataGreaterThanCreationClerigo($clergId)],
            'instituicao_id' => 'required',
            'pessoa_id' => 'required',
            'funcao_ministerial_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            "data_nomeacao.required" => "O campo Data de Nomeação é obrigatório.",
            "funcao_ministerial_id.required" => "O campo Função Ministerial é obrigatório.",
            "pessoa_id.required" => "O campo Clerigo é obrigatório.",
        ];
    }
}
