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
    <link href="{{ asset('theme/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white!important;
        }
    </style>
@endsection

@section('content')
@include('extras.alerts')
<div class="container-fluid d-flex justify-content-between">
    {{-- esquerda --}}
    <div>
        <a href="{{ route('congregado.novo') }}" class="btn btn-primary position-relative mt-3 mb-3 ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            <span class="ml-2">INCLUIR CONGREGADO</span>
        </a>
    </div>

    {{-- direita --}}
    <div>
        <span class="badge badge-info position-relative mt-3 mb-3 ml-2">
            <span>CONGREGADOS ATIVOS: {{ $countAtivos }}</span>
        </span>
    
        <span class="badge badge-danger position-relative mt-3 mb-3 ml-2">
            <span>CONGREGADOS EXCLUÍDOS: {{ $countExcluidos }}</span>
        </span>
    
        <span class="badge badge-warning position-relative mt-3 mb-3 ml-2">
            <span>ERROS DE CADASTRO: {{ $countHasErrors }}</span>
        </span>
    </div>

    

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
            <form class="row mb-5" id="searchForm">
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <div class="n-chk">
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                                <input type="radio" name="status" value="ativo" class="new-control-input" 
                                       {{ request()->input('status') == 'ativo' || request()->input('status') == null ? 'checked' : '' }}>
                                <span class="new-control-indicator"></span>Ativos
                            </label>
                        </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <div class="n-chk">
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                                <input type="radio" name="status" value="inativo" class="new-control-input"
                                       {{ request()->input('status') == 'inativo' ? 'checked' : '' }}>
                                <span class="new-control-indicator"></span>Inativos
                            </label>
                        </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <div class="n-chk">
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                                <input type="radio" name="status" value="has_errors" class="new-control-input"
                                       {{ request()->input('status') == 'has_errors' ? 'checked' : '' }}>
                                <span class="new-control-indicator"></span>Erros de Cadastro
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <input type="text" name="search" id="searchInput" class="form-control form-control-sm" placeholder="Pesquisar..."
                           value="{{ request()->input('search') }}">
                </div>
                <div class="col-auto" style="margin-left: -19px;">
                    <button type="submit" id="searchButton" class="btn btn-primary btn-rounded"><x-bx-search /> Pesquisar</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-4" id="datatable" data-url="{{ route('congregado.list') }}">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>CONGREGAÇÃO</th>
                            <th></th>
                        </tr>
                    </thead>
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
<script src="{{ asset('custom/js/imw_datatables.js')}}?time={{ time() }}"></script>
<script src="{{ asset('congregados/js/index.js')}}?time={{ time() }}"></script>
@endsection
