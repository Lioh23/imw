<!DOCTYPE html>
<html>

<head>
    <title>Relatório Livro Razão</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
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
            font-size: 16px;
            font-weight: bold;
        }

        .header .info .period {
            font-size: 14px;
        }

        .header .date {
            font-size: 10px;
            color: #555;
            text-align: right;
        }

        h4,
        h5 {
            color: #333;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            text-align: center;
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

        .green {
            color: green;
        }

        .red {
            color: red;
        }

        .blue {
            color: blue;
        }

        .total {
            font-size: 12px;
            font-weight: bold;
            text-align: right;
            padding: 10px;
        }
    </style>
</head>

<body>
<div class="header">
    <img src="{{ public_path('auth/images/login.png') }}" alt="Logotipo">
    <div class="info">
        <div class="title">LIVRO CAIXA - {{ session('session_perfil')->instituicao_nome }}</div>
        <div class="period">
            Período de {{ \Carbon\Carbon::parse(request()->input('dt_inicial'))->format('d/m/Y') }} a
            {{ \Carbon\Carbon::parse(request()->input('dt_final'))->format('d/m/Y') }}
        </div>
    </div>
    <div class="date">Data do Relatório: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
</div>

<h4 class="blue">Discriminação de saldos por caixa</h4>
<table>
    <thead>
    <tr>
        <th>CONTA/DATA/ORIGEM/DESTINO</th>
        <th></th>
        <th></th>
        <th>ENTRADA </th>
        <th class="text-right">SAÍDA</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($lancamentosPorConta as $planoConta)
        <tr style="font-weight: bold">
            <td colspan="4">{{ $planoConta->numeracao }} - {{ $planoConta->nome }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total: {{ $planoConta->lancamentosPorIgreja->whereBetween('data_lancamento', [request()->input('dt_inicial'), request()->input('dt_final')])->sum('valor') }}</td>
        </tr>
        @php
            $totalEntradas = 0;
            $totalSaidas = 0;
        @endphp

        @foreach ($planoConta->lancamentosPorIgreja->whereBetween('data_lancamento', [request()->input('dt_inicial'), request()->input('dt_final')]) as $lancamento)

            <tr>
                <td colspan="3">
                    {{ \Carbon\Carbon::parse($lancamento->data_lancamento)->format('d/m/Y') }} -
                    {{ $lancamento->caixa->descricao }} -
                    {{ $lancamento->pagante_favorecido }}
                </td>
                <td class="text-right {{ $lancamento->tipo_lancamento === 'E' ? 'green' : '' }}">
                    {{ $lancamento->tipo_lancamento === 'E' ? 'R$ ' . number_format($lancamento->valor, 2, ',', '.') : '-' }}
                </td>
                <td class="text-right {{ $lancamento->tipo_lancamento === 'S' ? 'red' : '' }}">
                    {{ $lancamento->tipo_lancamento === 'S' ? 'R$ ' . number_format($lancamento->valor, 2, ',', '.') : '-' }}
                </td>
            </tr>
            @php
                if ($lancamento->tipo_lancamento === 'E') {
                    $totalEntradas += $lancamento->valor;
                } else {
                    $totalSaidas += abs($lancamento->valor);
                }
            @endphp
        @endforeach
        <tr class="bold">
            {{-- <td>Total {{ $conta }}</td> --}}
            <td></td>
            <td></td>
            <td class="text-right">{{ number_format($totalEntradas, 2, ',', '.') }}</td>
            <td class="text-right">{{ number_format($totalSaidas, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>

</html>
