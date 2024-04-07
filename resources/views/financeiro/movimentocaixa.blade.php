@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Financeiro', 'url' => '/', 'active' => false],
        ['text' => 'Movimento de Caixa', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <style>
        .input-group-addon {
            cursor: pointer;
            padding: 0 10px;
            border: none;
            background-color: transparent;
        }

        .datepicker {
            padding-right: 30px;
        }

        .datepicker+.input-group-addon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
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
                            <select class="form-control select2" data-bs-toggle="select2" width="fit" name="caixa_id"
                                id="caixa_id">
                                <option value="" hidden disabled selected>Selecione</option>
                                @foreach ($caixas as $caixa)
                                    <option value="{{ $caixa->id }}">{{ $caixa->descricao }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                            <label for="plano_conta_id">Plano de Contas</label>
                            <select class="form-control select2" data-bs-toggle="select2" width="fit"
                                name="plano_conta_id" id="plano_conta_id">
                                <option value="" hidden disabled selected>Selecione</option>
                                @foreach ($planoContas as $pc)
                                    <option {{ !$pc->selecionavel ? 'disabled' : '' }} value="{{ $pc->id }}">
                                        {{ $pc->numeracao }} - {{ $pc->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-lg-3 col-md-3 col-sm-6 pf lgpd">
                            <label for="d1">Data do Inicial</label>
                            <div class="input-group">
                                <input class="form-control datepicker" id="d1" name="d1" maxlength="20"
                                    value="" type="text" placeholder="">
                                <span class="input-group-addon">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3 col-lg-3 col-md-3 col-sm-6 pf lgpd">
                            <label for="d2">Data do Final</label>
                            <div class="input-group">
                                <input class="form-control datepicker" id="d2" name="d2" maxlength="20"
                                    value="" type="text" placeholder="">
                                <span class="input-group-addon">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-3 col-md-3 col-sm-6">
                            <div class="col-auto" style="margin-left: -19px; margin-top: 35px;">
                                <button type="submit" class="btn btn-primary btn-rounded"><x-bx-search /> Pesquisar</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-3">

            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a href="{{ route('financeiro.entrada') }}" title="Novo registro de entrada"
                            class="btn btn-success right btn-rounded">
                            <x-bx-plus-circle /> Entrada
                        </a>

                        <a href="{{ route('financeiro.saida') }}" title="Novo registro de saída"
                            class="btn btn-danger right btn-rounded">
                            <x-bx-minus-circle /> Saída
                        </a>

                        <a href="{{ route('financeiro.transferencia') }}" title="Novo registro de transferência"
                            class="btn btn-warning right btn-rounded">
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
                        <button class="btn btn-success btn-rounded" onclick="exportReportToExcel();"><i
                                class="fa fa-file-excel" aria-hidden="true"></i> Exportar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fim Conteúdo --}}
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: 'dd/mm/yy', // Formato da data
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
                    'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out',
                    'Nov', 'Dez'
                ],
                nextText: 'Próximo',
                prevText: 'Anterior'
            });
        });
    </script>
@endsection
