<?php

namespace App\Services\ServicesUsuarios;

use App\Models\InstituicoesInstituicao;
use App\Models\MembresiaCurso;
use App\Models\MembresiaFormacao;
use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaSetor;
use App\Models\MembresiaTipoAtuacao;
use App\Models\Perfil;
use App\Models\User;

class NovoUsuarioService
{

    public function execute()
    {
        $perfils = Perfil::orderBy('nome', 'asc')->get();
        return $perfils;
    }
}
