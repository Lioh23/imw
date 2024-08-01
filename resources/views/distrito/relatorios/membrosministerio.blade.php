@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Relatórios Distritais', 'url' => '#', 'active' => false],
    ['text' => 'Membros por Ministério', 'url' => '#', 'active' => true],
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
                    <h4>Membros por Ministério</h4>
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
            <form id="report_form" action="{{ url('distrito/relatorio/membrosministerio/pdf') }}" method="POST" target="_blank" style="display: none;">
                @csrf
                <input type="hidden" name="dtano" id="report_dtano">
                <input type="hidden" name="igrejas" id="report_igrejas">
            </form>
        </div>
    </div>
</div>

@if(request()->input('dtano'))
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <!-- Conteúdo -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mt-3">MEMBROS POR MINISTÉRIO - {{ session('session_perfil')->instituicao_nome }}</h6>
                            <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="300" style="text-align: left">IGREJA</th>
                                        <th width="50" style="text-align: right">KIDS</th>
                                        <th width="50" style="text-align: right">CONEXÃO</th>
                                        <th width="50" style="text-align: right">FIRE</th>
                                        <th width="50" style="text-align: right">MOVE</th>
                                        <th width="50" style="text-align: right">HOMENS</th>
                                        <th width="50" style="text-align: right">Mulheres</th>
                                        <th width="50" style="text-align: right">60+</th>
                                        <th width="50" style="text-align: right">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $totalKids = 0;
                                    $totalConexao = 0;
                                    $totalFire = 0;
                                    $totalMove = 0;
                                    $totalHomens = 0;
                                    $totalMulheres = 0;
                                    $total60 = 0;
                                    $totalGeral = 0;
                                    @endphp
                                    @foreach($lancamentos as $lancamento)
                                    @php
                                    $totalKids += $lancamento->Kids;
                                    $totalConexao += $lancamento->Conexao;
                                    $totalFire += $lancamento->Fire;
                                    $totalMove += $lancamento->Move;
                                    $totalHomens += $lancamento->Homens;
                                    $totalMulheres += $lancamento->Mulheres;
                                    $total60 += $lancamento->{'60+'};
                                    $totalGeral += $lancamento->Kids + $lancamento->Conexao + $lancamento->Fire + $lancamento->Move + $lancamento->Homens + $lancamento->Mulheres + $lancamento->{'60+'};
                                    @endphp
                                    <tr>
                                        <td style="text-align: left">{{ $lancamento->nome }}</td>
                                        <td style="text-align: right">{{ $lancamento->Kids }}</td>
                                        <td style="text-align: right">{{ $lancamento->Conexao }}</td>
                                        <td style="text-align: right">{{ $lancamento->Fire }}</td>
                                        <td style="text-align: right">{{ $lancamento->Move }}</td>
                                        <td style="text-align: right">{{ $lancamento->Homens }}</td>
                                        <td style="text-align: right">{{ $lancamento->Mulheres }}</td>
                                        <td style="text-align: right">{{ $lancamento->{'60+'} }}</td>
                                        <td style="text-align: right">{{ $lancamento->Kids + $lancamento->Conexao + $lancamento->Fire + $lancamento->Move + $lancamento->Homens + $lancamento->Mulheres + $lancamento->{'60+'} }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="thead-dark">
                                        <th style="text-align: left">ROL ATUAL [{{request()->input('dtano')}}]</th>
                                        <th style="text-align: right">{{ $totalKids }}</th>
                                        <th style="text-align: right">{{ $totalConexao }}</th>
                                        <th style="text-align: right">{{ $totalFire }}</th>
                                        <th style="text-align: right">{{ $totalMove }}</th>
                                        <th style="text-align: right">{{ $totalHomens }}</th>
                                        <th style="text-align: right">{{ $totalMulheres }}</th>
                                        <th style="text-align: right">{{ $total60 }}</th>
                                        <th style="text-align: right">{{ $totalGeral }}</th>
                                    </tr>
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

            // Verificar se a data está preenchida
            if (!dataAno) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos.');
            } else {
                // Preencher e submeter o formulário oculto
                $('#report_dtano').val(dataAno);
                $('#report_form').submit();
            }
        });

        $('#filter_form').submit(function(event) {
            var dataAno = $('#dtano').val();

            // Verificar se a data está preenchida
            if (!dataAno) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos.');
            }
        });
    });
</script>
@endsection
@endsection