<?php

namespace App\Http\Controllers;

use App\Services\ServicesUsuarios\ListUsuariosService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request) {
        $data = app(ListUsuariosService::class)->execute($request->all());
        return view('usuarios.index', $data);
    }
  
}
