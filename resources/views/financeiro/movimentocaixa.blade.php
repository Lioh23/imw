@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Financeiro', 'url' => '/', 'active' => false],
        ['text' => 'Movimento de Caixa', 'url' => '#', 'active' => true],
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
                <form action="">
                    <div class="row">

                        <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                            <label for="caixa_id">Caixa</label>
                            <select class="form-control select2" data-bs-toggle="select2" width="fit" name="caixa_id" id="caixa_id">
                                <option value="" hidden disabled selected>Selecione</option>
                                @foreach ($caixas as $caixa)
                                    <option value="{{ $caixa->id }}">{{ $caixa->descricao }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                            <label for="plano_conta_id">Plano de Contas</label>
                            <select class="form-control select2" data-bs-toggle="select2" width="fit" name="plano_conta_id" id="plano_conta_id">
                                <option value="" hidden disabled selected>Selecione</option>
                                @foreach ($planoContas as $pc)
                                    <option {{ !$pc->selecionavel ? 'disabled' : '' }} value="{{ $pc->id }}">{{ $pc->numeracao}} - {{ $pc->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-lg-3 col-md-3 col-sm-6 pf lgpd">
                            <label for="d1">Data do Inicial</label>
                            <input class="form-control date" id="d1" name="d1" maxlength="20"
                                value="" type="text" placeholder="">
                        </div>

                        <div class="mb-3 col-lg-3 col-md-3 col-sm-6 pf lgpd">
                            <label for="d2">Data do Final</label>
                            <input class="form-control date" id="d2" name="d2" maxlength="20"
                                value="" type="text" placeholder="">
                        </div>

                        <div class="form-group col-lg-1 col-md-2 col-sm-6 mt-4">
                            <button class="btn btn-primary btn-rounded"><i class="fa fa-search" aria-hidden="true"></i>
                                Buscar</button>
                        </div>
                        <div class="form-group col-lg-1 col-md-2 col-sm-6 mt-4">

                            <button class="btn btn-danger btn-rounded" type="button"> <i
                                    class="fas fa-fw fa-eraser"></i> Limpar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-3">

            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a href="{{ route('financeiro.entrada') }}" title="Novo registro de entrada" class="btn btn-success right btn-rounded"> 
                            <x-bx-plus-circle /> Entrada
                        </a>

                        <a href="{{ route('financeiro.saida') }}" title="Novo registro de saída" class="btn btn-danger right btn-rounded"> 
                            <x-bx-minus-circle /> Saída
                        </a>

                        <a href="{{ route('financeiro.transferencia') }}" title="Novo registro de transferência" class="btn btn-warning right btn-rounded"> 
                            <x-bx-chevrons-right /> Transferência 
                        </a>

                        <a href="#" title="Saldo" class="btn btn-primary right btn-rounded"> 
                            <x-bx-wallet /> Saldo 
                        </a>

                        <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                            <thead class="thead-light">
                                <tr>

                                    <th>Data</th>
                                    <th>Caixa</th>
                                    <th>Entrada</th>
                                    <th>Saída</th>
                                    <th>Plano de Conta</th>
                                    <th>Pagante/Favorecido</th>



                                    <th width="150"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn btn-success btn-rounded" onclick="exportReportToExcel();"><i class="fa fa-file-excel"
                                aria-hidden="true"></i> Exportar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fim Conteúdo --}}
    </div>
    </div>
    </div>
@endsection
