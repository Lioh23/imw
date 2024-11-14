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
                    <label for="nome"><span class="text-danger">*</span> Nome</label>
                    <input class="form-control" type="text" id="nome" name="nome"
                        value="{{ $instituicao['nome'] }}">
                </div>
                <div class="col-12 mt-3 col-md-3">
                    <label for="cnpj"><span class="text-danger">*</span> CNPJ</label>
                    <input class="form-control" type="text" id="cnpj" name="cnpj"
                        value="{{ $instituicao['cnpj'] }}">
                </div>

                <div class="col-12 mt-3 col-md-3">
                    <label for="data_abertura"><span class="text-danger">*</span> Data de Abertura</label>
                    <input class="form-control" type="text" id="data_abertura" name="data_abertura"
                        value="{{ \Carbon\Carbon::parse($instituicao['data_abertura'])->format('d/m/Y') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-12 mt-3 col-md-4">
                    <label for="tipo_instituicao_id"><span class="text-danger">*</span> Tipo da Instituição</label>
                    <select name="tipo_instituicao_id" id="tipo_instituicao_id" class="form-control">
                        <option value="1" {{ $instituicao['tipo_instituicao_id'] == 1 ? 'selected' : '' }}>Igreja</option>
                        <option value="2" {{ $instituicao['tipo_instituicao_id'] == 2 ? 'selected' : '' }}>Distrito</option>
                        <option value="5" {{ $instituicao['tipo_instituicao_id'] == 5 ? 'selected' : '' }}>Secretaria Regional</option>
                    </select>
                </div>
                <div class="col-12 mt-3 col-md-4">
                    <label for="instituicao_pai_id"><span class="text-danger">*</span> Instituição Pai</label>
                    <select name="instituicao_pai_id" id="instituicao_pai_id" class="form-control">
                        <option value="{{ $instituicao['instituicao_pai_id'] }}">{{ $instituicao['instituicao_pai_id'] }}</option>
                        <option value="2">Distrito</option>
                        <input type="hidden" name="regiao_id" id="regiao_id" value="23">
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cep"><span class="text-danger">*</span> CEP</label>
                        <input type="text" class="form-control" type="text" id="cep" name="cep"
                            value="{{ $instituicao['cep'] }}">
                    </div>

                    <div class="col-12 mt-3 col-md-8">
                        <label for="endereco"><span class="text-danger">*</span> Logradouro (Rua/Av/Beco)</label>
                        <input type="text" class="form-control" type="text" id="endereco" name="endereco"
                            value="{{ $instituicao['endereco'] }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="numero">Número</label>
                        <input type="number" class="form-control" type="text" id="numero" name="numero"
                            value="{{ $instituicao['numero'] }}">
                    </div>

                    <div class="col-12 mt-3 col-md-4">
                        <label for="bairro"><span class="text-danger">*</span>Bairro</label>
                        <input type="text" class="form-control" type="text" id="bairro" name="bairro"
                            value="{{ $instituicao['bairro'] }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="complemento">Complemento</label>
                        <textarea class="form-control w-100" type="text" id="complemento" name="complemento" rows="4">{{ $instituicao['complemento'] }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" type="text" id="cidade" name="cidade"
                            value="{{ $instituicao['cidade'] }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="uf"><span class="text-danger">*</span>Estado</label>
                        <input type="text" class="form-control" type="text" id="uf" name="uf"
                            value="{{ $instituicao['uf'] }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-3">
                        <label for="pais"><span class="text-danger">*</span>País</label>
                        <input type="text" class="form-control" type="text" id="pais" name="pais"
                            value="{{ $instituicao['pais'] }}">
                    </div>

                    <div class="col-12 mt-3 col-md-4 d-flex align-items-end mt-3" style="gap:10px">
                        <div>
                            <input type="text" maxlength="3" class="form-control p-2" id="ddd" name="ddd"
                                style="max-width: 55px" placeholder="DDD" value="{{ $instituicao['ddd'] }}">
                        </div>

                        <div>
                            <label for="telefone"><span class="text-danger">*</span>Celular/Telefone</label>
                            <input type="text" class="form-control" type="text" id="telefone" name="telefone"
                                value="{{ $instituicao['telefone'] }}">
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
@endsection
