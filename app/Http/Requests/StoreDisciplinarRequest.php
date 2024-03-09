<?php

namespace App\Http\Requests;

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
        return [
            'dt_inicio' => [new RangeDateRule],
            'modo_exclusao_id'=> 'required',
            'clerigo_id' => 'required',
        ];
    }
}
