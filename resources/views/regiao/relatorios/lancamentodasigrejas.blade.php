@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Relatórios Regionais', 'url' => '#', 'active' => false],
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
                        <select class="form-control" id="igreja_id" name="igreja_id" data-width="100%">
                            @foreach ($igrejas as $igreja)
                            <option value="{{ $igreja->id }}" {{ $igreja->id == request()->input('igreja_id') ? 'selected' : '' }}>
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
            <form id="report_form" action="{{ url('regiao/relatorio/lancamentodasigrejas/pdf') }}" method="POST" target="_blank" style="display: none;">
                @csrf
                <input type="hidden" name="dtano" id="report_dtano">
                <input type="hidden" name="igreja_id" id="report_igreja_id">
            </form>
        </div>
    </div>
</div>

@if(request()->input('dtano') && request()->input('igreja_id'))
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <!-- Conteúdo -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mt-3">LANÇAMENTOS DAS IGREJAS - {{ $instituicao->nome }}</h6>
                            <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                <thead class="thead-dark">
                                    <tr>
                                        <!--    <th width="300" style="text-align: left">DISTRITO</th> -->
                                        <th width="300" style="text-align: left">IGREJA</th>
                                        <th width="50" style="text-align: right">JAN</th>
                                        <th width="50" style="text-align: right">FEV</th>
                                        <th width="50" style="text-align: right">MAR</th>
                                        <th width="50" style="text-align: right">ABR</th>
                                        <th width="50" style="text-align: right">MAI</th>
                                        <th width="50" style="text-align: right">JUN</th>
                                        <th width="50" style="text-align: right">JUL</th>
                                        <th width="50" style="text-align: right">AGO</th>
                                        <th width="50" style="text-align: right">SET</th>
                                        <th width="50" style="text-align: right">OUT</th>
                                        <th width="50" style="text-align: right">NOV</th>
                                        <th width="50" style="text-align: right">DEZ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lancamentos as $lancamento)
                                    <tr>
                                        <!--  <td>{{ $lancamento->instituicao_pai_nome}}</td> -->
                                        <td>{{ $lancamento->instituicao_nome }}</td>
                                        <td style="text-align: right">{{ $lancamento->janeiro }}</td>
                                        <td style="text-align: right">{{ $lancamento->fevereiro }}</td>
                                        <td style="text-align: right">{{ $lancamento->marco }}</td>
                                        <td style="text-align: right">{{ $lancamento->abril }}</td>
                                        <td style="text-align: right">{{ $lancamento->maio }}</td>
                                        <td style="text-align: right">{{ $lancamento->junho }}</td>
                                        <td style="text-align: right">{{ $lancamento->julho }}</td>
                                        <td style="text-align: right">{{ $lancamento->agosto }}</td>
                                        <td style="text-align: right">{{ $lancamento->setembro }}</td>
                                        <td style="text-align: right">{{ $lancamento->outubro }}</td>
                                        <td style="text-align: right">{{ $lancamento->novembro }}</td>
                                        <td style="text-align: right">{{ $lancamento->dezembro }}</td>
                                    </tr>
                                    @endforeach
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

        $('#btn_relatorio').on('click', function(event) {
            var dataAno = $('#dtano').val();
            var igreja = $('#igreja_id').val();

            // Verificar se a data está preenchida
            if (!dataAno || !igreja) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos.');
            } else {
                // Preencher e submeter o formulário oculto
                $('#report_dtano').val(dataAno);
                $('#report_igreja_id').val(igreja);
                $('#report_form').submit();
            }
        });

        $('#filter_form').submit(function(event) {
            var dataAno = $('#dtano').val();
            var igreja = $('#igreja_id').val();

            // Verificar se a data está preenchida
            if (!dataAno || !igreja) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos.');
            }
        });
    });
</script>
@endsection
@endsection