<?php

namespace App\Http\Requests;

use App\Rules\RangeDateRule;
use App\Rules\VisitanteExistenteRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVisitanteRequest extends FormRequest
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
            'nome' => ['required', new VisitanteExistenteRule($this->input('data_nascimento'))],
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
            
            'email_alternativo' => 'email|nullable',
            'telefone_preferencial' => 'nullable|string|min:10',
            'telefone_alternativo' => 'nullable|string|min:10',
            'telefone_whatsapp' => 'nullable|string|min:10',
            'congregacao_id' => 'nullable|exists:congregacoes_congregacoes,id'
        ];
    }
}
