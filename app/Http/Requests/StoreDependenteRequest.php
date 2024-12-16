<?php

namespace App\Http\Requests;

use App\Rules\TodaysDeadlineRule;
use App\Rules\ValidaCPF;
use Illuminate\Foundation\Http\FormRequest;

class StoreDependenteRequest extends FormRequest
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
        'nome'             => 'required',
        'cpf'              => ['required', new ValidaCPF],
        'data_nascimento'  => ['required', new TodaysDeadlineRule],
        'parentesco'       => 'required',
        'sexo'             => 'required',
        'declarar_em_irpf' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nome.required'             => 'O campo é requerido',
            'cpf.required'              => 'O campo é requerido',
            'data_nascimento.required'  => 'O campo é requerido',
            'parentesco.required'       => 'O campo é requerido',
            'sexo.required'             => 'O campo é requerido',
            'declarar_em_irpf.required' => 'O campo é requerido',
        ];
    }
}
