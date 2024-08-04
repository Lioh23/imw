@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Relatórios Distritais', 'url' => '#', 'active' => false],
    ['text' => 'Quantidade de Membros', 'url' => '#', 'active' => true],
]"></x-breadcrumb>
@endsection

@section('extras-css')
<link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('theme/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@include('extras.alerts')

@php
use Carbon\Carbon;
@endphp

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Quantidade de Membros</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <form class="form-vertical" id="filter_form" method="GET">
                <div class="form-group row mb-4" id="filtros_data_inicial">
                    <div class="col-lg-3 text-right">
                        <label class="control-label">* Data Inicial:</label>
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control @error('data_inicial') is-invalid @enderror" id="data_inicial" name="data_inicial" value="{{ request()->input('data_inicial') }}" required>
                    </div>
                </div>
                <div class="form-group row mb-4" id="filtros_data_final">
                    <div class="col-lg-3 text-right">
                        <label class="control-label">* Data Final:</label>
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control @error('data_final') is-invalid @enderror" id="data_final" name="data_final" value="{{ request()->input('data_final') }}" required>
                    </div>
                </div>
                <div class="form-group row mb-4" id="filtros_congregados">
                    <div class="col-lg-3 text-right">
                        <label class="control-label">* Incluir Congregados:</label>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" id="tipo" name="tipo">
                            <option value="">Selecione</option>
                            <option value="C" {{ request()->input('tipo') == 'C' ? 'selected' : '' }}>Sim</option>
                            <option value="M" {{ request()->input('tipo') == 'M' ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-6">
                        <button id="btn_buscar" type="submit" name="action" value="buscar" title="Buscar dados do Relatório" class="btn btn-primary btn">
                            <x-bx-search /> Buscar
                        </button>
                        <button id="btn_relatorio" type="button" class="btn btn-secondary">
                            <i class="fa fa-file-pdf"></i> Relatório
                        </button>
                    </div>
                </div>
            </form>

            <form id="report_form" action="{{ url('distrito/relatorio/quantidademembros/pdf') }}" method="POST" target="_blank" style="display: none;">
                @csrf
                <input type="hidden" name="data_inicial" id="report_data_inicial">
                <input type="hidden" name="data_final" id="report_data_final">
                <input type="hidden" name="igrejas" id="report_igrejas">
            </form>
        </div>
    </div>
</div>

@if(request()->input('data_inicial') && request()->input('data_final'))
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <!-- Conteúdo -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mt-3">QUANTIDADE DE MEMBROS - {{ session('session_perfil')->instituicao_nome }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="text-align: left" rowspan="2">IGREJA</th>
                                            <th width="100px" style="text-align: left" rowspan="2">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalGeral = 0;
                                        @endphp
                                        @foreach($lancamentos as $lancamento)
                                        <tr>
                                            <td style="text-align: left;">{{ $lancamento->nome }}</td>
                                            <td style="text-align: left;">{{ $lancamento->total }}</td>
                                            @php
                                            $totalGeral += $lancamento->total;
                                            @endphp
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="text-align: left;">Total Geral</th>
                                            <th style="text-align: left;">{{ $totalGeral }}</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-success btn-rounded" onclick="exportReportToExcel();"><i class="fa fa-file-excel" aria-hidden="true"></i> Exportar</button>
                </div>
            </div>
            <!-- Fim do Conteúdo -->
        </div>
    </div>
</div>
@endif

@section('extras-scripts')
<script src="{{ asset('theme/assets/js/planilha/papaparse.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/planilha/FileSaver.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/planilha/xlsx.full.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/planilha/planilha.js') }}"></script>
<script src="{{ asset('theme/assets/js/pages/movimentocaixa.js') }}"></script>
<script src="{{ asset('theme/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();

        $('#btn_relatorio').on('click', function(event) {
            var dataInicial = $('#data_inicial').val();
            var dataFinal = $('#data_final').val();
            var tipo = $('#tipo').val();

            if (!dataInicial || !dataFinal || !tipo) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos.');
            } else {
                $('#report_data_inicial').val(dataInicial);
                $('#report_data_final').val(dataFinal);
                $('#report_form').submit();
            }
        });

        $('#filter_form').submit(function(event) {
            var dataInicial = $('#data_inicial').val();
            var dataFinal = $('#data_final').val();
            var tipo = $('#tipo').val();

            if (!dataInicial || !dataFinal || !tipo) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos.');
            }
        });
    });
</script>
@endsection
@endsection