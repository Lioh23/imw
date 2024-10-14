@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Instituições', 'url' => '/', 'active' => false],
        ['text' => 'Secretarias', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection
@section('extras-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }

        .modal-xl {
            max-width: 90% !important;
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
    <div class="container-fluid">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Dados do usuário</h4>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class=" d-flex flex-column align-items-start justify-content-start m-0 p-0" style="list-style: none">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="py-4" method="POST" action="{{ route('instituicoes.secretarias.store') }}">
            @csrf

            <div class="row">
                <div class="col-12 mt-3 col-md-6">
                    <label for="nome">Nome*</label>
                    <input class="form-control" type="text" id="nome" name="nome">
                </div>
                <div class="col-12 mt-3 col-md-3">
                    <label for="cnpj">CNPJ*</label>
                    <input class="form-control" type="text" id="cnpj" name="cnpj">

                </div>

                <div class="col-12 mt-3 col-md-3">
                    <label for="data_abertura">Data de Abertura*</label>
                    <input class="form-control" type="text" id="data_abertura" name="data_abertura">
                </div>
            </div>

            <div class="row">
                {{-- <div class="col-12 mt-3 col-md-6">
                    <label for="data_abertura">Data de Fechamento*</label>
                    <input class="form-control" type="text" id="data_abertura" name="data_abertura">
                </div> --}}
                {{-- <div class="col-12 mt-3 col-md-6">
                    <label for="instituicao_pai_id">Instituição Pai*</label>
                    <select class="form-control" type="text" id="instituicao_pai_id" name="instituicao_pai_id">
                        @foreach ($instituicao_pai_id as $row)
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
                        @endforeach

                    </select>
                </div> --}}

            </div>
            <div class="col-12 mt-3 col-md-6">
                <div class="col-12 mt-3 col-md-6">
                    <input type="hidden" id="tipo_instituicao_id" value="9" name="tipo_instituicao_id">
                </div>


            </div>
            <div class="col-12 mt-3 col-md-6">

                <input type="hidden" id="instituicao_pai_id" value="23" name="instituicao_pai_id">
            </div>

            <div class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cep">CEP*</label>
                        <input type="text" class="form-control" type="text" id="cep" name="cep">

                    </div>

                    <div class="col-12 mt-3 col-md-8">
                        <label for="endereco">Logradouro (Rua/Av/Beco)*</label>
                        <input type="text" class="form-control" id="endereco" name="endereco">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="numero">Numero</label>
                        <input type="number" class="form-control" id="numero" name="numero">

                    </div>

                    <div class="col-12 mt-3 col-md-4">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control"id="bairro" name="bairro">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="complemento">Complemento</label>
                        <textarea class="form-control w-100" id="complemento" name="complemento" rows="4"></textarea>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="uf">Estado</label>
                        <input type="text" class="form-control" id="uf" name="uf">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-3">
                        <label for="pais">País</label>
                        <input type="text" class="form-control" type="text" id="pais" name="pais">
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="pais">País</label>
                        <input type="text" class="form-control" type="text" id="pais" name="pais">
                    </div>
                    <div class="col-12 mt-3 col-md-4 d-flex align-items-end mt-3" style="gap:10px">
                        <div>
                            <input type="text" maxlength="3" class="form-control p-2" id="ddd" name="ddd"
                                style="max-width: 55px" placeholder="DDD">
                        </div>
                        <div>
                            <label for="telefone">Celular/Telefone</label>
                            <input type="text" class="form-control" type="text" id="telefone" name="telefone">
                        </div>
                    </div>

                </div>
            </div>
            <button class="btn btn-primary my-4">Salvar</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            $('#cep').mask('00000000');
            $('#telefone').mask('00000-0000');
            $('#cnpj').mask('00.000.000/0000-00', {
                reverse: true
            });
            $('#data_abertura').mask('00/00/0000');
        })
    </script>
@endsection
