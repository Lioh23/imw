@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Clerigos', 'url' => '/clerigos', 'active' => false],
        ['text' => 'Nomeações', 'url' => route('clerigos.nomeacoes', ['id' => $id]), 'active' => false],
        ['text' => 'Novo', 'url' => '#', 'active' => true],
    ]">
    </x-breadcrumb>
@endsection
@section('extras-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/i18n/pt-BR.js"></script>
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

        <form class="py-2 px-3" method="POST" action="{{ route('clerigos.nomeacao.store', ['id' => $id]) }}">
            @csrf

            <div class="row">
                <div class="col-12 mt-3 col-md-4">
                    <label for="funcao_ministerial_id">* Função Ministerial</label>
                    <select class="form-control basic" name="funcao_ministerial_id" id="funcao_ministerial_id"
                        @error('funcao_ministerial_id') is-invalid @enderror>
                        <option value="">Selecione</option>
                        @foreach ($funcoes as $funcao)
                            <option value="{{ $funcao['id'] }}"
                                {{ old('funcao_ministerial_id') == $funcao['id'] ? 'selected' : '' }}>
                                {{ $funcao['funcao'] }}</option>
                        @endforeach
                        </option>
                    </select>
                </div>

                <div class="col-12 mt-3 col-md-4">
                    <label for="data_nomeacao">* Data de Nomeação</label>
                    <input class="form-control" type="text" id="data_nomeacao" name="data_nomeacao"
                        value="{{ old('data_nomeacao') }}" @error('data_nomeacao') is-invalid @enderror>
                </div>

                <div class="col-12 mt-3 col-md-4">
                    <label for="instituicao_id">* Instituição</label>
                    <select class="form-control basic" name="instituicao_id" id="instituicao_id"
                        @error('instituicao_id') is-invalid @enderror>
                        <option value="">Selecione</option>
                        @foreach ($instituicoes_completa as $i)
                            <option value="{{ $i['instituicao'] }}"
                                {{ old('instituicao_id') == $i['instituicao'] ? 'selected' : '' }}>
                                {{ $i['instituicao'] }}({{ $i['instituicao_pai'] }})</option>
                        @endforeach
                        </option>
                    </select>
                </div>
            </div>

            <div class="row">
                <input type="hidden" name="pessoa_id" id="pessoa_id" value="{{ $id }}">
            </div>

            <button class="btn btn-primary my-4">Salvar</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            $('#data_nomeacao').mask('00/00/0000');
        })

        var ss = $(".basic").select2({
            tags: true,
        });

        $.fn.select2.defaults.set("language", "pt-BR");
        $('#instituicao').select2({
            placeholder: 'Selecione',
            allowClear: true
        });
    </script>
@endsection
