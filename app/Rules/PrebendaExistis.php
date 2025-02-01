<?php

namespace App\Rules;

use App\Models\PessoaFuncaoministerial;
use App\Models\PessoaNomeacao;
use App\Traits\Identifiable;
use Illuminate\Contracts\Validation\Rule;
use App\Models\PessoasPessoa;
use App\Models\PessoasPrebenda;
use App\Models\Prebenda;

class PrebendaExistis implements Rule
{
    protected $ano;

    public function __construct($ano)
    {
        $this->ano = $ano;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $prebenda = PessoasPrebenda::where('ano', $this->ano)->where('pessoa_id', Identifiable::fetchSessionPessoa()->id)->first();
        if (!$prebenda) {
            return true;
        }

        return false;
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Você já cadastrou a prebenda deste ano';
    }
}
