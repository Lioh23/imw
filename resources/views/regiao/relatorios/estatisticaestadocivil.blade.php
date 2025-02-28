@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Relatórios Regionais', 'url' => '#', 'active' => false],
        ['text' => 'Estatística por Estado civil', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/plugins/bootstrap-select/bootstrap-select.min.css') }}"
        rel="stylesheet" type="text/css" />
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
                        <h4>Estatísticas por Estado civil - {{ optional($instituicao)->nome ?? $regiao->nome }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="form-vertical" id="filter_form" method="GET">
                    <div class="form-group row mb-4">
                        <div class="col-lg-3 text-right">
                            <label class="control-label">* Distrito:</label>
                        </div>
                        <div class="col-lg-3">
                            <select class="form-control" id="distrito" name="distrito" required>
                                <option value="">Selecione</option>
                                <option value="all" {{ request()->input('distrito') == 'all' ? 'selected' : '' }}>Todos
                                </option>
                                @foreach ($distritos as $distrito)
                                    <option value="{{ $distrito->id }}"
                                        {{ request()->input('distrito') == $distrito->id ? 'selected' : '' }}>
                                        {{ $distrito->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="for-group row mb-4">
                        <div class="col-lg-3 text-right">
                            <label class="control-label">* Estado civil:</label>
                        </div>
                        <div class="col-lg-3">
                            <select class="form-control" id="estado_civil" name="estado_civil" required>
                                <option value="">Selecione</option>
                                <option value="S" {{ request()->input('estado_civil')  == 'S' ? 'selected' : '' }}>Solteiro
                                </option>
                                <option value="C" {{ request()->input('estado_civil')  == 'C' ? 'selected' : '' }}>Casado</option>
                                <option value="D" {{ request()->input('estado_civil')  == 'D' ? 'selected' : '' }}>Divorciado
                                </option>
                                <option value="V" {{ request()->input('estado_civil')  == 'V' ? 'selected' : '' }}>Viúvo</option>
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
                            <button id="btn_relatorio" type="button" class="btn btn-secondary">
                                <i class="fa fa-file-pdf"></i> Relatório
                            </button>
                        </div>
                    </div>
                </form>

                <form id="report_form" action="{{ url('regiao/relatorio/estatisticaestadocivil/pdf') }}" method="POST"
                    target="_blank" style="display: none;">
                    @csrf
                    <input type="hidden" name="distrito" id="report_distrito">
                    <input type="hidden" name="estado_civil" id="report_estado_civil">
                </form>
            </div>
        </div>
    </div>

    @if (request()->input('distrito'))
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <!-- Conteúdo -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="mt-3">QUANTIDADE DE MEMBROS -
                                        {{ optional($instituicao)->nome ?? $regiao->nome }}</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th style="text-align: left;">Instituição</th>
                                                    <th style="text-align: center;">Total</th>
                                                    <th style="text-align: center;">Percentual</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($lancamentos as $lancamento)
                                                    <tr>
                                                        <td>{{ $lancamento->instituicao }}</td>
                                                        <td style="text-align: center;">{{ $lancamento->total }}</td>
                                                        <td style="text-align: center;">
                                                            {{ number_format($lancamento->percentual, 2) }}%</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th style="text-align: left;">Total Geral</th>
                                                    <th style="text-align: center;">{{ $lancamentos->sum('total') }}</th>
                                                    <th style="text-align: center;">100%</th>
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
                            <button class="btn btn-success btn-rounded" onclick="exportReportToExcel();"><i
                                    class="fa fa-file-excel" aria-hidden="true"></i> Exportar</button>
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
                var distrito = $('#distrito').val();
                var estado_civil = $('#estado_civil').val();


                if (!distrito || !estado_civil) {
                    event.preventDefault();
                    alert('Por favor, preencha todos os campos.');
                } else {
                    $('#report_distrito').val(distrito);
                    $('#report_estado_civil').val(estado_civil);
                    $('#report_form').submit();
                }
            });

            $('#filter_form').submit(function(event) {
                var distrito = $('#distrito').val();
                var estado_civil = $('#estado_civil').val();


                if (!distrito || !estado_civil) {
                    event.preventDefault();
                    alert('Por favor, preencha todos os campos.');
                }
            });
        });
    </script>
@endsection
@endsection
