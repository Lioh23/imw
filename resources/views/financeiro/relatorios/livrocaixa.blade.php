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
                            @foreach ($caixas as $caixa)
                                <option value="{{ $caixa->id }}"
                                    {{ request()->input('caixa_id') == $caixa->id ? 'selected' : '' }}>
                                    {{ $caixa->descricao }}
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