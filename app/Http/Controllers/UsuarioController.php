<?php

namespace App\Http\Controllers;

use App\Exceptions\MembroNotFoundException;
use App\Http\Requests\StoreUsuarioRequest;
use App\Services\ServicesUsuarios\ListUsuariosService;
use App\Services\ServicesUsuarios\NovoUsuarioService;
use App\Services\ServicesUsuarios\SalvarUsuarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $perfis = app(NovoUsuarioService::class)->execute();
            return view('usuarios.novo', compact('perfis'));
        } catch (MembroNotFoundException $e) {
            return redirect()->route('usuarios.index')->with('error', 'Registro não encontrado.');
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
        }
    }

    public function store(StoreUsuarioRequest $request)
    {
       try {        
            DB::beginTransaction();
            app(SalvarUsuarioService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('usuarios.novo')->with('success', 'Usuário cadastrado com sucesso.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('usuarios.novo')->with('error', $e);
       }
    }
}
