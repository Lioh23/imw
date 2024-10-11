@if(!$igreja->deleted_at && !$igreja->dt_extincao)
    {{-- Editar congregação --}}
    @if(false) // criar edição apenas para role de região
        <a  href="{{ route('igrejas.regiao.editar', $igreja->id) }}" 
            title="Editar"
            class="btn btn-sm btn-dark mr-2 btn-rounded bs-tooltip">
            <x-bx-pencil />
        </a>
    @endif

    {{-- Igreja-Região porém estamos reutilizando o mesmo link de igrejas--}}

    <a  href="{{ route('igreja.estatistica-ano-eclesiastico', ['igreja' => $igreja->id]) }}"
        title="Estatística do Ano Eclesiástico" 
        class="btn btn-sm btn-secondary mr-2 btn-rounded bs-tooltip">
        <x-bx-group />
    </a>
    
    <a  href="{{ route('igreja.balancete', ['igreja' => $igreja->id]) }}" 
        title="Balancete" 
        class="btn btn-sm btn-primary mr-2 btn-rounded bs-tooltip">
        <x-bx-wallet />
    </a>

    <a  href="{{ route('igreja.movimento-diario', ['igreja' => $igreja->id]) }}" 
        title="Movimentação diária"
        class="btn btn-sm btn-info mr-2 btn-rounded bs-tooltip">
        <x-bx-calendar />
    </a>

    <a  href="{{ route('igreja.livrorazao', ['igreja' => $igreja->id]) }}" 
        title="Livro Razão"
        class="btn btn-sm btn-success mr-2 btn-rounded bs-tooltip">
        <x-bx-book-alt />
    </a>
@endif