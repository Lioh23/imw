<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Lançamento das Igrejas - IMW PGA</title>
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
            <div class="title">LANÇAMENTOS DAS IGREJAS - {{ session('session_perfil')->instituicao_nome }}</div>
            <div class="period" style="margin-top:4px">
                Ano: {{ request()->input('dtano') }}
            </div>
        </div>
        <div class="date">Data do Relatório: {{ \Carbon\Carbon::now()->format('m/Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <!--          <th width="100">DISTRITO</th> -->
                <th width="100">IGREJA</th>
                <th width="30" class="text-right">JAN</th>
                <th width="30" class="text-right">FEV</th>
                <th width="30" class="text-right">MAR</th>
                <th width="30" class="text-right">ABR</th>
                <th width="30" class="text-right">MAI</th>
                <th width="30" class="text-right">JUN</th>
                <th width="30" class="text-right">JUL</th>
                <th width="30" class="text-right">AGO</th>
                <th width="30" class="text-right">SET</th>
                <th width="30" class="text-right">OUT</th>
                <th width="30" class="text-right">NOV</th>
                <th width="30" class="text-right">DEZ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lancamentos as $lancamento)
            <tr>
                <!--                 <td>{{ $lancamento->instituicao_pai_nome}}</td> -->
                <td>{{ $lancamento->instituicao_nome }}</td>
                <td style="text-align: right">{{ $lancamento->janeiro }}</td>
                <td style="text-align: right">{{ $lancamento->fevereiro }}</td>
                <td style="text-align: right">{{ $lancamento->marco }}</td>
                <td style="text-align: right">{{ $lancamento->abril }}</td>
                <td style="text-align: right">{{ $lancamento->maio }}</td>
                <td style="text-align: right">{{ $lancamento->junho }}</td>
                <td style="text-align: right">{{ $lancamento->julho }}</td>
                <td style="text-align: right">{{ $lancamento->agosto }}</td>
                <td style="text-align: right">{{ $lancamento->setembro }}</td>
                <td style="text-align: right">{{ $lancamento->outubro }}</td>
                <td style="text-align: right">{{ $lancamento->novembro }}</td>
                <td style="text-align: right">{{ $lancamento->dezembro }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>