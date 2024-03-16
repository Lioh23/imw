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
                            <div class="col-xl-6">
                                <label for="instituicao_nome">Instituição</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="instituicao_nome" name="instituicao_nome"
                                        readonly value="{{ $usuario->instituicao->nome ?? '' }}">
                                    <input type="hidden" id="instituicao_id" name="instituicao_id"
                                        value="{{ $usuario->instituicao->id ?? '' }}">
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#modalInstituicoes">Selecionar</button>
                                </div>
                            </div>
                        </div>

                        {{-- Inclua o modal aqui --}}


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
    document.addEventListener('DOMContentLoaded', function () {
        $('#modalInstituicoes').on('show.bs.modal', function () {
            loadInstituicoes(1); // Carrega a primeira página ao abrir o modal
        });
    
        function loadInstituicoes(page) {
            $.ajax({
                url: '/instituicoes?page=' + page,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#modalInstituicoes .modal-body').html('');
                    response.data.forEach(function (instituicao) {
                        $('#modalInstituicoes .modal-body').append(
                            `<div class="list-group-item list-group-item-action instituicao-item" data-id="${instituicao.id}" data-nome="${instituicao.nome}">${instituicao.nome}</div>`
                        );
                    });
    
                    // Paginação
                    $('#modalInstituicoes .modal-footer .pagination').remove();
                    let paginationLinks = generatePaginationLinks(response);
                    $('#modalInstituicoes .modal-footer').prepend(paginationLinks);
                }
            });
        }
    
        // Função para gerar links de paginação
        function generatePaginationLinks(response) {
            let paginationLinks = '<div class="pagination">';
            for (let page = 1; page <= response.last_page; page++) {
                paginationLinks += `<a href="#" class="page-link" data-page="${page}">${page}</a> `;
            }
            paginationLinks += '</div>';
            return paginationLinks;
        }
    
        // Manipulação de clique nos links de paginação
        $('#modalInstituicoes').on('click', '.page-link', function (e) {
            e.preventDefault();
            let page = $(this).data('page');
            loadInstituicoes(page);
        });
    
        $('#modalInstituicoes').on('click', '.instituicao-item', function () {
            var nome = $(this).data('nome');
            var id = $(this).data('id');
    
            $('#instituicao_nome').val(nome);
            $('#instituicao_id').val(id);
    
            $('#modalInstituicoes').modal('hide');
        });
    });
    </script>    
@endsection