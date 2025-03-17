<?php

namespace App\Http\Controllers;

use App\Services\TotalizacaoRegiaoService\DezDisitritosMaisBatismoService;
use App\Services\TotalizacaoRegiaoService\DezDisitritosMaisMembrosService;
use App\Services\TotalizacaoRegiaoService\DezDisitritosMaisReceberamMembrosService;
use App\Services\TotalizacaoRegiaoService\TotalizacaoCongregacoesDistritos;
use App\Services\TotalizacaoRegiaoService\TotalizacaoCongregacoesIgrejas;
use App\Services\TotalizacaoRegiaoService\TotalizacaoDistritosRegiaoService;
use App\Services\TotalizacaoRegiaoService\TotalizacaoIgrejasDistritosService;
use Illuminate\Http\Request;

class TotalizacaoController extends Controller
{


    public function totalDitritoPorRegiao()
    {


        $data = app(TotalizacaoDistritosRegiaoService::class)->execute();

        return view('regiao.totalizacoes.totalizacaodistritoregiao', $data);
    }
    public function totaligrejasdistritos()
    {


        $data = app(TotalizacaoIgrejasDistritosService::class)->execute();

        return view('regiao.totalizacoes.totalizacaoigrejasdistritos', $data);
    }
    public function totalcongregacoesigrejas()
    {


        $data = app(TotalizacaoCongregacoesIgrejas::class)->execute();

        return view('regiao.totalizacoes.totalizacaocongregacoesigrejas', $data);
    }


    public function totalcongregacoesdistritos()
    {


        $data = app(TotalizacaoCongregacoesDistritos::class)->execute();

        return view('regiao.totalizacoes.totalizacaocongregacoesdistritos', $data);
    }


    public function distritomaisbatismo(Request $request)
    {

        $dataFinal = $request->input('data_final');
        $dataInicial = $request->input('data_inicial');

        $data = app(DezDisitritosMaisBatismoService::class)->execute($dataFinal, $dataInicial);

        return view('regiao.dezmais.distritomaisbatismo', $data);
    }
    public function distritomaismembros(Request $request)
    {

        $dataFinal = $request->input('data_final');
        $dataInicial = $request->input('data_inicial');

        $data = app(DezDisitritosMaisMembrosService::class)->execute($dataFinal, $dataInicial);

        return view('regiao.dezmais.distritomaismembros', $data);
    }
    public function distritomaiscrescerammembros(Request $request)
    {

        $dataFinal = $request->input('data_final');
        $dataInicial = $request->input('data_inicial');

        $data = app(DezDisitritosMaisReceberamMembrosService::class)->execute($dataFinal, $dataInicial);

        return view('regiao.dezmais.distritomaiscrescerammembros', $data);
    }
}
