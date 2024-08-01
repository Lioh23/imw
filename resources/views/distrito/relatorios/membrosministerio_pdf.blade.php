<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Membros por Ministério - IMW PGA</title>
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
            <div class="title">MEMBROS POR MINISTÉRIO - {{ session('session_perfil')->instituicao_nome }}</div>
            <div class="period" style="margin-top:4px">
                Ano: {{ request()->input('dtano') }}
            </div>
        </div>
        <div class="date">Data do Relatório: {{ \Carbon\Carbon::now()->format('m/Y') }}</div>
    </div>

    <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
        <thead class="thead-dark">
            <tr>
                <th width="300" style="text-align: left">IGREJA</th>
                <th width="50" style="text-align: right">KIDS</th>
                <th width="50" style="text-align: right">CONEXÃO</th>
                <th width="50" style="text-align: right">FIRE</th>
                <th width="50" style="text-align: right">MOVE</th>
                <th width="50" style="text-align: right">HOMENS</th>
                <th width="50" style="text-align: right">Mulheres</th>
                <th width="50" style="text-align: right">60+</th>
                <th width="50" style="text-align: right">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalKids = 0;
            $totalConexao = 0;
            $totalFire = 0;
            $totalMove = 0;
            $totalHomens = 0;
            $totalMulheres = 0;
            $total60 = 0;
            $totalGeral = 0;
            @endphp
            @foreach($lancamentos as $lancamento)
            @php
            $totalKids += $lancamento->Kids;
            $totalConexao += $lancamento->Conexao;
            $totalFire += $lancamento->Fire;
            $totalMove += $lancamento->Move;
            $totalHomens += $lancamento->Homens;
            $totalMulheres += $lancamento->Mulheres;
            $total60 += $lancamento->{'60+'};
            $totalGeral += $lancamento->Kids + $lancamento->Conexao + $lancamento->Fire + $lancamento->Move + $lancamento->Homens + $lancamento->Mulheres + $lancamento->{'60+'};
            @endphp
            <tr>
                <td style="text-align: left">{{ $lancamento->nome }}</td>
                <td style="text-align: right">{{ $lancamento->Kids }}</td>
                <td style="text-align: right">{{ $lancamento->Conexao }}</td>
                <td style="text-align: right">{{ $lancamento->Fire }}</td>
                <td style="text-align: right">{{ $lancamento->Move }}</td>
                <td style="text-align: right">{{ $lancamento->Homens }}</td>
                <td style="text-align: right">{{ $lancamento->Mulheres }}</td>
                <td style="text-align: right">{{ $lancamento->{'60+'} }}</td>
                <td style="text-align: right">{{ $lancamento->Kids + $lancamento->Conexao + $lancamento->Fire + $lancamento->Move + $lancamento->Homens + $lancamento->Mulheres + $lancamento->{'60+'} }}</td>
            </tr>
            @endforeach
            <tr class="thead-dark">
                <th style="text-align: left">ROL ATUAL [{{request()->input('dtano')}}]</th>
                <th style="text-align: right">{{ $totalKids }}</th>
                <th style="text-align: right">{{ $totalConexao }}</th>
                <th style="text-align: right">{{ $totalFire }}</th>
                <th style="text-align: right">{{ $totalMove }}</th>
                <th style="text-align: right">{{ $totalHomens }}</th>
                <th style="text-align: right">{{ $totalMulheres }}</th>
                <th style="text-align: right">{{ $total60 }}</th>
                <th style="text-align: right">{{ $totalGeral }}</th>
            </tr>
        </tbody>
    </table>

</body>

</html>