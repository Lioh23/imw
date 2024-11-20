<?php

namespace App\Http\Requests;

use App\Rules\TodaysDeadlineRule;
use App\Rules\UniqueRolIgrejaRule;
use App\Rules\ValidDataGreaterThanCreationClerigo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class StoreNomeacoesClerigosRequest extends FormRequest
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
            'data_nomeacao' => 'required',
            new TodaysDeadlineRule,
            new ValidDataGreaterThanCreationClerigo($clergId),
            'instituicao_id' => 'required',
            'pessoa_id' => 'required',
            'funcao_ministerial_id' => 'required'

        ];
    }
}
