@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Financeiro', 'url' => '/', 'active' => false],
        ['text' => 'Fornecedor', 'url' => '#', 'active' => true],
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
                    <!--/.bg-holder-->
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="form-group col-lg-10 col-md-10 col-sm-9">
                                    <label for="nome">Nome</label>
                                    <input class="form-control " id="nome" name="nome" maxlength="200"
                                        value="" type="text" placeholder="">
                                </div>
                                <div class="form-group col-lg-1 col-md-1 col-sm-6 mt-4">
                                    <button class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i>
                                        Buscar</button>
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
                                <a href="{{route('fornecedor.novo')}}" title="Inserir um novo registro" class="btn btn-primary right"> <i
                                        class="fas fa-plus-circle"></i> Novo </a>
                                <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nome do Forncedor</th>
                                            <th>Cidade/Estado</th>
                                            <th>Telefone</th>
                                            <th>Celular</th>
                                            <th>E-mail</th>
                                            <th width="150"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Conteúdo -->
            </div>
        </div>
    </div>
@endsection
