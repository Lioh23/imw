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
                        <h4>Novo Registro de Saída</h4>
                    </div>
                </div>
            </div>

            <form action="{{ route('financeiro.saida.store') }}" method="POST" class="widget-content widget-content-area">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="caixa_id">* Caixa</label>
                        <select class="form-control @error('caixa_id') is-invalid @enderror" id="caixa_id" name="caixa_id" required>
                            <option value="" hidden disabled>Selecione</option>
                            @foreach ($caixas as $caixa)
                                @if ($caixa->id == old('caixa_id'))
                                    <option value="{{ $caixa->id }}" selected>{{ $caixa->descricao }}</option>
                                @else
                                    <option value="{{ $caixa->id }}">{{ $caixa->descricao }}</option>
                                @endif
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
                            <option value="" hidden selected disabled>Selecione</option>
                            @foreach ($planoContas as $pc)
                                <option {{ !$pc->selecionavel ? 'disabled' : '' }} value="{{ $pc->id }}">
                                    {{ $pc->numeracao }} - {{ $pc->nome }}</option>
                            @endforeach
                        </select>
                        @error('pai')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="valor">* Valor</label>
                        <input type="text" class="form-control @error('valor') is-invalid @enderror" id="valor"
                            name="valor" required autofocus>
                        @error('valor')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="data_movimento">* Data do Movimento</label>
                        <input type="date" class="form-control @error('data_movimento') is-invalid @enderror"
                            id="data_movimento" name="data_movimento" value="{{ old('data_movimento', date('Y-m-d')) }}"
                            required>
                        @error('data_movimento')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="tipo_pagante_favorecido_id">* Tipo do Pagante/Beneficiário</label>
                        <select class="form-control @error('tipo_pagante_favorecido_id') is-invalid @enderror"
                            id="tipo_pagante_favorecido_id" name="tipo_pagante_favorecido_id" required>
                            <option value="" selected disabled hidden>Selecione</option>
                            @foreach ($tiposPagantesFavorecidos as $tipoPaganteFavorecido)
                                <option value="{{ $tipoPaganteFavorecido->id }}"
                                    {{ old('tipo_pagante_favorecido_id') == $tipoPaganteFavorecido->id ? 'selected' : '' }}>
                                    {{ $tipoPaganteFavorecido->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_pagante_favorecido_id')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4 d-none" id="show_pagante_favorecido">
                    <div class="col-12">
                        <label for="pagante_favorecido">Pagante/Beneficiário</label>
                        <input type="text" class="form-control @error('pagante_favorecido') is-invalid @enderror"
                            id="pagante_favorecido" name="pagante_favorecido" value="{{ old('pagante_favorecido') }}">

                        @error('pagante_favorecido')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label for="descricao">* Descrição</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao"
                            value="{{ old('descricao') }}" rows="3" required></textarea>
                        @error('descricao')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4 justify-content-center">
                    <button type="submit" title="Salvar nova movimentação de entrada" class="btn btn-success btn-lg ml-4">
                        <x-bx-save /> Salvar
                    </button>
                </div>
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

        // evento de exibição do descritivo do pagante/favorecido
        $('#tipo_pagante_favorecido_id').change(function() {
            var tipoPaganteFavorecido = this.value;

            if (tipoPaganteFavorecido == 1) {
                // Exibir o campo para membros
                $('#show_pagante_favorecido').removeClass('d-none');

                if ($('#pagante_favorecido').data('select2')) {
                    $('#pagante_favorecido').select2('destroy').empty();
                }

                // Criar o select2 para membros
                $('#pagante_favorecido').select2({
                    data: {!! json_encode($membros) !!}.map(function(membro) {
                        return {
                            id: membro.id,
                            text: membro.nome
                        };
                    }),
                    placeholder: 'Selecione'
                }).on('select2:select', function(e) {
                    var data = e.params.data;
                    $('#pagante_favorecido').val(data.id); // atribuir o valor selecionado ao input
                }).prop('required', true); // Adicionar required

            } else if (tipoPaganteFavorecido == 2) {
                // Exibir o campo para fornecedores
                $('#show_pagante_favorecido').removeClass('d-none');

                if ($('#pagante_favorecido').data('select2')) {
                    $('#pagante_favorecido').select2('destroy').empty();
                }

                // Criar o select2 para fornecedores
                $('#pagante_favorecido').select2({
                    data: {!! json_encode($fornecedores) !!}.map(function(fornecedor) {
                        return {
                            id: fornecedor.id,
                            text: fornecedor.nome
                        };
                    }),
                    placeholder: 'Selecione'
                }).on('select2:select', function(e) {
                    var data = e.params.data;
                    $('#pagante_favorecido').val(data.id); // atribuir o valor selecionado ao input
                }).prop('required', true); // Adicionar required

            } else if (tipoPaganteFavorecido == 3) {
                // Exibir o campo para clérigos
                $('#show_pagante_favorecido').removeClass('d-none');

                if ($('#pagante_favorecido').data('select2')) {
                    $('#pagante_favorecido').select2('destroy').empty();
                }

                // Criar o select2 para clérigos
                $('#pagante_favorecido').select2({
                    data: {!! json_encode($clerigos) !!}.map(function(clerigo) {
                        return {
                            id: clerigo.id,
                            text: clerigo.nome
                        };
                    }),
                    placeholder: 'Selecione'
                }).on('select2:select', function(e) {
                    var data = e.params.data;
                    $('#pagante_favorecido').val(data.id); // atribuir o valor selecionado ao input
                }).prop('required', true); // Adicionar required

            } else {
                $('#show_pagante_favorecido').removeClass('d-none');
                $('#pagante_favorecido').select2('destroy').empty();

                // Mostrar o campo input de texto normal
                $('#pagante_favorecido').replaceWith(
                    '<input type="text" class="form-control @error('pagante_favorecido') is-invalid @enderror" id="pagante_favorecido" name="pagante_favorecido" value="{{ old('pagante_favorecido') }}">'
                );

                // Remover required
                $('#pagante_favorecido').prop('required', false);
            }
        });
    </script>
@endsection
