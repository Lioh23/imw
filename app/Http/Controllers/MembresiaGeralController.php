<?php

namespace App\Http\Controllers;

use App\Models\MembresiaMembro;
use Illuminate\Http\Request;

class MembresiaGeralController extends Controller
{
    public function visualizarHtml(MembresiaMembro $membro)
    {
        return view('membresiaGeral.visualizar', ['membro' => $membro]);
    }
}
