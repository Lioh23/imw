<?php

namespace App\Rules;

use App\Models\PessoaFuncaoministerial;
use App\Models\PessoaNomeacao;
use App\Traits\Identifiable;
use Illuminate\Contracts\Validation\Rule;
use App\Models\PessoasPessoa;
use App\Models\Prebenda;

class TakeMaxPrebendaForAnoAndFuncaoMinisterial implements Rule
{
    protected $ano;
    protected $valor;
    protected $valorMaxPrebenda;


    public function __construct($ano, $valor)
    {
        $this->ano = $ano;
        $this->valor = $this->parseFloat($valor);
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

        $pessoa_nomeacoes = PessoaNomeacao::where('pessoa_id', Identifiable::fetchSessionPessoa()->id)->get();

        $maiorOrdem = '';
        foreach ($pessoa_nomeacoes as $nomeacoes_id) {
            $nomeacao = PessoaFuncaoministerial::where('id', $nomeacoes_id->funcao_ministerial_id)->first();
            if ($nomeacao && ($maiorOrdem == null || $nomeacao->ordem > $maiorOrdem)) {
                $maiorOrdem = $nomeacao->ordem;
            }
        }

        if (!$this->ano) {
            return false;
        }
        $prebenda = Prebenda::where('ano', $this->ano)->first();

        $this->valorMaxPrebenda = (float) $prebenda->valor * (float) $maiorOrdem;
        if ($this->valor <= $this->valorMaxPrebenda) {
            return true;
        }
    }

    private function parseFloat($value)
    {
        if (is_string($value) && strpos($value, 'R$ ') === 0) {
            $value = substr($value, 3);
        }
        $normalizedValue = str_replace('.', '', $value);
        $normalizedValue = str_replace(',', '.', $normalizedValue);
        return (float) $normalizedValue;
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O valor da prebenda não pode ultrapassar o valor máximo de R$ ' . $this->valorMaxPrebenda;
    }
}
