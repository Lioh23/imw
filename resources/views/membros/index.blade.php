@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Membros', 'url' => '/membros/', 'active' => true]
]"></x-breadcrumb>
@endsection
@section('content')
<div class="container-fluid"> 
    <button type="button" class="btn btn-warning position-relative mt-3 mb-3 ml-2">
        <span>ROL ATUAL</span>
        <span class="badge badge-warning counter">146</span>
    </button>
    <!-- <button type="button" class="btn btn-danger position-relative mt-3 mb-3 ml-2">
        <span>DESLIGADOS</span>
        <span class="badge badge-danger counter">146</span>
    </button> -->
    <button type="button" class="btn btn-info position-relative mt-3 mb-3 ml-2">
        <span>ROL PERMANENTE</span>
        <span class="badge badge-info counter">594</span>
    </button>
    <!-- <button type="button" class="btn btn-success position-relative mt-3 mb-3 ml-2">
        <span>ESTATÍSTICA</span>
    </button> -->
</div>
<!-- TABELA -->
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Lista de Membros</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="row mb-4">
                <div class="col-4">
                    <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Pesquisar...">
                </div>
                <div class="col-auto" style="margin-left: -19px;">
                    <button id="searchButton" class="btn btn-primary btn-rounded" type="button">Pesquisar</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-4">
                    <thead>
                        <tr>
                            <th>ROL</th>
                            <th>NOME</th>
                            <th>RECEPÇÃO</th>
                            <th>EXCLUSÃO</th>
                            <th>CONGREGAÇÃO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>320</td>
                            <td>Vinicius de Oliveira Almeida</td>
                            <td>10/01/2023</td>
                            <td>30/12/2023</td>
                            <td>VILA RICA</td>
                            <td class="text-center">
                                <a href="/membro/editar/1" title="Editar" class="btn btn-secundary mr-2 btn-rounded"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg></a>
                            </td>
                        </tr>
                        <tr>
                            <td>433</td>
                            <td>Rafel Souza da Paz</td>
                            <td>10/01/2023</td>
                            <td>30/12/2023</td>
                            <td>VILA RICA</td>
                            <td class="text-center">
                                <a href="/membro/editar/2" title="Editar" class="btn btn-secundary mr-2 btn-rounded"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection