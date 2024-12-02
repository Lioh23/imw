@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Instituições', 'url' => '/instituicoes-regiao', 'active' => false],
        ['text' => 'Editar', 'url' => '#', 'active' => true],
    ]">
    </x-breadcrumb>
@endsection
@section('extras-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important
        }

        .modal-xl {
            max-width: 90% !important
                /* Define que o modal ocupe 90% da largura da página */
        }
    </style>
@endsection

@section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
@endsection

@include('extras.alerts')

@section('content')
    <div class="container-fluid" style="background: #fff">
        <div class="widget-header">
            <h4>Dados do usuário</h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="d-flex flex-column align-items-start justify-content-start m-0 p-0" style="list-style: none">
                    <li>{{ $errors->first() }}</li>
                </ul>
            </div>
        @endif

        <form class="py-2 px-3" method="POST"
            action="{{ route('instituicoes-regiao.update', ['id' => $instituicao['id']]) }}">
            @csrf

            <div class="row">
                <div class="col-12 mt-3 col-md-6">
                    <label for="nome"><span>*</span> Nome</label>
                    <input class="form-control @error('nome') is-invalid @enderror" type="text" id="nome"
                        name="nome" value="{{ old('nome', $instituicao['nome']) }}">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 mt-3 col-md-3">
                    <label for="cnpj"><span>*</span> CNPJ</label>
                    <input class="form-control @error('cnpj') is-invalid @enderror" type="text" id="cnpj"
                        name="cnpj" value="{{ old('cnpj', $instituicao['cnpj']) }}">
                    @error('cnpj')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-3 col-md-3">
                    <label for="data_abertura"><span>*</span> Data de Abertura</label>
                    <input class="form-control @error('data_abertura') is-invalid @enderror" type="text"
                        id="data_abertura" name="data_abertura"
                        value="{{ old('data_abertura', \Carbon\Carbon::parse($instituicao['data_abertura'])->format('d/m/Y')) }}">
                    @error('data_abertura')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="regiao_id" id="regiao_id" value="23">
            </div>

            <div class="row">
                <div class="col-12 mt-3 col-md-4">
                    <label for="tipo_instituicao_id"><span>*</span> Tipo da Instituição</label>
                    <select name="tipo_instituicao_id" id="tipo_instituicao_id"
                        class="form-control @error('tipo_instituicao_id') is-invalid @enderror">
                        <option value="1"
                            {{ old('tipo_instituicao_id', $instituicao['tipo_instituicao_id']) == 1 ? 'selected' : '' }}>
                            Igreja</option>
                        <option value="2"
                            {{ old('tipo_instituicao_id', $instituicao['tipo_instituicao_id']) == 2 ? 'selected' : '' }}>
                            Distrito</option>
                        <option value="5"
                            {{ old('tipo_instituicao_id', $instituicao['tipo_instituicao_id']) == 5 ? 'selected' : '' }}>
                            Secretaria Regional</option>
                    </select>
                    @error('tipo_instituicao_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 mt-3 col-md-4">
                    <label for="instituicao_pai_id"><span>*</span> Instituição Pai</label>
                    <select name="instituicao_pai_id" id="instituicao_pai_id"
                        class="form-control @error('instituicao_pai_id') is-invalid @enderror">
                        <option value="{{ old('instituicao_pai_id', $instituicao['instituicao_pai_id']) }}">
                            {{ $instituicao['instituicao_pai_id'] }}</option>
                        <option value="2">Distrito</option>
                    </select>
                    @error('instituicao_pai_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cep"><span>*</span> CEP</label>
                        <input class="form-control @error('cep') is-invalid @enderror" type="text" id="cep"
                            name="cep" value="{{ old('cep', $instituicao['cep']) }}">
                        @error('cep')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-3 col-md-8">
                        <label for="endereco"><span>*</span> Logradouro (Rua/Av/Beco)</label>
                        <input class="form-control @error('endereco') is-invalid @enderror" type="text" id="endereco"
                            name="endereco" value="{{ old('endereco', $instituicao['endereco']) }}">
                        @error('endereco')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="numero">Número</label>
                        <input class="form-control @error('numero') is-invalid @enderror" type="number" id="numero"
                            name="numero" value="{{ old('numero', $instituicao['numero']) }}">
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-3 col-md-4">
                        <label for="bairro"><span>*</span> Bairro</label>
                        <input class="form-control @error('bairro') is-invalid @enderror" type="text" id="bairro"
                            name="bairro" value="{{ old('bairro', $instituicao['bairro']) }}">
                        @error('bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="complemento">Complemento</label>
                        <textarea class="form-control @error('complemento') is-invalid @enderror" id="complemento" name="complemento"
                            rows="4">{{ old('complemento', $instituicao['complemento']) }}</textarea>
                        @error('complemento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="cidade">Cidade</label>
                        <input class="form-control @error('cidade') is-invalid @enderror" type="text" id="cidade"
                            name="cidade" value="{{ old('cidade', $instituicao['cidade']) }}">
                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="uf"><span>*</span> Estado</label>
                        <select class="form-control @error('uf') is-invalid @enderror" id="uf" name="uf">
                            <option value="">Selecione</option>
                            @foreach ($ufs as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('uf', $instituicao['uf'] ?? '') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('uf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-3">
                        <label for="pais"><span>*</span> País</label>
                        <input class="form-control @error('pais') is-invalid @enderror" type="text" id="pais"
                            name="pais" value="{{ old('pais', $instituicao['pais']) }}">
                        @error('pais')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-3 col-md-4 d-flex align-items-end mt-3" style="gap:10px">
                        <div>
                            <input type="text" maxlength="3"
                                class="form-control p-2 @error('ddd') is-invalid @enderror" id="ddd"
                                name="ddd" style="max-width: 55px" placeholder="DDD"
                                value="{{ old('ddd', $instituicao['ddd']) }}">
                            @error('ddd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="telefone"><span>*</span> Celular/Telefone</label>
                            <input class="form-control @error('telefone') is-invalid @enderror" type="text"
                                id="telefone" name="telefone" value="{{ old('telefone', $instituicao['telefone']) }}">
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary my-4">Salvar</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            $('#cep').mask('00000000')
            $('#telefone').mask('00000-0000')
            $('#cnpj').mask('00.000.000/0000-00', {
                reverse: true
            })
            $('#data_abertura').mask('00/00/0000')
        })
    </script>
    <script src="{{ asset('theme/plugins/fullcalendar/moment.min.js') }}"></script>
    <script>
        // Funcionalidade de preenchimento automático de endereço pelo CEP
        $('#cep').blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep.length != 8) {
                return;
            }
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                if (!("erro" in data)) {
                    $('#endereco').val(data.logradouro);
                    // Preencha os outros campos de endereço aqui, se necessário
                    $('#bairro').val(data.bairro);
                    $('#cidade').val(data.localidade);
                    $('#estado').val(data.uf);
                } else {
                    toastr.warning('CEP não encontrado.');
                }
            });
        });
    </script>
@endsection
