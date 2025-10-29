    <button class="btn btn-sm btn-info mr-2 btn-rounded btn-visualizar bs-tooltip" title="Visualizar dados GCEU"
        data-gceu-id="{{ $gceu->id }}">
        <x-bx-show />
    </button>
    <!-- <a  href="{{ route('gceu.carta-pastoral', $gceu->id) }}"
        title="Carta Pastoral"
        class="btn btn-sm btn-primary mr-2 btn-rounded bs-tooltip">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
    </a> -->
@if (!$gceu->deleted_at)
    <a  href="{{ route('gceu.editar', $gceu->id) }}"
        title="Editar"
        class="btn btn-sm btn-dark mr-2 btn-rounded bs-tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
        </svg>
    </a>
    <form action="{{ route('gceu.deletar', $gceu->id) }}" method="POST" style="display: inline-block;" id="form_delete_gceu_{{ $gceu->id }}">
        @csrf
        <button type="button"
                title="Apagar"
                class="btn btn-sm btn-danger mr-2 btn-rounded btn-confirm-delete bs-tooltip"
                data-form-id="form_delete_gceu_{{ $gceu->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
        </button>
    </form>
@endif
