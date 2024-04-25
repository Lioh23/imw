@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Financeiro', 'url' => '/', 'active' => false],
        ['text' => 'Consolidação de Caixa', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection
@section('content')
    <div class="container-fluid">

    </div>
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <!-- Conteúdo -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mt-3">Composição de Saldos por Caixa</h5>
                                <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>CAIXA</th>
                                            <th width="300" style="text-align: right">
                                                @if ($ultimoCaixa)
                                                    ÚLTIMO SALDO CONSOLIDADO EM {{ \Carbon\Carbon::parse($ultimoCaixa)->isoFormat('MMMM [de] YYYY') }}
                                                @else
                                                    NÃO POSSUI ÚLTIMO SALDO CONSOLIDADO
                                                @endif
                                            </th>
                                            <th width="100" style="text-align: right">TOTAIS DE ENTRADAS</th>
                                            <th width="100" style="text-align: right">TOTAIS DE SAÍDAS</th>
                                            <th width="100" style="text-align: right">TRANSF. ENTRADAS</th>
                                            <th width="100" style="text-align: right">TRANSF. SAÍDAS</th>
                                            <th width="100" style="text-align: right">SALDO ATUAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalUltimoConciliado = 0;
                                            $totalEntradas = 0;
                                            $totalSaidas = 0;
                                            $totalTransfEntradas = 0;
                                            $totalTransfSaidas = 0;
                                            $saldoAtualNaoConciliado = 0;
                                        @endphp

                                        @foreach ($caixas as $caixa)
                                            @php
                                                $totalUltimoConciliado += $caixa->totalLancamentosUltimosConciliados();
                                                $totalEntradas += $caixa->totalLancamentosNaoConciliadosEntrada();
                                                $totalSaidas += $caixa->totalLancamentosNaoConciliadosSaida();
                                                $totalTransfEntradas += $caixa->totalLancamentosNaoConciliadosTransferenciaEntrada();
                                                $totalTransfSaidas += $caixa->totalLancamentosNaoConciliadosTransferenciaSaida();
                                                $saldoAtualNaoConciliado += $caixa->saldoAtualNaoConciliado();
                                            @endphp
                                            <tr>
                                                <td style="text-align: left">{{ $caixa->descricao }}</td>
                                                <td style="text-align: right">
                                                    R${{ number_format($caixa->totalLancamentosUltimosConciliados(), 2, ',', '.') }}
                                                </td>
                                                <td style="text-align: right">
                                                    R${{ number_format($caixa->totalLancamentosNaoConciliadosEntrada(), 2, ',', '.') }}
                                                </td>
                                                <td style="text-align: right">{!! $caixa->totalLancamentosNaoConciliadosSaida() > 0
                                                    ? '<span>-R$' . number_format($caixa->totalLancamentosNaoConciliadosSaida(), 2, ',', '.') . '</span>'
                                                    : 'R$' . number_format($caixa->totalLancamentosNaoConciliadosSaida(), 2, ',', '.') !!}</td>
                                                <td style="text-align: right">
                                                    R${{ number_format($caixa->totalLancamentosNaoConciliadosTransferenciaEntrada(), 2, ',', '.') }}
                                                </td>
                                                <td style="text-align: right">{!! $caixa->totalLancamentosNaoConciliadosTransferenciaSaida() != 0
                                                    ? '<span>-R$' .
                                                        number_format(abs($caixa->totalLancamentosNaoConciliadosTransferenciaSaida()), 2, ',', '.') .
                                                        '</span>'
                                                    : 'R$' . number_format(abs($caixa->totalLancamentosNaoConciliadosTransferenciaSaida()), 2, ',', '.') !!}</td>
                                                <td style="text-align: right">{!! $caixa->saldoAtualNaoConciliado() > 0
                                                    ? '<span class="badge badge-success">R$' . number_format($caixa->saldoAtualNaoConciliado(), 2, ',', '.') . '</span>'
                                                    : ($caixa->saldoAtualNaoConciliado() < 0
                                                        ? '<span class="badge badge-danger">-R$' .
                                                            number_format($caixa->saldoAtualNaoConciliado(), 2, ',', '.') .
                                                            '</span>'
                                                        : ($caixa->saldoAtualNaoConciliado() == 0
                                                            ? '<span class="badge badge-secondary">R$' .
                                                                number_format($caixa->saldoAtualNaoConciliado(), 2, ',', '.') .
                                                                '</span>'
                                                            : 'R$' . number_format($caixa->saldoAtualNaoConciliado(), 2, ',', '.'))) !!}</td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td style="text-align: left"><strong><b>Total dos Caixas</b></strong></td>
                                            <td style="text-align: right">
                                                <strong>R${{ number_format($totalUltimoConciliado, 2, ',', '.') }}</strong>
                                            </td>
                                            <td style="text-align: right">
                                                <strong>R${{ number_format($totalEntradas, 2, ',', '.') }}</strong></td>
                                            <td style="text-align: right"><strong>{!! $totalSaidas > 0
                                                ? '<span>-R$' . number_format($totalSaidas, 2, ',', '.') . '</span>'
                                                : 'R$' . number_format($totalSaidas, 2, ',', '.') !!}</strong></td>
                                            <td style="text-align: right">
                                                <strong>R${{ number_format($totalTransfEntradas, 2, ',', '.') }}</strong>
                                            </td>
                                            <td style="text-align: right"><strong>{!! $totalTransfSaidas > 0
                                                ? '<span>-R$' . number_format($totalTransfSaidas, 2, ',', '.') . '</span>'
                                                : 'R$' . number_format($totalTransfSaidas, 2, ',', '.') !!}</strong></td>
                                            <td style="text-align: right">{!! $saldoAtualNaoConciliado > 0
                                                ? '<strong><span class="badge badge-success">R$' .
                                                    number_format($saldoAtualNaoConciliado, 2, ',', '.') .
                                                    '</span></strong>'
                                                : ($saldoAtualNaoConciliado < 0
                                                    ? '<strong><span class="badge badge-danger">-R$' .
                                                        number_format($saldoAtualNaoConciliado, 2, ',', '.') .
                                                        '</span></strong>'
                                                    : ($saldoAtualNaoConciliado == 0
                                                        ? '<strong><span class="badge badge-secondary">R$' .
                                                            number_format($saldoAtualNaoConciliado, 2, ',', '.') .
                                                            '</span></strong>'
                                                        : number_format($saldoAtualNaoConciliado, 2, ',', '.'))) !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 mt-3">
                                <h5>Discriminação dos Lançamentos por Conta</h5>
                            </div>
                            
                            <div class="col-12">
                                <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2">CONTA / CAIXA</th>
                                            <th width="100">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $lastNumeracaoConta = null;
                                            $totalConta = 0;
                                        @endphp
                            
                                        @foreach($lancamentosPorConta as $lancamento)
                                            @if($lastNumeracaoConta != $lancamento->numeracao_conta)
                                                @if($lastNumeracaoConta != null)
                                                    <tr>
                                                        <th width="80"></th>
                                                        <th>Total da Conta</th>
                                                        <th>R$ {{ number_format($totalConta, 2, ',', '.') }}</th>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th width="80">{{ $lancamento->numeracao_conta }}</th>
                                                    <th>{{ $lancamento->nome_conta }}</th>
                                                    <th></th>
                                                </tr>
                                                @php
                                                    $totalConta = 0;
                                                @endphp
                                            @endif
                            
                                            <tr>
                                                <td width="80"></td>
                                                <td>{{ $lancamento->descricao_caixa }}</td>
                                                <td>R$ {{ number_format($lancamento->total_lancamentos, 2, ',', '.') }}</td>
                                            </tr>
                            
                                            @php
                                                $totalConta += $lancamento->total_lancamentos;
                                                $lastNumeracaoConta = $lancamento->numeracao_conta;
                                            @endphp
                                        @endforeach
                            
                                        @if(!is_null($lastNumeracaoConta))
                                            <tr>
                                                <th width="80"></th>
                                                <th>Total da Conta</th>
                                                <th>R$ {{ number_format($totalConta, 2, ',', '.') }}</th>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <form method="post" method="POST" {{-- action="{{route('consolidar.store')}}" --}}>
                                @csrf
                                <button class="btn btn-success p-2 btn-rounded" style="text-transform: uppercase;" type="submit">CONSOLIDAR {{ \Carbon\Carbon::parse($ultimoCaixa)->addMonth()->isoFormat('MMMM [de] YYYY') }}
                                </button>
                            </form>
                        </div>
                        
                    </div>
                </div>
                <!-- Fim do Conteúdo -->
            </div>
        </div>
    </div>
@endsection
