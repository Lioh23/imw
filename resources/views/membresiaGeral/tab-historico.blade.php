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
<div class="tab-pane fade" id="border-top-historico" role="tabpanel" aria-labelledby="border-top-historico">
    <div class="card-body">
        <h5 class="card-title">{{ $membro['nome'] }}</h5>
        <div class="card mb-3 mosaic">
            @if (isset($membro['rol_permanente']))
                <p class="card-text">Rol Permanente: {{ $membro['rol_permanente'] }}</p>
            @endif
            @if (isset($membro['data_rol']))
                <p class="card-text">Data de Rol: {{ $membro['data_rol'] }}</p>
            @endif
            @if (isset($membro['igreja_rol']))
                <p class="card-text">Igreja do Rol: {{ $membro['igreja_rol'] }}</p>
            @endif
            @if (isset($membro['observacoes']))
                <p class="card-text">Observações: {{ $membro['observacoes'] }}</p>
            @endif
            @if (
                !isset($membro['rol_permanente']) &&
                    !isset($membro['data_rol']) &&
                    !isset($membro['igreja_rol']) &&
                    !isset($membro['observacoes']))
                <span class="card-text" style="background-color: transparent; border: 0; text-shadow: none;">Sem
                    informações</span>
            @endif
        </div>
    </div>
</div>
