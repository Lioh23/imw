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
        <div class="card mb-3 mosaic">
            @if ($membro->contato)
                <p class="card-text">
                    <span class="text-center d-block" style="font-weight: bold">
                        {{ $membro->contato->email_preferencial ?? 'Sem informação de e-mail' }}
                    </span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">E-mail</span>
                </p>
                @if (isset($membro->telefone_preferencial))
                    <p class="card-text">
                        <span class="text-center d-block" style="font-weight: bold">
                            {{ $membro->telefone_preferencial ?? 'Sem informação de e-mail' }}
                        </span>
                        <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">Telefone</span>
                    </p>
                @endif
                @if (isset($membro->cep))
                    <p class="card-text">
                        <span class="text-center d-block" style="font-weight: bold">
                            {{ $membro->cep ?? 'Sem informação de CEP' }}
                        </span>
                        <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">CEP</span>
                    </p>
                @endif
                @if (isset($membro->endereco))
                    <p class="card-text">
                        <span class="text-center d-block" style="font-weight: bold">
                            {{ $membro->endereco ?? 'Sem informação de endereço' }}
                        </span>
                        <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">Endereço</span>
                    </p>
                @endif
                @if (isset($membro->numero))
                    <p class="card-text">
                        <span class="text-center d-block" style="font-weight: bold">
                            {{ $membro->numero ?? 'Sem informação de número' }}
                        </span>
                        <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">Número</span>
                    </p>
                @endif

                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->complemento ?? 'Não informado' }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">Complemento </span>
                </p>
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->bairro ?? 'Não informado' }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">Bairro</span>
                </p>
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->cidade ?? 'Não informado' }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">Cidade</span>
                </p>
                <p class="card-text">
                    <span class="text-center d-block"
                        style="font-weight: bold">{{ $membro->uf ?? 'Não informado' }}</span>
                    <span class="text-center d-block" style="font-size: .8rem; color: #6c757d">UF</span>
                </p>
                @if (isset($membro['observacoes']))
                    <p class="card-text"> UF: {{ $membro->observacoes ?? 'Não informado' }}</p>
                @endif
            @else
                <span class="card-text">Sem informações</span>
            @endif
        </div>
    </div>
</div>
