<?php

namespace App\Http\Controllers;

use App\Models\InstituicoesInstituicao;
use App\Models\InstituicoesTipoInstituicao;
use App\Traits\Identifiable;
use Illuminate\Http\Request;

class HandleInstituicoesController extends Controller
{     
    public function igrejasByDistrito(int $distritoId)
    {
        return Identifiable::fetchIgrejasByDistrito($distritoId);
    }
}
