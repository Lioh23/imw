@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Clérigos', 'url' => '/clerigos', 'active' => false],
        ['text' => 'Nomeações', 'url' => '/', 'active' => true]
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

    </div>
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Filtros para pesquisa</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <!-- Conteúdo -->
                <div class="card mb-3">
                    <div class="bg-holder d-none d-lg-block bg-card gb-title">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body">
                         <form>
                            <div class="row mb-4">
                                <div class="col-4">
                                    <input type="text" name="search" id="searchInput"
                                        class="form-control form-control-sm" placeholder="Pesquisar...">
                                </div>
                                <div class="col-2">
                                    <select name="status" id="" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="ativo" {{!empty($status) && $status === 'ativo' ? 'selected': ''}}>Ativo</option>
                                        <option value="inativo" {{!empty($status) && $status === 'inativo' ? 'selected': ''}}>Inativo</option>
                                    </select>
                                </div>
                                <div class="col-auto" style="margin-left: -19px;">
                                    <button type="submit" class="btn btn-primary btn-rounded">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Listagem de Registros</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('clerigos.nomeacao.novo', ['pessoa'=> $id])}}" title="Inserir um novo registro"
                                    class="btn btn-primary right btn-rounded"> <svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-plus-square">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                        </rect>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg> Novo </a>
                                <div class="table-responsive">
                                    <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Função ministerial</th>
                                                <th>Data de nomeação</th>
                                                <th>Data de término da nomeação</th>
                                                <th>Instituição</th>
                                                <th width="120px">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nomeacoes as $index => $nomeacao)
                                                <tr>
                                                    <td>
                                                       {{$nomeacao->funcaoMinisterial?->funcao}}
                                                   </td>

                                                    <td>
                                                        {{$nomeacao->data_nomeacao}}
                                                    </td>

                                                    <td>
                                                        {{$nomeacao->data_termino}}
                                                    </td>

                                                    <td>
                                                        {{ $nomeacao->instituicao->nome }}
                                                        {{ $nomeacao->instituicao->instituicaoPai
                                                            ? sprintf('(%s)', $nomeacao->instituicao->instituicaoPai->nome)
                                                            : ''
                                                        }}
                                                    </td>

                                                    <td class="table-action">
                                                        <button type="button" title="Inativar"
                                                            class="btn btn-sm btn-danger btn-rounded btn-confirm-delete bs-tooltip">
                                                            <x-bx-block />
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Conteúdo -->
            </div>
        </div>
    </div>
    <script>
        // Confirmação para apagar (deletar) o clerigo
        $('.btn-confirm-delete').on('click', function() {
            const formId = $(this).data('form-delete-id');
            swal({
                title: 'Deseja realmente inativar esta nomeação?',
                type: 'error',
                showCancelButton: true,
                confirmButtonText: "Inativar",
                confirmButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#3085d6",
                padding: '2em'
            }).then(function(result) {
                // if (result.value) {
                //     document.getElementById(formId).submit();
                // }
            });
        });
    </script>
@endsection
