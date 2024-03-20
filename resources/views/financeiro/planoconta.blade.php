@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Financeiro', 'url' => '/', 'active' => false],
    ['text' => 'Plano Conta', 'url' => '#', 'active' => true]
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
                <!--Card Pesquisa-->
                <div class="card mb-3">
                    <div class="bg-holder d-none d-lg-block bg-card gb-title">
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="form-group col-lg-10 col-md-10 col-sm-9">
                                    <label for="nome">Nome</label>
                                    <input class="form-control " id="nome" name="nome" maxlength="200" value="" type="text" placeholder="">
                                </div>
                                <div class="form-group col-lg-1 col-md-1 col-sm-6 mt-4">
                                    <button class="btn btn-primary btn-rounded"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">

                    <div class="col-12">
                        <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                            <thead class="thead-light">
                                <tr>
                
                                    <th style="width: 60px;">Codigo</th>
                                    <th>Nome</th>
                                    <th width="150"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                
                                    <td>1</td>
                                    <td>ENTRADAS</td>
                                    <td class="table-action">
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.01</td>
                                    <td>DÍZIMOS</td>
                                    <td class="table-action">
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.01.01</td>
                                    <td>Dizimo dos Membros</td>
                                    <td class="table-action"></td>
                                </tr>
                
                                <tr>
                                    <td>1.01.02</td>
                                    <td>Dizimo dos Congregados</td>
                                    <td class="table-action"></td>
                                </tr>
                            </tbody>
                        </table>
                
                
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item active">
                                    <a href="#" class="page-link">
                                        1 </a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">
                                        2 </a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">
                                        3 </a>
                                </li>
                
                                <li class="page-item">
                                    <a href="#" aria-label="Next"
                                        class="page-link">
                                        <span aria-hidden="true">Próximo</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="#" aria-label="Last"
                                        class="page-link">
                                        <span aria-hidden="true">Último</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            <!-- Fim conteúdo -->
        </div>
    </div>
</div>
@endsection