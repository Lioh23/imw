@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Visitantes', 'url' => '/visitante/', 'active' => true]
]"></x-breadcrumb>
@endsection

@section('extras-css')
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />

<style>
    .swal2-popup .swal2-styled.swal2-cancel {
        color: white!important;
    }
</style>
@endsection

@section('extras-scripts')
<script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
@endsection

@section('content')
@include('extras.alerts')
<div class="container-fluid">
    <a href="{{ route('visitante.index') }}" class="btn btn-info position-relative mt-3 mb-3 ml-2">
        <span>VISITANTES ATIVOS</span>
        <span class="badge badge-info counter">{{ $countAtivos }}</span>
    </a>

    <a href="{{ route('visitante.index') }}?excluido=1" class="btn btn-danger position-relative mt-3 mb-3 ml-2">
        <span>VISITANTES EXCLUÍDOS</span>
        <span class="badge badge-danger counter">{{ $countExcluidos }}</span>
    </a>

   {{--  <a href="{{ route('visitante.index') }}?has_errors=1" class="btn btn-warning position-relative mt-3 mb-3 ml-2">
        <span>ERROS DE CADASTRO</span>
        <span class="badge badge-warning counter">{{ $countHasErrors }}</span>
    </a> --}}

    <a href="{{ route('visitante.novo') }}" class="btn btn-primary position-relative mt-3 mb-3 ml-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="16"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
        <span class="ml-2">INCLUIR VISITANTE</span>
    </a>

</div>
<!-- TABELA -->
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Lista de Visitantes</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <form>
                <div class="row mb-4">
                    <div class="col-4">
                        <input type="text" name="search" id="searchInput" class="form-control form-control-sm" placeholder="Pesquisar...">
                    </div>
                    <div class="col-auto" style="margin-left: -19px;">
                        <button type="submit" class="btn btn-primary btn-rounded"><x-bx-search /> Pesquisar</button>
                    </div>
                </div>
            </form>
            
            <div class="table-responsive">
                @if($visitantes->isEmpty())
                    <p>Não há visitantes cadastrados.</p>
                @else
                    <table class="table table-bordered table-striped table-hover mb-4">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>TELEFONE</th>
                                <th>E-MAIL</th>
                                <th>ATUALIZADO EM</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visitantes as $index => $visitante)
                            <tr>
                                <td>
                                    @if(!$visitante->has_errors)
                                        {{ $visitante->nome }}
                                    @else
                                        <span class="badge badge-warning"> {{ $visitante->nome }} </span>
                                    @endif
                                </td>
                                <td>
                                    {{ '(' . substr($visitante->contato->telefone_preferencial, 0, 2) . ') ' . substr($visitante->contato->telefone_preferencial, 2, 5) . '-' . substr($visitante->contato->telefone_preferencial, 7) }}
                                </td>
                                
                                <td>{{ $visitante->contato->email_preferencial }}</td>
                                <td>{{ $visitante->updated_at->format('d/m/Y H:i:s') }}</td>
                                <td class="text-center">
                                    @if (!$visitante->deleted_at)
                                        <a href="{{ route('congregado.editar', $visitante->id) }}" title="Tornar Congregado" class="btn btn-sm btn-dark mr-2 btn-rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                        </a>
                                        <a href="{{ route('visitante.editar', $visitante->id) }}" title="Editar" class="btn btn-sm btn-dark mr-2 btn-rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('visitante.deletar', $visitante->id) }}" method="POST" style="display: inline-block;" id="form_delete_visitante_{{ $index }}">
                                            @csrf
                                            <button type="button" title="Apagar" class="btn btn-sm btn-danger mr-2 btn-rounded btn-confirm-delete" data-form-id="form_delete_visitante_{{ $index }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $visitantes->links('vendor.pagination.index') }}
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $('.btn-confirm-delete').on('click', function () {
        const formId = $(this).data('form-id')
        swal({
            title: 'Deseja realmente apagar os registros deste visitante?',
            type: 'error',
            showCancelButton: true,
            confirmButtonText: "Deletar",
            confirmButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#3085d6",
            padding: '2em'
        }).then(function(result) {
            if(result.value) document.getElementById(formId).submit()
        })
    })
</script>
@endsection