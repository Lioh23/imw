<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Quantidade de Membros - IMW PGA</title>
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
            <div class="title">QUANTIDADE DE MEMBROS - {{ session('session_perfil')->instituicao_nome }}</div>
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
                <th style="text-align: left" >IGREJA</th>
                <th style="text-align: left" width="100px;" >TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalGeral = 0;
            @endphp
            @foreach($lancamentos as $lancamento)
            <tr>
                <td style="text-align: left;">{{ $lancamento->nome }}</td>
                <td style="text-align: left;">{{ $lancamento->total }}</td>
                @php
                $totalGeral += $lancamento->total;
                @endphp
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align: left;">Total Geral</th>
                <th style="text-align: left;">{{ $totalGeral }}</th>
            </tr>
        </tfoot>
    </table>

</body>

</html>