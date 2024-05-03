<?php

namespace App\Http\Requests;

use App\Rules\RangeDateRule;
use App\Rules\VisitanteExistenteRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitanteRequest extends FormRequest
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
            'nome' => 'required',
            'sexo' => 'required',
            'data_nascimento' => 'nullable|date',
            'data_conversao' => [new RangeDateRule],
            'email_preferencial' => ['nullable', 'email', function ($attribute, $value, $fail) {
                if ($value) {
                    if (!preg_match('/@.*\.\w{2,}$/', $value)) {
                        $fail('O campo e-mail deve conter um sufixo de domínio válido com pelo menos dois caracteres após o ponto.');
                    }
                }
            }],
            
            'email_alternativo' => 'email|nullable'
        ];
    }
}
