@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'GCEU', 'url' => '/gceu/lista', 'active' => false],
        ['text' => 'Carta Pastoral', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/searchbuilder/1.8.2/css/searchBuilder.dataTables.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/datetime/1.5.5/css/dataTables.dateTime.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />

    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }
    </style>
@endsection

@section('content')
    @include('extras.alerts')
    <!-- TABELA -->
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Diário dos GCEUs da Igreja: <u>{{ $instituicao }}</u></h4>
                    </div>
                </div>
            </div>
                        
            <div class="widget-content widget-content-area">
                <form class="form-vertical" id="filter_form" method="GET">
                    <div class="row">
                        <div class="mb-3 col-lg-4 col-md-6 col-sm-12" id="filtros_data">
                            <label class="control-label">*Data:</label>
                            <input type="date" class="form-control @error('dt_inicial') is-invalid @enderror" id="dt_inicial" name="dt_inicial" value="{{ request()->input('dt_inicial') }}" required placeholder="ex: 31/12/2000">
                        </div>
                        <div class="mb-3 col-lg-5 col-md-6 col-sm-12">
                            <label class="control-label">GCEU:</label>
                            <select id="gceu_id" name="gceu_id" class="form-control @error('gceu_id') is-invalid @enderror" required>
                                <option value="" {{ request()->input('gceu_id') == '' ? 'selected' : '' }}>Selecione</option>
                                @foreach($Gceus as $gceu)
                                    <option value="{{ $gceu->id }}" {{ request()->input('gceu_id') == $gceu->id ? 'selected' : '' }}>{{ $gceu->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-2 col-md-6 col-sm-12" style="margin-top: 30px;">
                            <button id="btn_buscar" type="submit" name="action" value="buscar" title="Buscar GCEU" class="btn btn-primary btn">
                                <x-bx-search /> Buscar
                            </button>
                        </div>
                    </div>
                </form>
                @if(request()->input('gceu_id'))
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Diário para registro de presença/ausência do GCEU: </h4>
                             <div class="col-xl-12 col-md-12 col-sm-12 col-12">&nbsp;</div>
                             <div class="row">
                                @foreach($membros as $membro)
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <p>{{ $membro->nome }}</p>
                                                Presente: 
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                    <label class="form-check-label" for="inlineRadio1">Sim</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                    <label class="form-check-label" for="inlineRadio2">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                @endif
            </div>
                
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="visualizarGCEUCartaPastoralModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content loadable">
                <div class="modal-body" style="min-height: 200px"></div>
            </div>
        </div>
    </div>
@endsection

@section('extras-scripts')

@endsection
