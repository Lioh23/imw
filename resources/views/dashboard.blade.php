@extends('template.layout')

@section('content')
<div class="container-fluid h-100">
     <div class="row flex-fill mt-4">
        <!-- Card de Membros -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Membros</h6>
                    <p class="card-text">Total: 200</p>
                </div>
            </div>
        </div>

        <!-- Card de Contribuições -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Contribuições</h6>
                    <p class="card-text">Total: R$ 10.000,00</p>
                </div>
            </div>
        </div>

        <!-- Card de Eventos -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Eventos</h6>
                    <p class="card-text">Total: 5</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row flex-fill mt-4">
        <!-- Gráfico de Contribuições Mensais -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Gráfico de Contribuições Mensais</h6>
                    <canvas id="contribuicoesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Membros Ativos vs Inativos -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Gráfico de Membros Ativos vs Inativos</h6>
                    <canvas id="membrosChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row flex-fill mt-4">
        <!-- Gráfico de Eventos por Mês -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Gráfico de Eventos por Mês</h6>
                    <canvas id="eventosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Doações por Categoria -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Gráfico de Doações por Categoria</h6>
                    <canvas id="doacoesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir scripts para os gráficos (por exemplo, Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dados dos gráficos
    var ctx1 = document.getElementById('contribuicoesChart').getContext('2d');
    var contribuicoesChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Contribuições',
                data: [2000, 2200, 2100, 2300, 2400, 2500],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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

    var ctx2 = document.getElementById('membrosChart').getContext('2d');
    var membrosChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Ativos', 'Inativos'],
            datasets: [{
                data: [150, 50],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        }
    });

    var ctx3 = document.getElementById('eventosChart').getContext('2d');
    var eventosChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Eventos',
                data: [2, 3, 4, 3, 5, 4],
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

    var ctx4 = document.getElementById('doacoesChart').getContext('2d');
    var doacoesChart = new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: ['Dízimos', 'Ofertas', 'Missões'],
            datasets: [{
                data: [5000, 3000, 2000],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }]
        }
    });
</script>
@endsection
