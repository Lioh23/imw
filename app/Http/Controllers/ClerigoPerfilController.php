<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClerigoPerfilController extends Controller
{
    public function indexDependentes(Request $request)
    {
        return view('perfil.clerigos.dependentes.index', [
            'dependentes' => $request->user()->pessoa->dependentes
        ]);
    }
}
