@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Secretaria', 'url' => '/', 'active' => false],
        ['text' => 'Membros', 'url' => '/membros/', 'active' => true],
    ]">
    </x-breadcrumb>
@endsection

@section('extras-css')
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

<style>
    .swal2-popup .swal2-styled.swal2-cancel {
        color: white!important;
    }
</style>
@endsection

@include('extras.alerts')

@section('content')
    <div class="container-fluid">
        <a href="{{ route('membro.index') }}" class="btn btn-info position-relative mt-3 mb-3 ml-2">
            <span>ROL ATUAL</span>
            <span class="badge badge-info counter">{{ $countAtual }}</span>
        </a>

        <a href="{{ route('membro.index') }}?rol_permanente=1" class="btn btn-danger position-relative mt-3 mb-3 ml-2">
            <span>ROL PERMANENTE</span>
            <span class="badge badge-danger counter">{{ $countPermanente }}</span>
        </a>

        <a href="{{ route('membro.index') }}?has_errors=1" class="btn btn-warning position-relative mt-3 mb-3 ml-2">
            <span>ERROS DE CADASTRO</span>
            <span class="badge badge-warning counter">{{ $countHasErrors }}</span>
        </a>
    </div>
    <!-- TABELA -->
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Lista de Membros</h4>
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
                    <table class="table table-bordered table-striped table-hover mb-4" id="datatable" data-url="{{ route('membro.list') }}">
                        <thead>
                            <tr>
                                <th>ROL</th>
                                <th>NOME</th>
                                <th>RECEPÇÃO</th>
                                <th>EXCLUSÃO</th>
                                <th>CONGREGAÇÃO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                         
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/table/datatable/datatables.js') }}"></script>
    <script>
        $('.btn-confirm-delete').on('click', function () {
            const formId = $(this).data('form-id')
            swal({
                title: 'Deseja realmente apagar os registros deste membro?',
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
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: $('#datatable').data('url'),
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nome', name: 'nome'},
                {data: 'created_at', name: 'created_at'},
                {data: 'deleted_at', name: 'deleted_at'},
                {data: 'congregacao_id', name: 'congregacao_id'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });
    </script>
@endsection