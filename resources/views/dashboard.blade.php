@extends('template.layout')
@section('extras-css')
<style>
     .chart-container {
            position: relative;
            height: 400px; /* Ajuste a altura conforme necessário */
        }
</style>
@endsection

@section('content')
<div class="container-fluid h-100">
     <div class="row flex-fill mt-4">
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
