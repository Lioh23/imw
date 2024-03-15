<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePerfilRequest;
use App\Services\ServicePerfil\ListPerfilService;
use App\Services\ServicePerfil\UpdatePerfilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function index(Request $request) {
        $usuario = app(ListPerfilService::class)->execute();
        return view('perfil.index', compact('usuario'));
    }

    public function update(UpdatePerfilRequest $request, $id) {
        app(UpdatePerfilService::class)->execute($request, $id);
        return redirect()->route('perfil.index')->with('success', 'Perfil atualizado!');
    }
}
