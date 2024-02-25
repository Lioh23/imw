<?php

namespace App\Http\Controllers;

use App\Exceptions\ReceberNovoMembroException;
use App\Http\Requests\StoreReceberNovoMembroRequest;
use App\Http\Requests\UpdateMembroRequest;
use App\Models\MembresiaMembro;
use App\Services\ServiceMembros\IdentificaDadosReceberNovoMembroService;
use Illuminate\Http\Request;

class MembrosController extends Controller
{
    public function index()
    {
        return view('membros.index');
    }
  
    public function editar($id)
    {
        return view('membros.editar');
    }

    public function update(UpdateMembroRequest $request)
    {
        
    }

    public function receberNovo($id)
    {
        try {
            $data = app(IdentificaDadosReceberNovoMembroService::class)->execute($id);

            $pessoa       = $data['pessoa'];
            $sugestaoRol  = $data['sugestao_rol'];
            $pastores     = $data['pastores'];
            $modos        = $data['modos'];
            $congregacoes = $data['congregacoes'];

            return view('membros.receber_novo', compact('pessoa', 'sugestaoRol', 'pastores', 'modos', 'congregacoes'));
        } catch(ReceberNovoMembroException $e) {
            return redirect()->back()->with('error', 'Esta pessoa não existe na base de dados ou não pode ser recebida como Membro');
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao exibir a página solicitada');
        }
    }

    public function StoreReceberNovo(StoreReceberNovoMembroRequest $request)
    {
        
    }
}
