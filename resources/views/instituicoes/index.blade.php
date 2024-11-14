@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[['text' => 'Instituições', 'url' => '/', 'active' => true]]"></x-breadcrumb>
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
            <div class="tabs">
                <ul class="nav nav-tabs" id="instituicaoTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('instituicoes-regiao.index') }}" role="tab">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?tipo_instituicao_id=1" role="tab_igreja">Igrejas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?tipo_instituicao_id=5" role="tab_secretaria">Secretarias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?tipo_instituicao_id=2" role="tab_distrito">Distritos</a>
                    </li>
                    <!-- Adicione mais abas conforme necessário -->
                </ul>
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
                                <a href="{{ route('instituicoes-regiao.novo') }}" title="Inserir um novo registro"
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
                                                <th>Nome</th>

                                                <th width="240px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($instituicoes as $index => $instituicao)
                                                <tr>
                                                    <td>
                                                        @if ($instituicao->deleted_at)
                                                            <del>{{ $instituicao->nome }}</del>
                                                        @else
                                                            {{ $instituicao->nome }}
                                                        @endif
                                                    </td>
                                                    <td class="table-action">

                                                        @if (!$instituicao->deleted_at)
                                                            <a href="javascript:void(0);" title="Visualizar"
                                                                class="btn btn-sm btn-info mr-1 btn-rounded btn-view-details"
                                                                data-instituicao-id="{{ $instituicao->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-eye">
                                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z">
                                                                    </path>
                                                                    <circle cx="12" cy="12" r="3"></circle>
                                                                </svg>

                                                            </a>
                                                            <a href="{{ route('instituicoes-regiao.editar', $instituicao->id) }}"
                                                                title="Editar"
                                                                class="btn btn-sm btn-dark mr-1 btn-rounded">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit-2">
                                                                    <path
                                                                        d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                        @endif

                                                        <form
                                                            action="{{ route($instituicao->deleted_at ? 'instituicoes-regiao.ativar' : 'instituicoes-regiao.deletar', $instituicao->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            id="form_{{ $instituicao->deleted_at ? 'ativar' : 'delete' }}_instituicao_{{ $index }}">
                                                            @csrf
                                                            @if ($instituicao->deleted_at)
                                                                @method('PUT') {{-- Para restaurar o registro --}}
                                                                <button type="button" title="Ativar"
                                                                    class="btn btn-sm btn-success mr-1 btn-rounded btn-confirm-ativar"
                                                                    data-form-ativar-id="form_ativar_instituicao_{{ $index }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-refresh-cw">
                                                                        <polyline points="23 4 23 10 17 10"></polyline>
                                                                        <polyline points="1 20 1 14 7 14"></polyline>
                                                                        <path
                                                                            d="M3.51 9a9 9 0 0 1 13.36-5.36L23 10m-2 6a9 9 0 0 1-13.36 5.36L1 14">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            @else
                                                                @method('DELETE')
                                                                <button type="button" title="Inativar"
                                                                    class="btn btn-sm btn-danger btn-rounded btn-confirm-delete"
                                                                    data-form-delete-id="form_delete_instituicao_{{ $index }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-slash">
                                                                        <circle cx="12" cy="12" r="10">
                                                                        </circle>
                                                                        <line x1="4.93" y1="4.93"
                                                                            x2="19.07" y2="19.07"></line>
                                                                    </svg>
                                                                </button>
                                                            @endif
                                                        </form>

                                                    </td>
                                                </tr>
                                                <!-- Modal de Visualização -->
                                                <div class="modal fade" id="viewDetailsModal_{{ $instituicao->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="viewDetailsModalLabel_{{ $instituicao->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable"
                                                        role="document"> <!-- Adiciona o scroll ao modal -->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Os detalhes do instituicao serão preenchidos aqui pelo JavaScript -->
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                {{ $instituicoes->links('vendor.pagination.index') }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Conteúdo -->
            </div>
        </div>
    </div>

    <script>
        // Confirmação para apagar (deletar) o instituicao
        $('.btn-confirm-delete').on('click', function() {
            const formId = $(this).data('form-delete-id');
            swal({
                title: 'Deseja realmente inativar esta instituicao?',
                type: 'error',
                showCancelButton: true,
                confirmButtonText: "Inativar",
                confirmButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#3085d6",
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    document.getElementById(formId).submit();
                }
            });
        });

        // Confirmação para ativar o instituicao
        $('.btn-confirm-ativar').on('click', function() {
            const formId = $(this).data('form-ativar-id');
            swal({
                title: 'Deseja realmente ativar esta instituicao?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "Sim",
                confirmButtonColor: "#28a745", // Verde para ativar
                cancelButtonText: "Não",
                cancelButtonColor: "#3085d6",
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    document.getElementById(formId).submit();
                }
            });
        });

        $('.btn-view-details').on('click', function() {
            var instituicaoId = $(this).data('instituicao-id');
            var modalId = '#viewDetailsModal_' + instituicaoId;
            var button = $(this);

            // Adicionar o ícone de loading no botão usando Font Awesome
            var originalButtonText = button.html(); // Salvar o texto original do botão
            button.html('<i class="fas fa-spinner fa-spin"></i>'); // Usar Font Awesome spinner

            $.ajax({
                url: '/instituicoes-regiao/' + instituicaoId + '/detalhes',
                method: 'GET',
                success: function(data) {
                    // Preenche o modal com as informações do instituicao e as nomeações, ambos em formato de card
                    $(modalId).find('.modal-body').html(`
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        Informações do Instituições
                    </div>
                    <div class="card-body">
                        <p><strong>Nome:</strong> ${data.nome}</p>
                        <p><strong>CNPJ:</strong> ${data.cnpj || '-'}</p>
                        <p><strong>CEP:</strong> ${data.cep || '-'}</p>
                        <p><strong>Endereço:</strong> ${data.endereco || '-'}, ${data.numero || '-'}</p>
                        <p><strong>Complemento:</strong> ${data.complemento || '-'}</p>
                        <p><strong>Bairro:</strong> ${data.bairro || '-'}</p>
                        <p><strong>Cidade:</strong> ${data.cidade || '-'}</p>
                        <p><strong>UF:</strong> ${data.uf || '-'}</p>
                        <p><strong>País:</strong> ${data.pais || '-'}</p>
                        <p><strong>DDD:</strong> ${data.ddd || '-'}</p>
                        <p><strong>Telefone:</strong> ${data.telefone || '-'}</p>
                        <p><strong>Site:</strong> ${data.site || '-'}</p>
                        <p><strong>Email:</strong> ${data.email || '-'}</p>
                        <p><strong>Responsável:</strong> ${data.pastor || '-'}</p>
                    </div>
                </div>
            `);

                    // Exibe o modal
                    $(modalId).modal('show');
                },
                error: function(err) {
                    console.error("Erro ao buscar os detalhes do instituicao: ", err);
                },
                complete: function() {
                    // Restaurar o texto original do botão após o carregamento
                    button.html(originalButtonText);
                }
            });
        });
        const tabs = document.querySelectorAll('[role=tab]');
        const params = new URLSearchParams(window.location.search);
        const id = params.get('tipo_instituicao_id');

        console.log(id);

        // Ativa a aba com base no valor de 'id' ao carregar a página
        if (id == 1) {
            document.querySelector('[role=tab_igreja]').classList.add('active');
        }
        else if (id == 2) {
            document.querySelector('[role=tab_distrito]').classList.add('active');
        }
        else if (id == 5) {
            document.querySelector('[role=tab_secretaria]').classList.add('active');
        }else{
            document.querySelector('[role=tab]').classList.add('active');
        }

        // Evento de clique para alternar manualmente as abas
        tabs.forEach((tab) => {
            tab.addEventListener('click', (event) => {
                tabs.forEach((tab) => tab.classList.remove('active'));
                event.currentTarget.classList.add('active');
            });
        });
    </script>
@endsection
