<?php

namespace App\Http\Controllers;

use App\Exceptions\MembroNotFoundException;
use App\Http\Requests\StoreUsuarioLocalRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\User;
use App\Services\ServicesUsuarios\DeletarUsuarioService;
use App\Services\ServicesUsuarios\EditarUsuarioService;
use App\Services\ServicesUsuarios\ListUsuariosService;
use App\Services\ServicesUsuarios\NovoUsuarioService;
use App\Services\ServicesUsuarios\SalvarUsuarioLocalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $data = app(ListUsuariosService::class)->execute($request->all(), User::LOCAL);
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

    public function checkEmail(Request $request) {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json(['exists' => true, 'user' => $user]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function store(StoreUsuarioLocalRequest $request)
    {
        try {
            DB::beginTransaction();
            app(SalvarUsuarioLocalService::class)->execute($request->all());
            DB::commit();
            return redirect()->route('usuarios.novo')->with('success', 'Usuário cadastrado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('usuarios.novo')->with('error', $e);
        }
    }

    public function editar($id)
    {
        try {
            $user = User::findOrFail($id);
            $perfis = app(NovoUsuarioService::class)->execute();
            return view('usuarios.editar', compact('user', 'perfis', 'id'));
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Erro ao abrir a página, por favor, tente mais tarde!');
        }
    }

    public function update(UpdateUsuarioRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            app(EditarUsuarioService::class)->execute($request->all(), $id);
            DB::commit();
            return redirect()->route('usuarios.editar', $id)->with('success', 'Usuário atualizado com sucesso.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('usuarios.editar', $id)->with('error', $e->getMessage());
        }
    }

    public function deletar($id)
    {
        try {
            DB::beginTransaction();
            app(DeletarUsuarioService::class)->execute($id);
            DB::commit();
            return redirect()->route('usuarios.index')->with('success', 'O vínculo deste usuário com a instituição foi removido.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('usuarios.index')->with('error', $e->getMessage());
        }
    }
}
