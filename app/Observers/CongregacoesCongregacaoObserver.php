<?php

namespace App\Observers;

use App\Models\CongregacoesCongregacao;
use App\Traits\Identifiable;

class CongregacoesCongregacaoObserver
{
    use Identifiable;

    public function creating(CongregacoesCongregacao $congregacoesCongregacao)
    {
        $congregacoesCongregacao->instituicao_id = Identifiable::fetchSessionIgrejaLocal()->id;
        $congregacoesCongregacao->ativo = 1;
        $congregacoesCongregacao->cep = clearFormatNumber($congregacoesCongregacao->cep);
        $congregacoesCongregacao->telefone = clearFormatNumber($congregacoesCongregacao->telefone);
    }

    public function created(CongregacoesCongregacao $congregacoesCongregacao)
    {
        //
    }

    public function updated(CongregacoesCongregacao $congregacoesCongregacao)
    {
        //
    }

    public function deleted(CongregacoesCongregacao $congregacoesCongregacao)
    {
        //
    }

    public function restored(CongregacoesCongregacao $congregacoesCongregacao)
    {
        //
    }

    public function forceDeleted(CongregacoesCongregacao $congregacoesCongregacao)
    {
        //
    }
}
