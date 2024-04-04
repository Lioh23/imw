@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Financeiro', 'url' => '/', 'active' => false],
    ['text' => 'Caixas', 'url' => '#', 'active' => true]
]"></x-breadcrumb>
@endsection
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
                <div class="card-body">
                    <form>
                        <div class="row mb-4">
                            <div class="col-4">
                                <input type="text" name="search" id="searchInput" class="form-control form-control-sm"
                                    placeholder="Pesquisar...">
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
                            <a href="#" title="Inserir um novo registro"
                                class="btn btn-primary right btn-rounded"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Novo </a>
                                <table class="table mt-4">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Tipo</th>
                                        <th width="200"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($caixas as $caixa)
                                    <tr style="{{ $caixa->tipo == 'P' ? 'background-color: gray; color: white !important;' : '' }}">
                                        <td style="{{ $caixa->tipo == 'P' ? 'color: white !important;' : '' }}">{{$caixa->descricao}}</td>
                                        <td style="{{ $caixa->tipo == 'P' ? 'color: white !important;' : '' }}">{{ match($caixa->tipo) { 'S' => 'Secundário', 'B' => 'Banco', 'P' => 'Principal', 'C' => 'Caixa', default => $caixa->tipo } }}</td>
                                        <td class="table-action">
                                            @if($caixa->tipo != 'P')
                                                <a href="#" title="editar"
                                                    class="btn btn-sm btn-dark mr-2 btn-rounded mr-2 "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                                <a href="#" title="apagar"
                                                    class="btn btn-sm btn-danger mr-2 btn-rounded"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                                            @endif
                                          </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $caixas->links('vendor.pagination.index') }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim Conteúdo -->
        </div>
    </div>
</div>
@endsection