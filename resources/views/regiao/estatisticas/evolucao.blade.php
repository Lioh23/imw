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
                        <select class="form-control" id="anoinicio" name="anoinicio" required>
                            <option value="">Selecione o Ano Inicial</option>
                            @for ($ano = date('Y') - 10; $ano <= date('Y'); $ano++)
                                <option value="{{ $ano }}" {{ request()->input('anoinicio') == $ano ? 'selected' : '' }}>
                                {{ $ano }}
                                </option>
                                @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <div class="col-lg-2 text-right">
                        <label class="control-label">* Ano Final:</label>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" id="anofinal" name="anofinal" required>
                            <option value="">Selecione o Ano Final</option>
                            @for ($ano = date('Y') - 10; $ano <= date('Y'); $ano++)
                                <option value="{{ $ano }}" {{ request()->input('anofinal') == $ano ? 'selected' : '' }}>
                                {{ $ano }}
                                </option>
                                @endfor
                        </select>
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

            <!-- Exibir tabela apenas se houver um request GET válido -->
            @if(request()->has('anoinicio') && request()->has('anofinal'))
            @if(isset($dados) && count($dados) > 0)
            <h4>Resultados de {{ $anoinicio }} a {{ $anofinal }}</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            @foreach (range($anoinicio, $anofinal) as $ano)
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
                            @foreach (range($anoinicio, $anofinal) as $ano)
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

                        <!-- Linha de Totalização Corrigida -->
                        <tr style="font-weight: bold; background-color: #f8f9fa;">
                            <td>6 Região</td>
                            @foreach (range($anoinicio, $anofinal) as $ano)
                            <td>{{ $totais[$ano] ?? 0 }}</td>
                            @endforeach
                            <td>{{ $totalEvolucao }}</td>
                            @php
                            // Pegar o total do primeiro ano corretamente
                            $totalAnoInicial = $totais[$anoinicio] ?? 0;

                            // Calcular o percentual corretamente
                            if ($totalAnoInicial == 0) {
                            $percentualTotal = ($totalEvolucao > 0) ? ($totalEvolucao * 100) : 0;
                            } else {
                            $percentualTotal = round(($totalEvolucao / $totalAnoInicial) * 100, 2);
                            }
                            @endphp
                            <td>{{ $percentualTotal }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center text-muted">Nenhum resultado encontrado para o período selecionado.</p>
            @endif
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

        if (!anoinicio || !anofinal) {
            event.preventDefault();
            Swal.fire({
                title: 'Atenção!',
                text: 'Preencha todos os campos corretamente.',
                icon: 'warning',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ok'
            });
            return;
        }

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
