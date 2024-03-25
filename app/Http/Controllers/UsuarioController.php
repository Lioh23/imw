<?php

namespace App\Http\Controllers;

use App\Exceptions\MembroNotFoundException;
use App\Services\ServicesUsuarios\ListUsuariosService;
use App\Services\ServicesUsuarios\NovoUsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $data = app(ListUsuariosService::class)->execute($request->all());
        return view('usuarios.index', $data);
    }

    public function novo()
    {
        try {
            $perfils = app(NovoUsuarioService::class)->execute();
            return view('usuarios.novo', compact('perfils'));
        } catch (MembroNotFoundException $e) {
            return redirect()->route('usuarios.index')->with('error', 'Registro não encontrado.');
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
        }
    }
}
