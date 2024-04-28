@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Relatórios - Financeiro', 'url' => '#', 'active' => false],
        ['text' => 'Livro Caixa', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
@endsection

@include('extras.alerts')

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Relatório Livro Caixa</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <form class="form-vertical" id="filter_form" method="GET">
                <div class="form-group row mb-4" id="filtros_data">
                    <div class="col-lg-2 text-right">
                        <label class="control-label">* Mês/Ano:</label>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control @error('dt') is-invalid @enderror"
                            id="dt" name="dt" value="{{ request()->input('dt') }}" placeholder="mm/yyyy" required>
                    </div>                    
                </div>

                {{-- Congregação --}}
                <div class="form-group row mb-4">
                    <div class="col-lg-2 text-right">
                        <label class="control-label">Caixa:</label>
                    </div>
                    <div class="col-lg-6">
                        <select id="caixa_id" name="caixa_id"
                            class="form-control @error('caixa_id') is-invalid @enderror">
                            <option value="all" {{ request()->input('caixa_id') == '99' ? 'selected' : '' }}>Todos
                            </option>
                            @foreach ($caixasSelect as $cx)
                                <option value="{{ $cx->id }}"
                                    {{ request()->input('caixa_id') == $cx->id ? 'selected' : '' }}>
                                    {{ $cx->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-6">
                        <button id="btn_buscar" type="submit" name="action" value="buscar"
                            title="Buscar dados do Relatório" class="btn btn-primary btn">
                            <x-bx-search /> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <!-- Conteúdo -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mt-3">Discriminação de saldos por caixa</h5>
                            <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>CAIXA</th>
                                        <th width="300" style="text-align: right">
                                            @if ($ultimoCaixa)
                                                SALDO ANTERIOR CONSOLIDADO {{ $ultimoCaixa }}
                                            @else
                                                NÃO POSSUI SALDO ANTERIOR
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
                                            $totalUltimoConciliado += $caixa->totalLancamentosUltimosConciliados(request()->input('dt'));
                                            $totalEntradas += $caixa->totalLancamentosEntrada(request()->input('dt'));
                                            $totalSaidas += $caixa->totalLancamentosSaida(request()->input('dt'));
                                            $totalTransfEntradas += $caixa->totalLancamentosTransferenciaEntrada(request()->input('dt'));
                                            $totalTransfSaidas += $caixa->totalLancamentosTransferenciaSaida(request()->input('dt'));
                                            $saldoAtualNaoConciliado += $caixa->saldoAtual(request()->input('dt'));
                                        @endphp
                                        <tr>
                                            <td style="text-align: left">{{ $caixa->descricao }}</td>
                                            <td style="text-align: right">R${{ number_format($caixa->totalLancamentosUltimosConciliados(request()->input('dt')), 2, ',', '.') }}</td>
                                            <td style="text-align: right">R${{ number_format($caixa->totalLancamentosEntrada(request()->input('dt')), 2, ',', '.') }}</td>
                                            <td style="text-align: right">{!! $caixa->totalLancamentosSaida(request()->input('dt')) > 0 ? '<span>-R$' . number_format($caixa->totalLancamentosSaida(request()->input('dt')), 2, ',', '.') . '</span>' : 'R$' . number_format($caixa->totalLancamentosSaida(request()->input('dt')), 2, ',', '.') !!}</td>
                                            <td style="text-align: right">R${{ number_format($caixa->totalLancamentosTransferenciaEntrada(request()->input('dt')), 2, ',', '.') }}</td>
                                            <td style="text-align: right">{!! $caixa->totalLancamentosTransferenciaSaida(request()->input('dt')) != 0 ? '<span>-R$' . number_format(abs($caixa->totalLancamentosTransferenciaSaida(request()->input('dt'))), 2, ',', '.') . '</span>' : 'R$' . number_format(abs($caixa->totalLancamentosTransferenciaSaida(request()->input('dt'))), 2, ',', '.') !!}</td>
                                            <td style="text-align: right">{!! $caixa->saldoAtual(request()->input('dt')) > 0 ? '<span class="badge badge-success">R$' . number_format($caixa->saldoAtual(request()->input('dt')), 2, ',', '.') . '</span>' : ($caixa->saldoAtual(request()->input('dt')) < 0 ? '<span class="badge badge-danger">-R$' . number_format($caixa->saldoAtual(request()->input('dt')), 2, ',', '.') . '</span>' : ($caixa->saldoAtual(request()->input('dt')) == 0 ? '<span class="badge badge-secondary">R$' . number_format($caixa->saldoAtual(request()->input('dt')), 2, ',', '.') . '</span>' : 'R$' . number_format($caixa->saldoAtual(request()->input('dt')), 2, ',', '.'))) !!}</td>
                                        </tr>
                                    @endforeach
                            
                                   {{--  <tr>
                                        <td style="text-align: left"><strong><b>Total dos Caixas</b></strong></td>
                                        <td style="text-align: right"><strong>R${{ number_format($totalUltimoConciliado, 2, ',', '.') }}</strong></td>
                                        <td style="text-align: right"><strong>R${{ number_format($totalEntradas, 2, ',', '.') }}</strong></td>
                                        <td style="text-align: right"><strong>{!! $totalSaidas > 0 ? '<span>-R$' . number_format($totalSaidas, 2, ',', '.') . '</span>' : 'R$' . number_format($totalSaidas, 2, ',', '.') !!}</strong></td>
                                        <td style="text-align: right"><strong>R${{ number_format($totalTransfEntradas, 2, ',', '.') }}</strong></td>
                                        <td style="text-align: right"><strong>{!! $totalTransfSaidas > 0 ? '<span>-R$' . number_format($totalTransfSaidas, 2, ',', '.') . '</span>' : 'R$' . number_format($totalTransfSaidas, 2, ',', '.') !!}</strong></td>
                                        <td style="text-align: right">{!! $saldoAtualNaoConciliado > 0 ? '<strong><span class="badge badge-success">R$' . number_format($saldoAtualNaoConciliado, 2, ',', '.') . '</span></strong>' : ($saldoAtualNaoConciliado < 0 ? '<strong><span class="badge badge-danger">-R$' . number_format($saldoAtualNaoConciliado, 2, ',', '.') . '</span></strong>' : ($saldoAtualNaoConciliado == 0 ? '<strong><span class="badge badge-secondary">R$' . number_format($saldoAtualNaoConciliado, 2, ',', '.') . '</span></strong>' : number_format($saldoAtualNaoConciliado, 2, ',', '.'))) !!}</td>
                                    </tr> --}}
                                </tbody>
                            </table>                                
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button class="btn btn-success btn-rounded" onclick="exportReportToExcel();"><i
                                    class="fa fa-file-excel" aria-hidden="true"></i> Exportar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim do Conteúdo -->
        </div>
    </div>
</div>

@section('extras-scripts')
<script>
    jQuery(function($){
        $.datepicker.regional['pt-BR'] = {
                closeText: 'Aplicar',
                prevText: '&#x3c;Anterior',
                nextText: 'Pr&oacute;ximo&#x3e;',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});
$(document).ready(function() {
    // Inicializar o Datepicker
    $("#dt").datepicker({
        dateFormat: "mm/yy", // Formato do calendário (mês/ano)
        changeMonth: true,    // Permitir a seleção do mês
        changeYear: true,     // Permitir a seleção do ano
        showButtonPanel: true,
        language: 'pt-BR',    // Definir o idioma como português
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker("setDate", new Date(year, month, 1));
        }
    }).focus(function() {
        $(".ui-datepicker-calendar").hide();
    });
});
</script>
@endsection
@endsection