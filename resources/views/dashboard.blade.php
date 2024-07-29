@extends('template.layout')
@section('extras-css')
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
<style>
    .chart-container {
        position: relative;
        height: 400px; /* Ajuste a altura conforme necessário */
    }
    .swal2-popup .swal2-styled.swal2-cancel {
        color: white !important;
    }
</style>
@endsection

@section('content')
@include('extras.alerts')
<div class="container-fluid h-100">
<div class="container-fluid h-100">
@if($instituicao->tipoInstituicao->sigla == 'I')
    <div class="row flex-fill mt-4">
        <!-- Conteúdo para tipoInstituicao 'I' -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Membros</b></h6>
                    <p class="card-text">Total: {{ $activeMembrosCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Congregados</b></h6>
                    <p class="card-text">Total: {{ $activeCongregadosCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Visitantes</b></h6>
                    <p class="card-text">Total: {{ $activeVisitantesCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row flex-fill mt-4">
         <!-- Gráfico de Membros Ativos vs Inativos -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Gráfico de Membros Ativos vs Inativos</h6>
                    <div class="chart-container">
                        <canvas id="membrosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Visitantes por Mês -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Gráfico de Visitantes por Mês</h6>
                    <div class="chart-container">
                        <canvas id="visitantesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif($instituicao->tipoInstituicao->sigla == 'R')
    <div class="row flex-fill mt-4">
        <div class="col-12 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Bem-vindo(a) à Área Regional!</b></h6>
                    <p class="card-text">
                        Aqui você pode acessar informações e gerenciar atividades da região. Explore recursos, eventos e relatórios regionais.
                    </p>
                </div>
            </div>
        </div>
    </div>
@elseif($instituicao->tipoInstituicao->sigla == 'D')
    <div class="row flex-fill mt-4">
        <div class="col-12 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Bem-vindo(a) à Área Distrital!</b></h6>
                    <p class="card-text">
                        Você está acessando uma área distrital. Aqui você pode:
                        <ul class="text-left" style="display: inline-block;">
                            <li>Visualizar relatórios distritais detalhados</li>
                            <li>Acessar informações financeiras do distrito</li>
                            <li>Verificar estatísticas e análises de crescimento</li>
                            <li>Acessar recursos e materiais de apoio</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
@elseif($instituicao->tipoInstituicao->sigla == 'G')
    <div class="row flex-fill mt-4">
        <div class="col-12 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Bem-vindo(a) à Área Geral!</b></h6>
                    <p class="card-text">
                        Você está acessando a área geral da instituição. Aqui você pode gerenciar informações globais, acessar relatórios gerais e muito mais.
                    </p>
                </div>
            </div>
        </div>
    </div>
@elseif($instituicao->tipoInstituicao->sigla == 'O')
    <div class="row flex-fill mt-4">
        <div class="col-12 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Bem-vindo(a) ao Órgão Geral!</b></h6>
                    <p class="card-text">
                        Você está acessando a área do órgão geral da instituição. Aqui você pode gerenciar atividades e recursos a nível de órgão.
                    </p>
                </div>
            </div>
        </div>
    </div>
@elseif($instituicao->tipoInstituicao->sigla == 'E')
    <div class="row flex-fill mt-4">
        <div class="col-12 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Bem-vindo(a) à Área de Estatísticas!</b></h6>
                    <p class="card-text">
                        Aqui você pode visualizar e analisar estatísticas detalhadas sobre a instituição. Acesse gráficos, relatórios e mais.
                    </p>
                </div>
            </div>
        </div>
    </div>
@elseif($instituicao->tipoInstituicao->sigla == 'S')
    <div class="row flex-fill mt-4">
        <div class="col-12 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Bem-vindo(a) à Secretaria!</b></h6>
                    <p class="card-text">
                        Você está acessando a área da secretaria. Aqui você pode gerenciar documentos, comunicados e outras informações importantes.
                    </p>
                </div>
            </div>
        </div>
    </div>
@else 
    <div class="row flex-fill mt-4">
        <div class="col-12 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"><b>Bem-vindo(a)!</b></h6>
                    <p class="card-text">
                        Bem-vindo(a) ao nosso sistema. Navegue pelos menus para acessar as diferentes funcionalidades disponíveis.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
</div>


<!-- Incluir scripts para os gráficos (por exemplo, Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    var ctx2 = document.getElementById('membrosChart').getContext('2d');
    var membrosChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Inativos', 'Ativos'],
            datasets: [{
                data: [{{ $totalInativos }}, {{ $totalAtivos }}],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        }
    });

    var ctx3 = document.getElementById('visitantesChart').getContext('2d');
        var visitantesChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Visitantes',
                    data: [
                        {{ $visitantesPorMes[1] }},
                        {{ $visitantesPorMes[2] }},
                        {{ $visitantesPorMes[3] }},
                        {{ $visitantesPorMes[4] }},
                        {{ $visitantesPorMes[5] }},
                        {{ $visitantesPorMes[6] }},
                        {{ $visitantesPorMes[7] }},
                        {{ $visitantesPorMes[8] }},
                        {{ $visitantesPorMes[9] }},
                        {{ $visitantesPorMes[10] }},
                        {{ $visitantesPorMes[11] }},
                        {{ $visitantesPorMes[12] }}
                    ],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

</script>
@endsection
