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

<div class="tab-pane fade" id="border-top-familia" role="tabpanel" aria-labelledby="border-top-familiar">
    <div class="card-body">
        <h5 class="card-title">{{ $membro['nome'] }}</h5>
        <div class="card mb-3 mosaic">
            @if (isset($membro['pai_nome']))
                <p class="card-text">Nome do Pai: {{ $membro['pai_nome'] }}</p>
            @endif
            @if (isset($membro['mae_nome']))
                <p class="card-text">Nome da Mãe: {{ $membro['mae_nome'] }}</p>
            @endif
            @if (isset($membro['conjuge_nome']))
                <p class="card-text">Nome do Cônjuge: {{ $membro['conjuge_nome'] }}</p>
            @endif
            @if (isset($membro['filhos']))
                <p class="card-text">Data do Casamento: {{ $membro['filhos'] }}</p>
            @endif
            @if (isset($membro['histórico_familiar']))
                <p class="card-text">Quantidade de Filhos: {{ $membro['histórico_familiar'] }}</p>
            @endif
            @if (isset($membro['data_Casamento']))
                <p class="card-text">Aniversário de Casamento: {{ $membro['data_Casamento'] }}</p>
            @endif
            @if (
                !isset($membro['pai_nome']) &&
                    !isset($membro['mae_nome']) &&
                    !isset($membro['conjuge_nome']) &&
                    !isset($membro['filhos']) &&
                    !isset($membro['histórico_familiar']) &&
                    !isset($membro['data_Casamento']))
                <span class="card-text" style="background-color: transparent; border: 0; text-shadow: none;">Sem
                    informações</span>
            @endif
        </div>
    </div>
</div>
