@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
        ['text' => 'Financeiro', 'url' => '/', 'active' => false],
        ['text' => 'Consolidação de Caixa', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection
@section('extras-css')
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />

<style>
    .swal2-popup .swal2-styled.swal2-cancel {
        color: white !important;
    }

    .modal-body ul {
        padding-left: 20px;
    }

    .modal-body ul li {
        word-wrap: break-word;
        white-space: normal;
    }

    .badge-danger {
        font-weight: normal;
    }
</style>
@endsection
@section('extras-scripts')
<script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
@endsection

@section('content')
@include('extras.alerts')
<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Use modal-xl para um modal ainda maior -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Atenção!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <ul id="alertMessages">
                    <!-- Alert messages will be displayed here -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

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
                                        <th width="300" style="text-align: right">ÚLTIMO SALDO CONSOLIDADO EM {{ \Carbon\Carbon::parse($ultimoCaixa)->isoFormat('MMMM [de] YYYY') }}</th>
                                        <th width="120" style="text-align: right">TOTAIS DE ENTRADAS</th>
                                        <th width="120" style="text-align: right">TOTAIS DE SAÍDAS</th>
                                        <th width="120" style="text-align: right">TRANSF. ENTRADAS</th>
                                        <th width="120" style="text-align: right">TRANSF. SAÍDAS</th>
                                        <th width="120" style="text-align: right">SALDO ATUAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $totalSaldoFinal = 0;
                                    $totalEntradas = 0;
                                    $totalSaidas = 0;
                                    $totalTransferenciasEntrada = 0;
                                    $totalTransferenciasSaida = 0;
                                    $totalSaldoAtual = 0;
                                    @endphp

                                    @foreach ($caixas as $caixa)
                                    <tr>
                                        <td style="text-align: left">{{ $caixa->caixa }}</td>
                                        <td style="text-align: right">
                                            {{ 'R$ ' . number_format($caixa->saldo_final, 2, ',', '.') }}
                                        </td>
                                        <td class="total-entradas" style="text-align: right">
                                            {{ 'R$ ' . number_format($caixa->total_entradas, 2, ',', '.') }}
                                        </td>
                                        <td style="text-align: right">
                                            {{ 'R$ ' . ($caixa->total_saidas > 0 ? '-' : '') . number_format(abs($caixa->total_saidas), 2, ',', '.') }}
                                        </td>
                                        <td style="text-align: right">
                                            {{ 'R$ ' . number_format($caixa->total_transferencias_entrada, 2, ',', '.') }}
                                        </td>
                                        <td style="text-align: right">
                                            {{ 'R$ ' . ($caixa->total_transferencias_saida > 0 ? '-' : '') . number_format(abs($caixa->total_transferencias_saida), 2, ',', '.') }}
                                        </td>
                                        <td class="saldo-atual" style="text-align: right">
                                            {{ 'R$ ' . number_format($caixa->saldo_atual, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                    @php
                                    $totalSaldoFinal += $caixa->saldo_final;
                                    $totalEntradas += $caixa->total_entradas;
                                    $totalSaidas += $caixa->total_saidas;
                                    $totalTransferenciasEntrada += $caixa->total_transferencias_entrada;
                                    $totalTransferenciasSaida += $caixa->total_transferencias_saida;
                                    $totalSaldoAtual += $caixa->saldo_atual;
                                    @endphp
                                    @endforeach

                                    {{-- Total de cada caixa --}}
                                    <tr>
                                        <td style="text-align: left"><strong>Total dos Caixas</strong></td>
                                        <td style="text-align: right">
                                            <strong>{{ 'R$ ' . number_format($totalSaldoFinal, 2, ',', '.') }}</strong>
                                        </td>
                                        <td style="text-align: right">
                                            <strong>{{ 'R$ ' . number_format($totalEntradas, 2, ',', '.') }}</strong>
                                        </td>
                                        <td style="text-align: right">
                                            <strong>{{ 'R$ ' . ($totalSaidas > 0 ? '-' : '') . number_format(abs($totalSaidas), 2, ',', '.') }}</strong>
                                        </td>
                                        <td style="text-align: right">
                                            <strong>{{ 'R$ ' . number_format($totalTransferenciasEntrada, 2, ',', '.') }}</strong>
                                        </td>
                                        <td style="text-align: right">
                                            <strong>{{ 'R$ ' . ($totalTransferenciasSaida > 0 ? '-' : '') . number_format(abs($totalTransferenciasSaida), 2, ',', '.') }}</strong>
                                        </td>
                                        <td class="saldo-atual" style="text-align: right">
                                            <strong>{{ 'R$ ' . number_format($totalSaldoAtual, 2, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 mt-3">
                            <h5>Discriminação dos Lançamentos por Conta</h5>
                        </div>

                        <div class="col-12">
                            <table class="table" style="font-size: 90%; margin-top: 15px;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>CONTA</th>
                                        <th>CAIXA</th>
                                        <th width="100">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $numerosJaExibidos = []; @endphp
                                    @foreach ($lancamentos as $index => $lancamento)
                                    @if (!in_array($lancamento->numeracao, $numerosJaExibidos))
                                    <tr>
                                        <td rowspan="{{ count(array_filter($lancamentos, function($item) use ($lancamento) {
                                                        return $item->numeracao === $lancamento->numeracao;
                                                    })) }}" style="font-weight: bold">
                                            {{ $lancamento->numeracao }} - {{ $lancamento->nome }}
                                        </td>
                                        <td>{{ $lancamento->caixa }}</td>
                                        <td>R$ {{ number_format($lancamento->total, 2, ',', '.') }}</td>
                                    </tr>
                                    @php $numerosJaExibidos[] = $lancamento->numeracao; @endphp
                                    @else
                                    <tr>
                                        <td>{{ $lancamento->caixa }}</td>
                                        <td>R$ {{ number_format($lancamento->total, 2, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <span id="warningMessage" class="alert alert-danger" style="display: none;"></span>

                        <form class="mt-4" method="post" action="{{ route('financeiro.consolidar.store') }}" id="form_consolidacao_automatica">
                            @csrf
                            <input type="hidden" name="ano" value="{{ \Carbon\Carbon::parse($ultimoCaixa)->addMonth()->year }}" />
                            <input type="hidden" name="mes" value="{{ \Carbon\Carbon::parse($ultimoCaixa)->addMonth()->month }}" />
                            <button data-form-id="form_consolidacao_automatica" class="btn btn-success p-2 btn-rounded btn-confirm" style="text-transform: uppercase;" type="button" disabled>CONSOLIDAR {{ \Carbon\Carbon::parse($ultimoCaixa)->addMonth()->isoFormat('MMMM [de] YYYY') }}</button>
                        </form>

                    </div>

                </div>
            </div>
            <!-- Fim do Conteúdo -->
        </div>
    </div>
</div>
<script>
   $(document).ready(function() {
    // Adiciona badges conforme o saldo atual
    $('.saldo-atual').each(function() {
        var saldoText = $(this).text().replace('R$ ', '').replace('.', '').replace(',', '.');
        var saldo = parseFloat(saldoText);

        if (saldo < 0) {
            $(this).html('<span class="badge badge-danger">' + $(this).html() + '</span>');
        } else if (saldo === 0) {
            $(this).html('<span class="badge badge-secondary">' + $(this).html() + '</span>');
        } else {
            $(this).html('<span class="badge badge-success">' + $(this).html() + '</span>');
        }
    });

    // Verificações das regras
    let shouldSubmit = true;
    let entradasNegativasOuZero = [];
    let saldosNegativos = [];

    // Verifica totais de entradas
    $('.total-entradas').each(function() {
        var entradaText = $(this).text().replace('R$ ', '').replace('.', '').replace(',', '.');
        var entrada = parseFloat(entradaText);
        var caixa = $(this).closest('tr').find('td:first').text();

        if (entrada <= 0) {
            entradasNegativasOuZero.push(caixa);
            shouldSubmit = false;
        }
    });

    // Verifica saldo atual
    $('.saldo-atual').each(function() {
        var saldoText = $(this).text().replace('R$ ', '').replace('.', '').replace(',', '.');
        var saldo = parseFloat(saldoText);
        var caixa = $(this).closest('tr').find('td:first').text();

        if (saldo < 0) {
            saldosNegativos.push(caixa);
            shouldSubmit = false;
        }
    });

    if (!shouldSubmit) {
        let alertList = '';

        if (entradasNegativasOuZero.length > 0) {
            alertList += `<li><h3 class="badge badge-default">OS SEGUINTES CAIXAS NÃO PODEM TER ENTRADAS NEGATIVAS OU ZERO:</h3><ul>${entradasNegativasOuZero.map(caixa => `<li>${caixa}</li>`).join('')}</ul></li>`;
        }

        if (saldosNegativos.length > 0) {
            alertList += `<li><h3 class="badge badge-default">OS SEGUINTES CAIXAS NÃO PODEM TER SALDO NEGATIVO:</h3><ul>${saldosNegativos.map(caixa => `<li>${caixa}</li>`).join('')}</ul></li>`;
        }

        $('#alertMessages').html(`<ul>${alertList}</ul>`);
        $('#alertModal').modal('show');
        $('.btn-confirm').prop('disabled', true);
    } else {
        $('#alertMessages').html('');
        $('.btn-confirm').prop('disabled', false);
    }

    const formId = $('.btn-confirm').data('form-id');

    $('.btn-confirm').on('click', function() {
        swal({
            title: 'Atenção, deseja realmente consolidar?',
            text: 'Por favor, corrija os problemas listados antes de consolidar.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            confirmButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#3085d6",
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                document.getElementById(formId).submit();
            }
        });
    });
});

</script>

@endsection