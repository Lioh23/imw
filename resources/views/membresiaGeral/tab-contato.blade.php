<Style>
    .mosaic {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
        padding: 20px;
        background-color: #f0f0f0;
    }

    .mosaic p {
        background-color: white;
        border: 1px solid #ccc;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        border-radius: 10px;
    }
</Style>

<div class="tab-pane fade" id="border-top-contato" role="tabpanel" aria-labelledby="border-top-contatos">
    <div class="card-body">
        <h5 class="card-title">{{ $membro['nome'] }}</h5>
        <div class="card mb-3 mosaic">
            @if (isset($membro['email_preferencial']))
                <p class="card-text"> E-mail: {{ $membro['email'] }}</p>
            @endif
            @if (isset($membro['telefone_preferencial']))
                <p class="card-text"> Telefone: {{ $membro['telefone_preferencial'] }}</p>
            @endif
            @if (isset($membro['telefone_whatsapp']))
                <p class="card-text"> Número: {{ $membro['telefone_whatsapp'] }}</p>
            @endif
            @if (isset($membro['cep']))
                <p class="card-text"> CEP: {{ $membro['cep'] }}</p>
            @endif
            @if (isset($membro['endereco']))
                <p class="card-text"> Celular: {{ $membro['endereco'] }}</p>
            @endif
            @if (isset($membro['numero']))
                <p class="card-text"> numero: {{ $membro['numero'] }}</p>
            @endif
            @if (isset($membro['complemento']))
                <p class="card-text"> Complemento: {{ $membro['complemento'] }}</p>
            @endif
            @if (isset($membro['bairro']))
                <p class="card-text"> Bairro: {{ $membro['bairro'] }}</p>
            @endif
            @if (isset($membro['cidade']))
                <p class="card-text"> Cidade: {{ $membro['cidade'] }}</p>
            @endif
            @if (isset($membro['estado']))
                <p class="card-text"> UF: {{ $membro['estado'] }}</p>
            @endif
            @if (isset($membro['observacoes']))
                <p class="card-text"> UF: {{ $membro['observacoes'] }}</p>
            @endif
            @if (
                !isset($membro['email_preferencial']) &&
                    !isset($membro['telefone_preferencial']) &&
                    !isset($membro['telefone_whatsapp']) &&
                    !isset($membro['cep']) &&
                    !isset($membro['endereco']) &&
                    !isset($membro['numero']) &&
                    !isset($membro['complemento']) &&
                    !isset($membro['bairro']) &&
                    !isset($membro['cidade']) &&
                    !isset($membro['estado']) &&
                    !isset($membro['observacoes']))
                <span class="card-text">Sem informações</span>
            @endif
        </div>
    </div>
</div>
