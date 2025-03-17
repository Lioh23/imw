@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Clérigo por situação', 'url' => '#', 'active' => false],
        ['text' => 'Total Clérigos por situação status', 'url' => '#', 'active' => true],
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
                        <h4>Total Clérigos por situação status- {{ $regiao->nome }}</h4>
                    </div>
                </div>
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
                                <h6 class="mt-3 text-uppercase">Total Clérigos por situação status -
                                    {{ $regiao->nome }}</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: left;">Status</th>
                                                <th style="text-align: center;">Total</th>
                                                <th style="text-align: center;">Percentual</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($lancamentos as $lancamento)
                                                <tr>

                                                    <td>{{ $lancamento->descricao }}</td>
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


@section('extras-scripts')
    <script src="{{ asset('theme/assets/js/planilha/papaparse.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/planilha/FileSaver.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/planilha/xlsx.full.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/planilha/planilha.js') }}"></script>
    <script src="{{ asset('theme/assets/js/pages/movimentocaixa.js') }}"></script>
    <script src="{{ asset('theme/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
@endsection
@endsection
