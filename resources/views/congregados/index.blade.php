@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Congregados', 'url' => '/congregado/', 'active' => true]
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
    <a href="{{ route('congregado.index') }}" class="btn btn-info position-relative mt-3 mb-3 ml-2">
        <span>CONGREGADOS ATIVOS</span>
        <span class="badge badge-info counter">{{ $countAtivos }}</span>
    </a>

    <a href="{{ route('congregado.index') }}?excluido=1" class="btn btn-danger position-relative mt-3 mb-3 ml-2">
        <span>CONGREGADOS EXCLUÍDOS</span>
        <span class="badge badge-danger counter">{{ $countExcluidos }}</span>
    </a>

    <a href="{{ route('congregado.index') }}?has_errors=1" class="btn btn-warning position-relative mt-3 mb-3 ml-2">
        <span>ERROS DE CADASTRO</span>
        <span class="badge badge-warning counter">{{ $countHasErrors }}</span>
    </a>

    <a href="{{ route('congregado.novo') }}" class="btn btn-primary position-relative mt-3 mb-3 ml-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="16"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
        <span class="ml-2">INCLUIR CONGREGADO</span>
    </a>

</div>
<!-- TABELA -->
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Lista de Congregados</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <form class="row mb-4">
                <div class="col-4">
                    <input type="text" name="search" id="searchInput" class="form-control form-control-sm" placeholder="Pesquisar...">
                </div>
                <div class="col-auto" style="margin-left: -19px;">
                    <button type="submit" id="searchButton" class="btn btn-primary btn-rounded"><x-bx-search /> Pesquisar</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-4">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>CONGREGAÇÃO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($congregados as $index => $congregado)
                            <tr>
                                <td>
                                    @if(!$congregado->has_errors)
                                        {{ $congregado->nome }}
                                    @else
                                        <span class="badge badge-warning"> {{ $congregado->nome }} </span>
                                    @endif
                                </td>
                                <td>{{ optional($congregado->congregacao)->nome }}</td>
                                <td class="text-center">
                                    <a href="{{ route('membro.receber_novo', ['id' => $congregado->id]) }}" title="Receber congregado como Membro" class="btn btn-sm btn-dark mr-2 btn-rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                    </a>
                                    <a href="{{ route('congregado.editar', $congregado->id) }}" title="Editar" class="btn btn-sm btn-dark mr-2 btn-rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    </a>
                                    <form action="{{ route('congregado.deletar', $congregado->id) }}" method="POST" style="display: none;" id="form_delete_congregado_{{ $index }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button title="Apagar" class="btn btn-sm btn-danger mr-2 btn-rounded btn-confirm-delete" data-form-id="form_delete_congregado_{{ $index }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $congregados->links('vendor.pagination.index') }}
            </div>
        </div>
    </div>
</div>

<script>
    $('.btn-confirm-delete').on('click', function () {
        const formId = $(this).data('form-id')
        swal({
            title: 'Deseja realmente apagar os registros deste congregado?',
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
<script>
    $(document).ready(function(){
        $('#cep').blur(function(){
            var cep = $(this).val().replace(/\D/g, '');
            if(cep.length != 8){
                return;
            }
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data){
                if(!("erro" in data)){
                    $('#endereco').val(data.logradouro);
                    // Preencha os outros campos de endereço aqui, se necessário
                    $('#bairro').val(data.bairro);
                    $('#cidade').val(data.localidade);
                    $('#estado').val(data.uf);
                }else{
                    alert('CEP não encontrado.');
                }
            });
        });
    });
    </script>
@endsection
