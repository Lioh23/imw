<div class=" card tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel"
    aria-labelledby="border-top-dados-pessoais">
    <div class="card-body">
        <h5 class="card-title">{{ $membro['nome'] }}</h5>
        <div class="card mb-3 border-0">
            @if (isset($membro['data_nascimento']))
                <p type='date' class="card-text"> Data de Nascimento:
                    {{ old('data_nascimento', optional($membro['data_nascimento'])->format('d/m/Y')) }}
                </p>
            @endif
            @if (isset($membro['cpf']))
                <p class="card-text"> CPF: {{ $membro['cpf'] }}</p>
            @endif
            @if (isset($membro['sexo']))
                <p class="card-text"> sexo:
                    {{ $membro['sexo'] === 'F' ? 'feminino' : ($membro['sexo'] === 'M' ? 'masculino' : 'outro') }}</p>
            @endif
            @if (isset($membro['estado_civil']))
                <p class="card-text"> Estado civil: {{ $membro['estado_civil'] === 'S' ? 'Solteiro' : 'Casado' }}</p>
            @endif
            @if (isset($membro['nacionalidade']))
                <p class="card-text"> Nacionalidade: {{ $membro['nacionalidade'] }}</p>
            @endif
            @if (isset($membro['naturalidade']))
                <p class="card-text"> Naturalidade: {{ $membro['naturalidade'] }}</p>
            @endif
            @if (isset($membro['uf']))
                <p class="card-text">UF :{{ $membro['uf'] }}</p>
            @endif
            @if (isset($membro['escolaridade']))
                <p class="card-text">Escolaridade: {{ $membro['escolaridade'] }}</p>
            @endif
            @if (isset($membro['profissao']))
                <p class="card-text">Profissão: {{ $membro['profissao'] }}</p>
            @endif
            @if (isset($membro['Função Eclesiástica']))
                <p class="card-text">Função Eclesiástica {{ $membro['Função Eclesiástica'] }}</p>
            @endif
            @if (isset($membro['rg']))
                <p class="card-text">RG: {{ $membro['rg'] }}</p>
            @elseif(isset($membro['cnh']))
                <p class="card-text">CNH: {{ $membro['cnh'] }}</p>
            @endif
            @if (isset($membro['documento']))
                <p class="card-text">Documento {{ $membro['documento'] }}</p>
            @endif
            @if (isset($membro['documento_complemento']))
                <p class="card-text">Documento Complemento {{ $membro['documento_complemento'] }}</p>
            @endif
            @if (isset($membro['data_conversao']))
                <p class="card-text"> data de conversão {{ $membro['data_conversao'] }}</p>
            @endif
            @if (isset($membro['data_batismo']))
                <p class="card-text"> Data de Batismo {{ $membro['data_batismo'] }}</p>
            @endif
            @if (isset($membro['data_batismo_espirito']))
                <p class="card-text">Data de Batismo Espirito Santo {{ $membro['data_batismo_espirito'] }}</p>
            @endif
            @if (isset($membro['historico']))
                <p class="card-text">Data de Batismo Espirito Santo {{ $membro['historico'] }}</p>
            @endif
            @if (isset($membro['congregacao_id']))
                <p class="card-text">congregacao {{ $membro['congregacao_id']['nome'] }}</p>
            @endif
        </div>
    </div>
</div>
