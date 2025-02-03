@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Estatísticas', 'url' => '#', 'active' => false],
    ['text' => 'Evolução de Membros', 'url' => '#', 'active' => true],
]"></x-breadcrumb>
@endsection

@section('extras-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('extras-scripts')
<script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
@endsection

@include('extras.alerts')

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Evolução de Membros</h4>
                </div>
            </div>
        </div>

        <div class="widget-content widget-content-area">
            <!-- Formulário de Filtro -->
            <form class="form-vertical" id="filter_form" method="GET">
                <div class="form-group row mb-4">
                    <div class="col-lg-2 text-right">
                        <label class="control-label">* Ano Inicial:</label>
                    </div>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" id="anoinicio" name="anoinicio"
                            value="{{ request()->input('anoinicio', date('Y') - 4) }}" required>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <div class="col-lg-2 text-right">
                        <label class="control-label">* Ano Final:</label>
                    </div>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" id="anofinal" name="anofinal"
                            value="{{ request()->input('anofinal', date('Y')) }}" required>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-6">
                        <button id="btn_buscar" type="submit" class="btn btn-primary">
                            <x-bx-search /> Buscar
                        </button>
                    </div>
                </div>
            </form>

            @if(isset($dados) && count($dados) > 0)
            <h4>Resultados de {{ $anoinicio }} a {{ $anofinal }}</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            @foreach ($anosDisponiveis as $ano)
                            <th>{{ $ano }}</th>
                            @endforeach
                            <th>Evolução</th>
                            <th>Percentual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $totais = [];
                        $totalEvolucao = 0;
                        @endphp

                        @foreach ($dados as $linha)
                        <tr>
                            <td>{{ $linha->nome }}</td>
                            @foreach ($anosDisponiveis as $ano)
                            @php
                            $valorAno = $linha->$ano ?? 0;
                            $totais[$ano] = ($totais[$ano] ?? 0) + $valorAno;
                            @endphp
                            <td>{{ $valorAno }}</td>
                            @endforeach
                            <td>{{ $linha->Evolucao }}</td>
                            <td>{{ $linha->Percentual }}%</td>
                        </tr>
                        @php
                        $totalEvolucao += $linha->Evolucao;
                        @endphp
                        @endforeach

                        <!-- Linha de Totalização -->
                        <tr style="font-weight: bold; background-color: #f8f9fa;">
                            <td>{{ auth()->user()->pessoa->regiao->nome }}</td>
                            @foreach ($anosDisponiveis as $ano)
                            <td>{{ $totais[$ano] ?? 0 }}</td>
                            @endforeach
                            <td>{{ $totalEvolucao }}</td>
                            @php
                            $totalAnoInicial = $totais[reset($anosDisponiveis)] ?? 0;
                            $percentualTotal = ($totalAnoInicial > 0) ? round(($totalEvolucao / $totalAnoInicial) * 100, 2) : 0;
                            @endphp
                            <td>{{ $percentualTotal }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif


        </div>
    </div>
</div>

<!-- Validação do Formulário com SweetAlert -->
<script>
    document.getElementById('filter_form').addEventListener('submit', function(event) {
        var anoinicio = parseInt(document.getElementById('anoinicio').value);
        var anofinal = parseInt(document.getElementById('anofinal').value);
        var anoAtual = new Date().getFullYear();

        if (anoinicio >= anofinal) {
            event.preventDefault();
            Swal.fire({
                title: 'Atenção!',
                text: 'O Ano Inicial não pode ser maior ou igual ao Ano Final.',
                icon: 'warning',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ok'
            });
            return;
        }

        if ((anofinal - anoinicio) > 10) {
            event.preventDefault();
            Swal.fire({
                title: 'Atenção!',
                text: 'A diferença entre os anos não pode ser maior que 10 anos.',
                icon: 'warning',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ok'
            });
            return;
        }

        if (anofinal > anoAtual) {
            event.preventDefault();
            Swal.fire({
                title: 'Atenção!',
                text: 'O Ano Final não pode ser maior que o ano atual (' + anoAtual + ').',
                icon: 'warning',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ok'
            });
            return;
        }
    });
</script>

@endsection
