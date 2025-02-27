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
<style>
    .swal2-popup .swal2-styled.swal2-cancel {
        color: white !important;
    }

    .toggle-icon {
        cursor: pointer;
        margin-right: 5px;
    }

    .child-row {
        display: none;
        /* Filhos ficam escondidos inicialmente */
    }
</style>
@endsection

@section('extras-scripts')
<script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-icon').forEach(function(icon) {
            icon.addEventListener('click', function() {
                let target = this.dataset.target;
                let rows = document.querySelectorAll(`.child-row[data-parent="${target}"]`);

                let isHidden = rows[0].style.display === 'none' || rows[0].style.display === '';

                rows.forEach(row => {
                    row.style.display = isHidden ? 'table-row' : 'none';
                });

                if (isHidden) {
                    this.classList.remove('fa-plus-square');
                    this.classList.add('fa-minus-square');
                } else {
                    this.classList.remove('fa-minus-square');
                    this.classList.add('fa-plus-square');
                }
            });
        });
        // Validação do formulário
        document.getElementById('filter_form').addEventListener('submit', function(event) {
            let anoinicio = parseInt(document.getElementById('anoinicio').value);
            let anofinal = parseInt(document.getElementById('anofinal').value);

            if (anofinal < anoinicio) {
                event.preventDefault(); // Impede o envio do formulário
                Swal.fire({
                    icon: 'error',
                    title: 'Erro na seleção de datas',
                    text: 'O ano final não pode ser menor que o ano inicial!',
                    confirmButtonText: 'Entendi',
                });
            }
        });
    });
</script>

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
            <!-- 🔹 Formulário de Pesquisa -->
            <form class="form-vertical" id="filter_form" method="GET">
                <div class="form-group row mb-4">
                    <div class="col-lg-2 text-right">
                        <label class="control-label">* Ano Inicial:</label>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" id="anoinicio" name="anoinicio" required>
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

            @if(request()->has('anoinicio') && request()->has('anofinal'))
            @if(isset($instituicoes_pais) && count($instituicoes_pais) > 0)
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
                        $totaisPais = array_fill_keys(range($anoinicio, $anofinal), 0);
                        $totalEvolucaoPais = 0;
                        $totalAnoInicialPais = 0;
                        $totalAnoFinalPais = 0;
                        @endphp

                        @foreach ($instituicoes_pais as $pai)
                        <tr style="font-weight: bold; background-color: #f8f9fa;">
                            <td>
                                <i class="fas fa-plus-square toggle-icon" data-target="pai-{{ $pai->id }}"></i>
                                {{ $pai->instituicao }}
                            </td>
                            @php
                            $valorAnoInicial = $pai->$anoinicio ?? 0;
                            $valorAnoFinal = $pai->$anofinal ?? 0;
                            $evolucao = $valorAnoFinal - $valorAnoInicial;

                            $percentual = $valorAnoInicial > 0 ? round(($evolucao / $valorAnoInicial) * 100, 2) : ($valorAnoFinal > 0 ? 100 * $valorAnoFinal : 0);

                            $totalAnoInicialPais += $valorAnoInicial;
                            $totalAnoFinalPais += $valorAnoFinal;
                            $totalEvolucaoPais += $evolucao;
                            @endphp
                            @foreach (range($anoinicio, $anofinal) as $ano)
                            <td>{{ $pai->$ano ?? 0 }}</td>
                            @php $totaisPais[$ano] += $pai->$ano ?? 0; @endphp
                            @endforeach
                            <td>{{ $evolucao }}</td>
                            <td>{{ $percentual }}%</td>
                        </tr>

                        @foreach ($instituicoes_filhos as $filho)
                        @if ($filho->instituicao_pai_id == $pai->id)
                        <tr class="child-row" data-parent="pai-{{ $pai->id }}">
                            <td>➜ {{ $filho->instituicao }}</td>
                            @php
                            $valorAnoInicialFilho = $filho->$anoinicio ?? 0;
                            $valorAnoFinalFilho = $filho->$anofinal ?? 0;
                            $evolucaoFilho = $valorAnoFinalFilho - $valorAnoInicialFilho;

                            $percentualFilho = $valorAnoInicialFilho > 0 ? round(($evolucaoFilho / $valorAnoInicialFilho) * 100, 2) : ($valorAnoFinalFilho > 0 ? 100 * $valorAnoFinalFilho : 0);
                            @endphp
                            @foreach (range($anoinicio, $anofinal) as $ano)
                            <td>{{ $filho->$ano ?? 0 }}</td>
                            @endforeach
                            <td>{{ $evolucaoFilho }}</td>
                            <td>{{ $percentualFilho }}%</td>
                        </tr>
                        @endif
                        @endforeach
                        @endforeach
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
@endsection
