<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCongregacaoRequest;
use App\Models\CongregacoesCongregacao;
use App\Services\ServiceDatatable\CongregacoesDatatable;
use App\Traits\Identifiable;
use App\Traits\LocationUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CongregacoesController extends Controller
{
    use LocationUtils, Identifiable;

    public function index()
    {
        return view('congregacoes.index');
    }

    public function list(Request $request)
    {
        try {
            return app(CongregacoesDatatable::class)->execute($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Não foi possível listar as congregações'], 500);
        }
    }

    public function novo()
    {
        try { 
            return view('congregacoes.create', [
                'ufs'           => LocationUtils::fetchUFs(),
                // 'InstituicaoId' => Identifiable::fetchSessionIgrejaLocal()->id
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível criar uma nova congregação');
        }
    }

    public function store(SaveCongregacaoRequest $request)
    {
        try {
            DB::beginTransaction();
            CongregacoesCongregacao::create($request->all());
            DB::commit();
            return redirect()->route('congregacao.index')->with('success', 'Nova congregação salva com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Não foi possível salvar a congregação');
        }
    }

    public function update(SaveCongregacaoRequest $request)
    {

    }

    public function desativar()
    {

    }

    public function editar()
    {

    }

    public function restaurar()
    {

    }
}
