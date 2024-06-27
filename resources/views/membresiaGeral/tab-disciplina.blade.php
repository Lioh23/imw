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

<div class="tab-pane fade" id="border-top-disciplina" role="tabpanel" aria-labelledby="border-top-disciplina">
    <div class="card-body">
        <h5 class="card-title">{{ $membro['nome'] }}</h5>
        <div class="card mb-3 mosaic">
            @if (isset($membro['data_exclusao']))
                <p class="card-text">Data de Exclusão: {{ $membro['data_exclusao'] ? \Carbon\Carbon::parse($membro['data_exclusao'])->format('d/m/Y') : 'Sem informações' }}</p>
            @endif
            @if (isset($membro['motivo_exclusao']))
                <p class="card-text">Motivo da Exclusão: {{ $membro['motivo_exclusao'] }}</p>
            @endif
            @if (isset($membro['data_reconciliacao']))
                <p class="card-text">Data de Reconciliação: {{ $membro['data_reconciliacao'] ? \Carbon\Carbon::parse($membro['data_reconciliacao'])->format('d/m/Y') : 'Sem informações' }}</p>
            @endif
            @if (isset($membro['motivo_reconciliacao']))
                <p class="card-text">Motivo da Reconciliação: {{ $membro['motivo_reconciliacao'] }}</p>
            @endif
            @if (isset($membro['observacoes']))
                <p class="card-text">Observações: {{ $membro['observacoes'] }}</p>
            @endif
            @if (
                !isset($membro['data_exclusao']) &&
                    !isset($membro['motivo_exclusao']) &&
                    !isset($membro['data_reconciliacao']) &&
                    !isset($membro['motivo_reconciliacao']) &&
                    !isset($membro['observacoes']))
                <span class="card-text" style="background-color: transparent; border: 0; text-shadow: none;">Sem
                    informações</span>
            @endif
        </div>
    </div>
</div>
