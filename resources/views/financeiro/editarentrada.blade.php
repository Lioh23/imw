@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Movimento de Caixa', 'url' => '/financeiro/movimento-caixa', 'active' => false],
        ['text' => 'Editar Entrada', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/i18n/pt-BR.js"></script>
    <style>
        .select2-selection__rendered {
            line-height: 50px !important;
            padding-left: 25px !important;
            font-family: 'Nunito', sans-serif;
        }

        .select2-container .select2-selection--single {
            height: 50px !important;
            font-weight: 600;
            font-family: 'Nunito', sans-serif;
        }

        .select2-selection__arrow {
            height: 50px !important;
            font-family: 'Nunito', sans-serif;
        }
    </style>
@endsection

@section('content')
    @include('extras.alerts')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Editar Registro de Entrada</h4>
                    </div>
                </div>
            </div>

           
            <form action="{{ route('financeiro.entrada.update', $entrada->id) }}" method="POST"
                class="widget-content widget-content-area">
                @csrf
                @method('PUT') <!-- Método para atualizar o registro -->

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="caixa_id">* Caixa</label>
                        <select class="form-control @error('caixa_id') is-invalid @enderror" id="caixa_id" name="caixa_id"
                            required>
                            <option value="" hidden disabled>Selecione</option>
                            @foreach ($caixas as $caixa)
                                <option value="{{ $caixa->id }}"
                                    {{ $entrada->caixa_id == $caixa->id ? 'selected' : '' }}>{{ $caixa->descricao }}
                                </option>
                            @endforeach
                        </select>
                        @error('caixa_id')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="plano_conta_id">* Plano de contas</label>
                        <select class="form-control @error('plano_conta_id') is-invalid @enderror" id="plano_conta_id"
                            name="plano_conta_id" required>
                            <option value="" hidden disabled>Selecione</option>
                            @foreach ($planoContas as $pc)
                                <option {{ !$pc->selecionavel ? 'disabled' : '' }} value="{{ $pc->id }}"
                                    {{ $entrada->plano_conta_id == $pc->id ? 'selected' : '' }}>
                                    {{ $pc->numeracao }} - {{ $pc->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('plano_conta_id')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="valor">* Valor</label>
                        <input type="text" class="form-control @error('valor') is-invalid @enderror" id="valor"
                            name="valor" value="{{ $entrada->valor }}" required autofocus>
                        @error('valor')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="data_movimento">* Data do Movimento</label>
                        <input type="date" class="form-control @error('data_movimento') is-invalid @enderror"
                            id="data_movimento" name="data_movimento"
                            value="{{ old('data_movimento', \Carbon\Carbon::parse($entrada->data_movimento)->format('Y-m-d')) }}"
                            required>

                        @error('data_movimento')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="tipo_pagante_favorecido_id">* Tipo do Pagante</label>
                        <select class="form-control @error('tipo_pagante_favorecido_id') is-invalid @enderror"
                            id="tipo_pagante_favorecido_id" name="tipo_pagante_favorecido_id" required>
                            <option value="" hidden>Selecione</option>
                            @foreach ($tiposPagantesFavorecidos as $tipoPaganteFavorecido)
                                @if ($tipoPaganteFavorecido->id == 1 || $tipoPaganteFavorecido->id == 3 || $tipoPaganteFavorecido->id == 99)
                                    <option value="{{ $tipoPaganteFavorecido->id }}"
                                        {{ $entrada->tipo_pagante_favorecido_id == $tipoPaganteFavorecido->id ? 'selected' : '' }}>
                                        {{ $tipoPaganteFavorecido->nome }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('tipo_pagante_favorecido_id')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="row mb-4" id="show_pagante_favorecido">
                    <div class="col-6">
                        <label for="pagante_favorecido">Pagante</label>
                        <input type="text" class="form-control @error('pagante_favorecido') is-invalid @enderror"
                            id="pagante_favorecido" name="pagante_favorecido"
                            value="{{ $entrada->pagante_favorecido ?? old('pagante_favorecido') }}">

                        @error('pagante_favorecido')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3"
                            >{{ $entrada->descricao }}</textarea>
                        @error('descricao')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4 justify-content-center">
                    <button type="submit" title="Atualizar movimentação de entrada" class="btn btn-primary btn-lg ml-4">
                        <x-bx-save /> Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('extras-scripts')
<script>
        // máscara de valor
        $('#valor').mask('0.000.000.000,00', {
            reverse: true
        });
        // definir o idioma padrão do Select2 para português
        $.fn.select2.defaults.set("language", "pt-BR");
        $('#caixa_id').select2({
           placeholder: 'Selecione',
            allowClear: true
        }); 

    
        $('#plano_conta_id').select2({
           placeholder: 'Selecione',
            allowClear: true
        }); 

        $(document).ready(function() {
            $('#tipo_pagante_favorecido_id').trigger('change'); // disparar o evento change ao carregar a página

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
                dateFormat: 'dd/mm/yy',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

            // Inicializar o Datepicker
            $("#ano_mes").datepicker({
                dateFormat: "mm/yy", // Formato do calendário (mês/ano)
                changeMonth: true, // Permitir a seleção do mês
                changeYear: true, // Permitir a seleção do ano
                showButtonPanel: true,
                language: 'pt-BR', // Definir o idioma como português
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker("setDate", new Date(year, month, 1));
                }
            }).focus(function() {
                $(".ui-datepicker-calendar").hide();
            });
        });

        $('#tipo_pagante_favorecido_id').change(function() {
            var tipoPaganteFavorecido = this.value;

            $('#show_pagante_favorecido').removeClass('d-none');

            if ($('#pagante_favorecido').data('select2')) {
                $('#pagante_favorecido').select2('destroy').empty();
            }

            if (tipoPaganteFavorecido == 1) {
                var membros = {!! json_encode($membros) !!};
                var membroId = '{{ $entrada->membro_id ?? 'null' }}';
                var selectHtml =
                    `<div class="col-6">
                        <label for="pagante_favorecido">Beneficiário</label>
                        <select class="form-control" id="pagante_favorecido" name="pagante_favorecido">
                            <option value="" disabled${membroId === 'null' ? ' selected' : ''}>Selecione</option>
                    `;

                membros.forEach(membro => {
                    selectHtml += `<option value="${membro.id}"${membro.id == membroId ? ' selected' : ''}>${membro.nome}</option>`;
                });

                selectHtml += `@error('pagante_favorecido')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                             </select>
                             </div>
                             
                    <div class="col-6">
                        <label for="ano_mes">Mês/Ano</label>
                        <input type="text" class="form-control @error('ano_mes') is-invalid @enderror" id="ano_mes" name="ano_mes" value="{{ old('data_ano_mes', \Carbon\Carbon::parse($entrada->data_ano_mes)->format('m/Y')) }}" placeholder="mm/yyyy" required>
                    </div>
                             `;

                $('#show_pagante_favorecido').html(selectHtml);
                $('#pagante_favorecido').select2({
                    placeholder: 'Selecione',
                    allowClear: true
                });
            }   else if (tipoPaganteFavorecido == 3) {
                        var clerigos = {!! json_encode($clerigos) !!};
                        var selectHtml =
                            `<div class="col-12">
                                <label for="pagante_favorecido">Beneficiário</label>
                                <select class="form-control" id="pagante_favorecido" name="pagante_favorecido" required><option value="" disabled>Selecione</option>
                                    @error('pagante_favorecido')
                                <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>`;

                        clerigos.forEach(function(clerigo) {
                            selectHtml += '<option value="' + clerigo.id + '"';
                            if (clerigo.id == {{ $entrada->clerigo_id ?? 0 }}) {
                                selectHtml += ' selected';
                            }
                            selectHtml += '>' + clerigo.nome + '</option>';
                        });

                        selectHtml += '</select>';

                        $('#show_pagante_favorecido').html(selectHtml);
                    } else {
                        var fieldValue = '{{ $saida->pagante_favorecido ?? '' }}';
                        var inputHtml =
                            `<div class="col-12">
                                <label for="pagante_favorecido">Beneficiário</label>` +
                                '<input type="text" class="form-control" id="pagante_favorecido" name="pagante_favorecido" value="' +
                                fieldValue + '">' +
                                `@error('pagante_favorecido')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                        @enderror
                            </div>`;

                        $('#show_pagante_favorecido').html(inputHtml);
                    }
                });
    </script>
@endsection




