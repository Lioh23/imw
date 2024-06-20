<?php

namespace App\Policies;

use App\Exceptions\UnauthorizedRouteException;
use App\Models\CongregacoesCongregacao;
use App\Models\User;
use App\Traits\Identifiable;
use Illuminate\Auth\Access\HandlesAuthorization;

class CongregacoesCongregacaoPolicy
{
    use HandlesAuthorization, Identifiable;

    public function checkSameChurch(User $user, CongregacoesCongregacao $congregacao)
    {
        if (Identifiable::fetchSessionIgrejaLocal()->id === $congregacao->instituicao_id) return true;

        throw new UnauthorizedRouteException();
    }
}
