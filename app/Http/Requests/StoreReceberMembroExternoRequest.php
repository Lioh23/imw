<?php

namespace App\Http\Requests;

use App\Rules\UniqueRolIgrejaRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReceberMembroExternoRequest extends FormRequest
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
            'clerigo_id'  => 'required|exists:pessoas_pessoas,.id',
            'dt_resposta' => 'required|date',
            'congregacao' => 'nullable|exists:congregacoes_congregacoes,id',
            'action'      => 'required',
            'numero_rol'  => ['required', new UniqueRolIgrejaRule],
        ];
    }
}
