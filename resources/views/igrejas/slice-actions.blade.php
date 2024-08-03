@if(!$igreja->deleted_at && !$igreja->dt_extincao)
    {{-- Editar congregação --}}
    @if(false) // criar edição apenas para role de região
        <a  href="{{ route('igreja.editar', $igreja->id) }}" 
            title="Editar"
            class="btn btn-sm btn-dark mr-2 btn-rounded bs-tooltip">
            <x-bx-pencil />
        </a>
    @endif

    <a  href="{{ route('igreja.estatistica-ano-eclesiastico', ['igreja' => $igreja->id]) }}"
        title="Estatística do Ano Eclesiástico" 
        class="btn btn-sm btn-secondary mr-2 btn-rounded bs-tooltip">
        <x-bx-group />
    </a>
    
    <a  href="#" 
        title="Balancete" 
        class="btn btn-sm btn-primary mr-2 btn-rounded bs-tooltip">
        <x-bx-wallet />
    </a>

    <a  href="#" 
        title="Movimentação diária"
        class="btn btn-sm btn-info mr-2 btn-rounded bs-tooltip">
        <x-bx-calendar />
    </a>

@endif