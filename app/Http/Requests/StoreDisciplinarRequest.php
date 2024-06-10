<?php

namespace App\Http\Requests;

use App\Rules\DatePreviousToRecebimentoRule;
use App\Rules\RangeDateRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDisciplinarRequest extends FormRequest
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
        $membroId = $this->route('membro_id');

        return [
            'dt_inicio' => [new RangeDateRule, new DatePreviousToRecebimentoRule($membroId)],
            'modo_exclusao_id'=> 'required',
            'clerigo_id' => 'required',
        ];
    }
}
