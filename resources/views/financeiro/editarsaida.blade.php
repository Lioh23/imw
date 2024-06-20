@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Movimento de Caixa', 'url' => '/financeiro/movimento-caixa', 'active' => false],
        ['text' => 'Saída', 'url' => '#', 'active' => true],
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
                        <h4>Editar Registro de Saída</h4>
                    </div>
                </div>
            </div>

            <form action="{{ route('financeiro.saida.update', $saida->id) }}" method="POST"
                class="widget-content widget-content-area" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="caixa_id">* Caixa</label>
                        <select class="form-control @error('caixa_id') is-invalid @enderror" id="caixa_id" name="caixa_id"
                            required>
                            <option value="" hidden disabled>Selecione</option>
                            @foreach ($caixas as $caixa)
                                <option value="{{ $caixa->id }}" {{ $saida->caixa_id == $caixa->id ? 'selected' : '' }}>
                                    {{ $caixa->descricao }}
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
                                    {{ $saida->plano_conta_id == $pc->id ? 'selected' : '' }}>
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
                            name="valor" value="{{ $saida->valor }}" required autofocus>
                        @error('valor')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="data_movimento">* Data do Movimento</label>
                        <input type="date" class="form-control @error('data_movimento') is-invalid @enderror"
                            id="data_movimento" name="data_movimento" value="{{ $saida->data_movimento }}" required>
                        @error('data_movimento')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="tipo_pagante_favorecido_id">* Tipo de Beneficiário</label>
                        <select class="form-control @error('tipo_pagante_favorecido_id') is-invalid @enderror"
                            id="tipo_pagante_favorecido_id" name="tipo_pagante_favorecido_id" required>
                            <option value="" hidden>Selecione</option>
                            @foreach ($tiposPagantesFavorecidos as $tipoPaganteFavorecido)
                                @if ($tipoPaganteFavorecido->id == 2 || $tipoPaganteFavorecido->id == 3 || $tipoPaganteFavorecido->id == 99)
                                    <option value="{{ $tipoPaganteFavorecido->id }}"
                                        {{ $saida->tipo_pagante_favorecido_id == $tipoPaganteFavorecido->id ? 'selected' : '' }}>
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
                        <label for="pagante_favorecido">Beneficiário</label>
                        <input type="text" class="form-control @error('pagante_favorecido') is-invalid @enderror"
                            id="pagante_favorecido" name="pagante_favorecido"
                            value="{{ $saida->pagante_favorecido ?? old('pagante_favorecido') }}">

                        @error('pagante_favorecido')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

           <div class="row mb-4">
            <div class="col-12">
                <label for="descricao">* Descrição</label>
                <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3"
                    >{{ $saida->descricao }}</textarea>
                @error('descricao')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Anexos -->
        <!-- Anexos existentes -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h4><b>Anexos</b></h4>
                @php
                    $x = 0;
                @endphp
                @foreach ($anexos as $index => $anexo)
                    <div class="mb-3">
                        <label for="anexo1">Anexo {{ ++$x }}</label><br>
                        <a href="{{ asset($anexo['url']) }}" target="_blank">{{ $anexo['nome'] }}</a>
                        <input type="file" class="mb-3 form-control-file @error('anexo' . $index) is-invalid @enderror"
                            id="anexo{{ $index }}" name="anexo{{ $index }}">
                        <label for="descricao_anexo1">Descrição do Anexo {{ $x }}</label>
                        <textarea class="form-control mt-2" name="descricao_anexo[{{ $anexo['nome'] }}]" rows="1">{{ $anexo['nome'] }}</textarea>
                        @error('anexo' . $index)
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <!-- Campos de upload adicionais, se necessário -->
                @for ($i = count($anexos), $x = $i; $i < 3; $i++)
                    <div class="mb-3">
                        <label for="anexo1">Anexo {{ ++$x }}</label><br>
                        <input type="file" class="mb-3 form-control-file @error('anexo' . $i) is-invalid @enderror"
                            id="anexo{{ $i }}" name="anexo{{ $i }}">
                        <label for="descricao_anexo1">Descrição do Anexo {{ $x }}</label>
                        <textarea class="form-control mt-2" name="descricao_anexo[{{ $i }}]" rows="1"></textarea>
                        @error('anexo' . $i)
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endfor
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
        });

        $('#tipo_pagante_favorecido_id').change(function() {
            var tipoPaganteFavorecido = this.value;

            $('#show_pagante_favorecido').removeClass('d-none');

            if ($('#pagante_favorecido').data('select2')) {
                $('#pagante_favorecido').select2('destroy').empty();
            }

            if (tipoPaganteFavorecido == 2) {
                var fornecedores = {!! json_encode($fornecedores) !!};
                var selectHtml =
                    `<div class="col-12">
                        <label for="pagante_favorecido">Beneficiário</label>
                        <select class="form-control" id="   " name="pagante_favorecido" required><option value="" disabled>Selecione</option>
                            @error('pagante_favorecido')
                        <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div> `;

                fornecedores.forEach(function(fornecedor) {
                    selectHtml += '<option value="' + fornecedor.id + '"';
                    if (fornecedor.id == {{ $saida->fornecedores_id ?? 0 }}) {
                        selectHtml += ' selected';
                    }
                    selectHtml += '>' + fornecedor.nome + '</option>';
                });

                selectHtml += '</select>';

                $('#show_pagante_favorecido').html(selectHtml);
            } else if (tipoPaganteFavorecido == 3) {
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
                    if (clerigo.id == {{ $saida->clerigo_id ?? 0 }}) {
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
