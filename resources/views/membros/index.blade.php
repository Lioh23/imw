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

<style>
    .swal2-popup .swal2-styled.swal2-cancel {
        color: white!important;
    }
</style>
@endsection

@include('extras.alerts')

@section('extras-scripts')
<script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
@endsection

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
                <div class="row mb-4">
                    <div class="col-4">
                        <input type="text" id="searchInput" class="form-control form-control-sm"
                            placeholder="Pesquisar...">
                    </div>
                    <div class="col-auto" style="margin-left: -19px;">
                        <button id="searchButton" class="btn btn-primary btn-rounded" type="button">Pesquisar</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-4">
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
                            @foreach ($membros as $index => $membro)
                                <tr>
                                    <td>{{ optional($membro->ultimaAdesao ?? null)->numero_rol }}</td>
                                    <td>
                                        @if(!$membro->has_errors)
                                            {{ $membro->nome }}
                                        @else
                                            <span class="badge badge-warning"> {{ $membro->nome }} </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($membro->ultimaAdesao) && !is_null($membro->ultimaAdesao->dt_recepcao))
                                            {{ \Carbon\Carbon::parse($membro->ultimaAdesao->dt_recepcao)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($membro->ultimaExclusao) && !is_null($membro->ultimaExclusao->dt_recepcao))
                                            {{ \Carbon\Carbon::parse($membro->ultimaExclusao->dt_exclusao)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>{{ optional($membro->ultimaAdesao ?? null)->congregacao->nome }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('membro.editar', $membro->id) }}" title="Editar"
                                            class="btn btn-sm btn-dark mr-2 btn-rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-edit-2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
    </script>
@endsection
