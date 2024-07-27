@if(!$igreja->deleted_at && !$igreja->dt_extincao)
    {{-- Editar congregação --}}
    <a href="{{ route('igreja.editar', $congregacao->id) }}" 
        title="Editar"
        class="btn btn-sm btn-dark mr-2 btn-rounded bs-tooltip">
        <x-bx-pencil />
    </a>

    {{-- desativar igreja --}}
    <form action="{{ route('igreja.desativar', $igreja->id) }}" method="POST" style="display: inline-block;" id="form_desativar_igreja_{{ $igreja->id }}">
        @csrf
        @method('DELETE')
        <button type="button" 
                title="Apagar" 
                class="btn btn-sm btn-danger mr-2 btn-rounded btn-confirm-delete bs-tooltip"
                data-form-id="form_desativar_igreja_{{ $igreja->id }}">
           <x-bx-power-off />
        </button>
    </form>
@else
    {{-- restaurar igreja --}}
    <form action="{{ route('igreja.restaurar', $igreja->id) }}" method="POST" style="display: inline-block;" id="form_restaurar_igreja_{{ $igreja->id }}">
        @csrf
        @method('PUT')
        <button type="button" 
                title="Restaurar" 
                class="btn btn-sm btn-success mr-2 btn-rounded btn-confirm-restore bs-tooltip"
                data-form-id="form_restaurar_igreja_{{ $igreja->id }}">
            <x-bx-power-off />
        </button>
    </form>
@endif