@if(!$congregacao->deleted_at)
    <a href="{{ route('congregacao.editar', $congregacao->id) }}" 
        title="Editar"
        class="btn btn-sm btn-dark mr-2 btn-rounded bs-tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-edit-2">
            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
        </svg>
    </a>
@else
    <a  href="{{ route('congregacao.restaurar', $congregacao->id) }}" 
        title="restaura congregação" 
        class="btn btn-sm btn-secondary mr-2 btn-rounded bs-tooltip">
        <x-bx-log-in-circle />
    </a>
@endif