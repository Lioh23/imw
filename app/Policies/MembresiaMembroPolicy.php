<?php

namespace App\Policies;

use App\Exceptions\MembroNotFoundException;
use App\Exceptions\UnauthorizedRouteException;
use App\Models\MembresiaMembro;
use App\Models\User;
use App\Traits\Identifiable;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembresiaMembroPolicy
{
    use HandlesAuthorization, Identifiable;
    public function checkSameChurch(User $user, $membroId)
    {
        $pessoa = MembresiaMembro::findOr($membroId, fn() => throw new MembroNotFoundException());

        if (Identifiable::fetchSessionIgrejaLocal()->id === $pessoa->igreja_id) return true;

        throw new UnauthorizedRouteException();
    }
}
