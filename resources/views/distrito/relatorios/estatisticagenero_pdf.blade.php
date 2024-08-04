<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Estatística por Gênero - IMW PGA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            height: 50px;
            display: block;
            margin: 0 auto;
        }

        .header .info {
            text-align: left;
            margin-top: 10px;
        }

        .header .info .title {
            font-size: 12px;
            font-weight: bold;
        }

        .header .info .period {
            font-size: 10px;
        }

        .header .date {
            font-size: 8px;
            color: #555;
            text-align: right;
        }

        h4,
        h5 {
            color: #333;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 12px;
        }

        th,
        td {
            padding: 4px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

@php
use Carbon\Carbon;
@endphp

<body>
    <div class="header">
        <img src="{{ public_path('auth/images/login.png') }}" alt="Logotipo">
        <div class="info">
            <div class="title">ESTATÍSTICA POR GÊNERO - {{ session('session_perfil')->instituicao_nome }}</div>
            <div class="period">
                Período de {{ \Carbon\Carbon::parse(request()->input('data_inicial'))->format('d/m/Y') }}
                a {{ \Carbon\Carbon::parse(request()->input('data_final'))->format('d/m/Y') }}
            </div>
        </div>
        <div class="date">Data do Relatório: {{ \Carbon\Carbon::now()->format('m/Y') }}</div>
    </div>

    <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: left">IGREJA</th>
                <th width="100px" style="text-align: left">MASCULINO</th>
                <th width="100px" style="text-align: left">FEMININO</th>
                <th width="100px" style="text-align: left">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalMasculino = 0;
            $totalFeminino = 0;
            $totalGeral = 0;
            @endphp

            @foreach($lancamentos as $lancamento)
            <tr>
                <td style="text-align: left; min-width: 250px;">{{ $lancamento->nome }}</td>
                <td style="text-align: left; min-width: 250px;">{{ $lancamento->total_masculino }}</td>
                <td style="text-align: left; min-width: 250px;">{{ $lancamento->total_feminino }}</td>
                <td style="text-align: left; min-width: 50px;">{{ $lancamento->total }}</td>
            </tr>
            @php
            $totalMasculino += $lancamento->total_masculino;
            $totalFeminino += $lancamento->total_feminino;
            $totalGeral += $lancamento->total;
            @endphp
            @endforeach

            <tr>
                <th style="text-align: left">TOTAL GERAL</th>
                <th width="100px" style="text-align: left">{{ $totalMasculino }}</th>
                <th width="100px" style="text-align: left">{{ $totalFeminino }}</th>
                <th width="100px" style="text-align: left">{{ $totalGeral }}</th>
            </tr>
        </tbody>
    </table>

</body>

</html>