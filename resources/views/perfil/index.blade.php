@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Segurança', 'url' => '#', 'active' => false],
        ['text' => 'Perfil', 'url' => '/perfil', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('content')
    @include('extras.alerts-error-all')
    @include('extras.alerts')

    <div style="margin: 0px 23px;">
        <form method="POST" action="{{ route('perfil.update', ['id' => $usuario->id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <blockquote class="blockquote">
                        <div class="row mb-4">
                            <div class="col-xl-12">
                                <label for="name">* Nome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $usuario->name) }}">
                                @error('name')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-xl-6">
                                <label for="email">* E-mail</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $usuario->email) }}">
                                @error('email')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-xl-4">
                                <label for="password">Nova Senha</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                <span class="help-block text-muted">Deixe em branco para manter a senha atual.</span>
                                @error('password')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-xl-4">
                                <label for="password_confirmation">Confirmar Nova Senha</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation">
                                <span class="help-block text-muted">Confirme a nova senha. Necessário apenas se estiver
                                    alterando a senha.</span>
                                @error('password_confirmation')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Dentro do seu formulário em perfil.index --}}
                        <div class="row mb-4">
                            <div class="col-xl-4">
                                <label for="instituicao_nome">Instituição</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="instituicao_nome" name="instituicao_nome"
                                        readonly value="{{ $usuario->instituicao->nome ?? '' }}">
                                    <input type="hidden" id="instituicao_id" name="instituicao_id"
                                        value="{{ $usuario->instituicao->id ?? '' }}">
                                    <button type="button" id="abrirModalInstituicoes" class="btn btn-secondary"
                                        data-bs-toggle="modal" data-bs-target="#modalInstituicoes">Selecionar</button>
                                </div>
                            </div>
                        </div>

                        {{-- Inclua o modal aqui --}}
                        @include('perfil.modal-instituicoes')

                        <div class="form-group mt-4">
                            <button type="submit" title="atualizar" class="btn btn-primary btn-lg">Atualizar</button>
                        </div>
                    </blockquote>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('extras-scripts')
    <script>
        $(document).ready(function() {
            $('#abrirModalInstituicoes').on('click', function() {
                loadInstituicoes(1); // Carrega a primeira página
                $('#modalInstituicoes').modal('show'); // Abre o modal
            });

            $('#searchButton').on('click', function() {
                loadInstituicoes(1, $('#searchInstituicao').val()); // Carrega com os termos de pesquisa
            });

            function loadInstituicoes(page, search = '') {
                $('#loading').show(); // Mostra a imagem de carregamento
                $('#instituicoesList').hide(); // Oculta a lista durante o carregamento

                $.ajax({
                    url: '/instituicoes?page=' + page + '&search=' + search,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#instituicoesList').html('');
                        response.data.forEach(function(instituicao) {
                            $('#instituicoesList').append(
                                `<div class="list-group-item list-group-item-action instituicao-item" data-id="${instituicao.id}" data-nome="${instituicao.nome}">${instituicao.nome}</div>`
                            );
                        });

                        // Paginação
                        $('#modalInstituicoes .modal-footer .pagination').remove();
                        let paginationLinks = generatePaginationLinks(response);
                        $('#modalInstituicoes .modal-footer').prepend(paginationLinks);

                        $('#loading').hide(); // Oculta a imagem de carregamento
                        $('#instituicoesList').show(); // Mostra a lista atualizada
                    }
                });
            }

            function generatePaginationLinks(response) {
                let paginationLinks = '<div class="pagination">';
                let currentPage = response.current_page;
                let totalPage = response.last_page;
                let range = 2;

                if (totalPage <= (range * 2) + 3) {
                    for (let page = 1; page <= totalPage; page++) {
                        paginationLinks += generatePageLink(page, currentPage);
                    }
                } else {
                    paginationLinks += generatePageLink(1, currentPage);
                    paginationLinks += (currentPage > range + 2) ? '...' : '';

                    let start = Math.max(currentPage - range, 2);
                    let end = Math.min(currentPage + range, totalPage - 1);

                    for (let page = start; page <= end; page++) {
                        paginationLinks += generatePageLink(page, currentPage);
                    }

                    paginationLinks += (currentPage < totalPage - range - 1) ? '...' : '';
                    paginationLinks += generatePageLink(totalPage, currentPage);
                }

                paginationLinks += '</div>';
                return paginationLinks;
            }

            function generatePageLink(page, currentPage) {
                return `<a href="#" class="page-link ${page === currentPage ? 'active' : ''}" data-page="${page}">${page}</a> `;
            }

            $('#modalInstituicoes').on('click', '.page-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                loadInstituicoes(page);
            });

            $('#modalInstituicoes').on('click', '.instituicao-item', function() {
                var nome = $(this).data('nome');
                var id = $(this).data('id');

                $('#instituicao_nome').val(nome);
                $('#instituicao_id').val(id);

                $('#modalInstituicoes').modal('hide');
            });
        });
    </script>
@endsection
