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
<div class="tab-pane fade" id="border-top-ministerio" role="tabpanel" aria-labelledby="border-top-ministerial">
    <div class="card-body">
        <h5 class="card-title">{{ $membro->nome }}</h5>
        <div class="card mb-3 mosaic">
            @if (isset($membro['funcoes_ministeriais']))
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->funcoes_ministeriais }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">
                        Funções Ministeriais
                    </span>
                </p>
            @endif
            @if (isset($membro['data_ordenacao']))
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->data_ordenacao }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">
                        Data de Ordenação
                    </span>
                </p>
            @endif
            @if (isset($membro['local_ordenacao']))
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->local_ordenacao }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">
                        Local de Ordenação
                    </span>
                </p>
            @endif
            @if (isset($membro['ministerio']))
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->ministerio }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">
                        Ministério
                    </span>
                </p>
            @endif
            @if (isset($membro['data_ministerio']))
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->data_ministerio }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">
                        Data do Ministério
                    </span>
                </p>
            @endif
            @if (isset($membro['local_ministerio']))
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->local_ministerio }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">
                        Local do Ministério
                    </span>
                </p>
            @endif
            @if (isset($membro['observacoes']))
                <p class="card-text">
                    <span class="text-center d-block" style="font-weight: bold">
                        {{ $membro->observacoes }}
                    </span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">Observações</span>
                </p>
            @endif
            @if (
                !isset($membro->funcoes_ministeriais) &&
                    !isset($membro->data_ordenacao) &&
                    !isset($membro->local_ordenacao) &&
                    !isset($membro->ministerio) &&
                    !isset($membro->data_ministerio) &&
                    !isset($membro->local_ministerio) &&
                    !isset($membro->observacoes))
                <span class="card-text" style="background-color: transparent; border: 0; text-shadow: none;">Sem
                    informações
                </span>
            @endif
        </div>
    </div>
</div>
