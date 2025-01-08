<?php

namespace App\Http\Requests;

use App\Rules\PrebendaExistis;
use App\Rules\TakeMaxPrebendaForAnoAndFuncaoMinisterial;
use App\Rules\TodaysDeadlineRule;
use App\Rules\UniqueRolIgrejaRule;
use App\Rules\ValidDataGreaterThanCreationClerigo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class StorePrebendaRequest extends FormRequest
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
        $ano = $this->input('ano');
        $valor = $this->input('valor');
        return [
            'ano' => ['required', new PrebendaExistis($ano)],
            'valor' => ['required', new TakeMaxPrebendaForAnoAndFuncaoMinisterial($ano, $valor) ],

        ];
    }
}
