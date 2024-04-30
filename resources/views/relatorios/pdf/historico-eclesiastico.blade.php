<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HISTÓRICO ECLESIÁSTICO - IMW PGA</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        
        h2 {
            text-transform: uppercase;
            margin-bottom: 2rem;
        }

        h4 {
            margin-bottom: .5rem;
        } 

        table {
            margin-top: 2rem;
            border-collapse: collapse
        }

        th, td {
            padding: 8px 0;
            border-bottom: 1px solid black;
            text-align: left;
            font-size: .9rem;
        }
    </style>
</head>
<body>
    <header>
        <div style="text-align: center; margin-bottom: 1rem;">
        <small style="text-transform: uppercase">
                IMW PGA {{ date('Y') }} - {{ session()->get('session_perfil')->instituicoes->igrejaLocal->nome }}
            </small>
        </div>
    </header>

    <h2>HISTÓRIOCO ECLESIÁSCITO - {{ $membroEclesiastico->nome }}</h2>

    <table>
        <thead>
            <tr>
              <th style="width: 5%">ROL</th>
              <th style="width: 40%">NOME</th>
              <th style="width: 20%">MINISTERIO</th>
              <th style="width: 20%">FUNÇÃO</th>
              <th style="width: 12.5%">NOMEAÇÃO</th>
              <th style="width: 12.5%">EXONERAÇÃO</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($historicoEclesiastico as $historico)
            <tr>
                <td>{{ $membroEclesiastico->rol_atual }}</td>
                <td>{{ $membroEclesiastico->nome }}</td>
                <td>{{ $historico->ministerio->descricao }}</td>
                <td>{{ $historico->tipoAtuacao->descricao }}</td>
                <td>{{ $historico->data_entrada->format('d/m/Y') }}</td>
                <td>{{ optional($historico->data_saida)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center">Não existem registros para este membro</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>