<?php

namespace App\Http\Controllers;

use App\Models\MembresiaMembro;
use Illuminate\Http\Request;

class MembresiaGeralController extends Controller
{
    public function visualizarHtml($id)
    {
        // Inclui registros que foram soft deleted
        $membro = MembresiaMembro::withTrashed()->findOrFail($id);

        return view('membresiaGeral.visualizar', ['membro' => $membro]);
    }
}
