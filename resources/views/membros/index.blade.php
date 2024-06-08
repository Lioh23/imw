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
<link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />

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
    <div class="container-fluid d-flex justify-content-end">
        <span class="badge badge-info position-relative mt-3 mb-3 ml-2">
            <span>ROL ATUAL: {{ $countAtual }}</span>
        </span>

        <span class="badge badge-danger position-relative mt-3 mb-3 ml-2">
            <span>ROL PERMANENTE: {{ $countPermanente }}</span>
        </span>

        <span class="badge badge-warning position-relative mt-3 mb-3 ml-2">
            <span>ERROS DE CADASTRO: {{ $countHasErrors }}</span>
        </span>
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
                    <div class="col-12">
                        <div class="form-check form-check-inline">
                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                                    <input type="radio" name="status" value="rol_atual" class="new-control-input" 
                                           {{ request()->input('status') == 'rol_atual' || request()->input('status') == null ? 'checked' : '' }}>
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
                                    <input type="radio" name="status" value="rol_permanente" class="new-control-input"
                                           {{ request()->input('status') == 'rol_permanente' ? 'checked' : '' }}>
                                    <span class="new-control-indicator"></span>Rol Permanente
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
                                    <td>{{ optional($membro->rolAtual)->numero_rol }}</td>
                                    <td>
                                        @if($membro->has_errors)
                                            <span class="badge badge-warning"> {{ $membro->nome }} </span>
                                        @else
                                            {{ $membro->nome }}
                                        @endif
                                    </td>
                                    <td>{{ optional($membro->rolAtual->dt_recepcao)->format('d/m/Y') }}</td>
                                    <td> {{ optional($membro->rolAtual->dt_exclusao)->format('d/m/Y') }}</td>
                                    <td>{{ optional(optional($membro->rolAtual)->congregacao)->nome }}</td>
                                    <td class="text-center">
                                        @if (!$membro->rolAtual->dt_exclusao)
                                            <a href="{{ route('membro.editar', $membro->id) }}" title="Editar"
                                                class="btn btn-sm btn-dark mr-2 btn-rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit-2">
                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                        @if ($membro->rolAtual->dt_exclusao)
                                            <a href="{{ route('membro.reintegrar', $membro->id) }}" title="Reintegrar membro" class="btn btn-sm btn-dark mr-2 btn-rounded">
                                                <x-bx-log-in-circle />
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $membros->links('vendor.pagination.index') }}
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
