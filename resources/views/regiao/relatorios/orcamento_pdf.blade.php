<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Orçamentos - IMW PGA</title>
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

<body>
    <div class="header">
        <img src="{{ public_path('auth/images/login.png') }}" alt="Logotipo">
        <div class="info">
            <div class="title">ORÇAMENTO - {{ request()->input('distrito') != 'all' ? $instituicao->nome : 'Todos os Distritos' }}</div>
            <div class="period" style="margin-top:4px">
                Ano: {{ request()->input('dtano') }}
            </div>
        </div>
        <div class="date">Data do Relatório: {{ \Carbon\Carbon::now()->format('m/Y') }}</div>
    </div>

    <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
    <thead class="thead-dark">
        <tr>
            <th width="110px" style="text-align: left">DISTRITO</th>
            <th width="180px" style="text-align: left">IGREJA</th>
            <th width="50px" style="text-align: right">JAN</th>
            <th width="50px" style="text-align: right">FEV</th>
            <th width="50px" style="text-align: right">MAR</th>
            <th width="50px" style="text-align: right">ABR</th>
            <th width="50px" style="text-align: right">MAI</th>
            <th width="50px" style="text-align: right">JUN</th>
            <th width="50px" style="text-align: right">JUL</th>
            <th width="50px" style="text-align: right">AGO</th>
            <th width="50px" style="text-align: right">SET</th>
            <th width="50px" style="text-align: right">OUT</th>
            <th width="50px" style="text-align: right">NOV</th>
            <th width="50px" style="text-align: right">DEZ</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalJaneiro = 0;
            $totalFevereiro = 0;
            $totalMarco = 0;
            $totalAbril = 0;
            $totalMaio = 0;
            $totalJunho = 0;
            $totalJulho = 0;
            $totalAgosto = 0;
            $totalSetembro = 0;
            $totalOutubro = 0;
            $totalNovembro = 0;
            $totalDezembro = 0;
        @endphp
        @foreach($lancamentos as $lancamento)
            <tr>
                <td>{{ $lancamento->distrito_nome }}</td>
                <td>{{ $lancamento->instituicao_nome }}</td>
                <td style="text-align: right">{{ number_format($lancamento->janeiro, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->fevereiro, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->marco, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->abril, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->maio, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->junho, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->julho, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->agosto, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->setembro, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->outubro, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->novembro, 2, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($lancamento->dezembro, 2, ',', '.') }}</td>
            </tr>
            @php
                $totalJaneiro += $lancamento->janeiro;
                $totalFevereiro += $lancamento->fevereiro;
                $totalMarco += $lancamento->marco;
                $totalAbril += $lancamento->abril;
                $totalMaio += $lancamento->maio;
                $totalJunho += $lancamento->junho;
                $totalJulho += $lancamento->julho;
                $totalAgosto += $lancamento->agosto;
                $totalSetembro += $lancamento->setembro;
                $totalOutubro += $lancamento->outubro;
                $totalNovembro += $lancamento->novembro;
                $totalDezembro += $lancamento->dezembro;
            @endphp
        @endforeach
        <tr class="font-weight-bold">
            <td>Totais</td>
            <td style="text-align: right">{{ number_format($totalJaneiro, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalFevereiro, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalMarco, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalAbril, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalMaio, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalJunho, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalJulho, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalAgosto, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalSetembro, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalOutubro, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalNovembro, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalDezembro, 2, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

</body>

</html>