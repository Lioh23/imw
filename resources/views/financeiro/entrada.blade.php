@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Movimento de Caixa', 'url' => '/financeiro/movimento-caixa', 'active' => false],
        ['text' => 'Entrada', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('content')

<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Novo Registro de Entrada</h4>
                </div>
            </div>
        </div>

        <form  action="{{ route('financeiro.entrada.store') }}" method="POST" class="widget-content widget-content-area">
            @csrf
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="caixa_id">* Caixa</label>
                    <select class="form-control @error('caixa_id') is-invalid @enderror" id="caixa_id" name="caixa_id">
                        <option value="" hidden selected disabled>Selecione</option>
                        @foreach ($caixas as $caixa)
                            <option value="{{ $caixa->id }}">{{ $caixa->descricao }}</option>
                        @endforeach
                    </select>
                    @error('mae')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="plano_conta_id">* Plano de contas</label>
                    <select class="form-control @error('plano_conta_id') is-invalid @enderror" id="plano_conta_id" name="plano_conta_id">
                        <option value="" hidden selected disabled>Selecione</option>
                        @foreach ($planoContas as $pc)
                            <option {{ !$pc->selecionavel ? 'disabled' : '' }} value="{{ $pc->id }}">{{ $pc->numeracao}} - {{ $pc->nome }}</option>
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
                    <input type="text" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{ old('valor') }}" >
                    @error('valor')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="data_movimento">* Data do Movimento</label>
                    <input type="date" class="form-control @error('data_movimento') is-invalid @enderror" id="data_movimento" name="data_movimento" value="{{ old('data_movimento', date('Y-m-d')) }}" >
                    @error('data_movimento')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="tipo_pagante_favorecido_id">Tipo do Pagante/Beneficiário</label>
                    <select class="form-control @error('tipo_pagante_favorecido_id') is-invalid @enderror" id="tipo_pagante_favorecido_id" name="tipo_pagante_favorecido_id">
                        <option value="" selected>Selecione</option>
                        @foreach ($tiposPagantesFavorecidos as $tipoPaganteFavorecido)
                            <option value="{{ $tipoPaganteFavorecido->id }}" {{ old('tipo_pagante_favorecido_id') == $tipoPaganteFavorecido->id ? 'selected' : '' }}>
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
                    <input type="text" class="form-control @error('pagante_favorecido') is-invalid @enderror" id="pagante_favorecido" name="pagante_favorecido" value="{{ old('pagante_favorecido') }}" >
                    
                    @error('pagante_favorecido')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label for="descricao">* Descrição</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" value="{{ old('descricao') }}" rows="3"></textarea>
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
        $('#valor').mask('0.000.000.000,00', { reverse: true })
    
        // evento de exibição do descritivo do pagante/favorecido
        $('#tipo_pagante_favorecido_id').change(function () {
            if (this.value) {
                $('#show_pagante_favorecido').removeClass('d-none');
                $('#pagante_favorecido').val('')
            } else {
                $('#show_pagante_favorecido').addClass('d-none');
                $('#pagante_favorecido').val('')
            }
        })
    </script>
@endsection
