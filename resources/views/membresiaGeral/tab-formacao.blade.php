<div class="tab-pane fade" id="border-top-formacao" role="tabpanel" aria-labelledby="border-top-formacao">
    <div class="card-body">
        <h5 class="card-title">{{ $membro['nome'] }}</h5>
        <div class="card mb-3 mosaic">
            @if (isset($membro['formacao']))
                <p class="card-text">Formação: {{ $membro['formacao'] }}</p>
            @endif
            @if (isset($membro['instituicao']))
                <p class="card-text">Instituição: {{ $membro['instituicao'] }}</p>
            @endif
            @if (isset($membro['data_inicio']))
                <p class="card-text">Data de Início: {{ $membro['data_inicio'] }}</p>
            @endif
            @if (isset($membro['data_conclusao']))
                <p class="card-text">Data de Conclusão: {{ $membro['data_conclusao'] }}</p>
            @endif
            @if (isset($membro['observacoes']))
                <p class="card-text">Observações: {{ $membro['observacoes'] }}</p>
            @endif
            @if (
                !isset($membro['formacao']) &&
                    !isset($membro['instituicao']) &&
                    !isset($membro['data_inicio']) &&
                    !isset($membro['data_conclusao']) &&
                    !isset($membro['observacoes']))
                <span class="card-text" style="background-color: transparent; border: 0; text-shadow: none;">Sem
                    informações</span>
            @endif
        </div>
    </div>
</div>
