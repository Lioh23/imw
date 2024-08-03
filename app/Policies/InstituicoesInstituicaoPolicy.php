<?php

namespace App\Policies;

use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Models\User;
use App\Traits\Identifiable;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class InstituicoesInstituicaoPolicy
{
    use HandlesAuthorization, Identifiable;

    public function checkSameDistrict(User $user, InstituicoesInstituicao $igreja)
    {
        $distrito = InstituicoesInstituicao::find($igreja->instituicao_pai_id);

        return $distrito->id == Identifiable::fetchtSessionDistrito()->id
            ? Response::allow()
            : Response::deny('Você não tem permissão para editar esta igreja');
    }
}
