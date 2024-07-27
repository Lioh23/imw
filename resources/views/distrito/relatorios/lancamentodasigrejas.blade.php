@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Relatórios Distritais', 'url' => '#', 'active' => false],
        ['text' => 'Lançamento das Igrejas', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
<link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('theme/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@include('extras.alerts')

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Relatório Lançamentos das Igrejas</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <form class="form-vertical" id="filter_form" method="GET">
                <div class="form-group row mb-4" id="filtros_data">
                    <div class="col-lg-2 text-right">
                        <label class="control-label">* Ano:</label>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control @error('dtano') is-invalid @enderror" id="dtano" name="dtano" value="{{ request()->input('dtano') }}" placeholder="Exemplo: 2024" required>
                    </div>
                </div>

                {{-- Igrejas --}}
                <div class="form-group row mb-4">
                    <div class="col-lg-2 text-right">
                        <label class="control-label">* Igrejas:</label>
                    </div>
                    <div class="col-lg-6">
                        <select class="selectpicker" data-actions-box="true" data-header="Lista de Igrejas" multiple data-live-search="true" id="igreja_id" name="distritos[]" data-width="100%">
                            @foreach ($igrejaSelect as $igreja)
                            <option value="{{ $igreja->id }}" {{ request()->input('igreja_id') == $igreja->id ? 'selected' : '' }}>
                                {{ $igreja->descricao }}
                            </option>
                            @endforeach
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
        </div>
    </div>
</div>

@if(request()->input('dtano') && request()->input('igrejas'))
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <!-- Conteúdo -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mt-3">LANÇAMENTOS DAS IGREJAS </h5>
                            <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>CAIXA</th>
                                        <th width="300" style="text-align: right">IGREJA</th>
                                        <th width="120" style="text-align: right">JAN</th>
                                        <th width="120" style="text-align: right">FEV</th>
                                        <th width="120" style="text-align: right">MAR</th>
                                        <th width="120" style="text-align: right">ABR</th>
                                        <th width="120" style="text-align: right">MAI</th>
                                        <th width="120" style="text-align: right">JUN</th>
                                        <th width="120" style="text-align: right">JUL</th>
                                        <th width="120" style="text-align: right">AGO</th>
                                        <th width="120" style="text-align: right">SET</th>
                                        <th width="120" style="text-align: right">OUT</th>
                                        <th width="120" style="text-align: right">NOV</th>
                                        <th width="120" style="text-align: right">DEZ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
    jQuery(function($) {
        $.datepicker.regional['pt-BR'] = {
            closeText: 'Aplicar',
            prevText: '&#x3c;Anterior',
            nextText: 'Pr&oacute;ximo&#x3e;',
            currentText: 'Hoje',
            monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
            ],
            dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira',
                'Sexta-feira', 'Sabado'
            ],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            weekHeader: 'Sm',
            dateFormat: 'yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    });

    $(document).ready(function() {
        $('.selectpicker').selectpicker();

        // Inicializar o Datepicker
        $("#dtano").datepicker({
            dateFormat: "yy", // Formato do calendário (apenas ano)
            changeYear: true, // Permitir a seleção do ano
            showButtonPanel: true,
            language: 'pt-BR', // Definir o idioma como português
            onClose: function(dateText, inst) {
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker("setDate", new Date(year, 0, 1));
            }
        }).focus(function() {
            $(".ui-datepicker-month").hide();
            $(".ui-datepicker-calendar").hide();
        });

        $('#btn_relatorio').on('click', function() {
            var dataAno = $('#dtano').val();
            var igreja = $('#igreja_id').val();

            // Verificar se a data está preenchida
            if (!dataAno || !igreja || igreja.length === 0) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos.');
            } else {
                // Formata a URL para a rota de PDF
                var url = '{{ url("financeiro/relatorio/livrocaixa/pdf") }}' + '?dt=' + dtano + '&igreja_id=' + igreja_id;

                // Abre a URL em uma nova aba com os parâmetros corretos
                window.open(url, '_blank');
            }


        });

        $('#filter_form').submit(function(event) {
            var dataAno = $('#dtano').val();
            var igreja = $('#igreja_id').val();

            // Verificar se a data está preenchida
            if (!dataAno || !igreja || igreja.length === 0) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos.');
            }
        });
    });
</script>
@endsection
@endsection