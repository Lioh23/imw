@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Visitantes', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }
    </style>
@endsection

@section('content')
    @include('extras.alerts')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Imposto de Renda</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div>
                    <form action="">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control " name="prebendas_valor_ano" id="prebendas_valor_ano">
                                    @foreach ($prebendas as $prebenda)
                                        <option value="{{ $prebenda->id }}">{{ $prebenda->ano }} (R${{ $prebenda->valor }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary" id="btn-calcular">Calcular</button>
                        </div>

                    </form>
                    <div class="" tabindex="-1" id="body-calculate" aria-hidden="true">
                        <div class="loadable">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE VISUALIZAÇÃO -->
@endsection

@section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('custom/js/imw_datatables.js') }}?time={{ time() }}"></script>
    <script src="{{ asset('perfil/clerigos/dependentes/js/index.js') }}?time={{ time() }}"></script>
    <script>
  $('#btn-calcular').click(function(event) {
    event.preventDefault();
    var prebendaId = $('#prebendas_valor_ano').val();

    if (prebendaId) {
        $.ajax({
            type: 'GET',
            url: '/clerigos/perfil/imposto-de-renda/load-html/' + prebendaId,
            beforeSend: function() {
                $('#body-calculate').html(
                    '<div class="modal-body" style="min-height: 200px"></div>'
                );

                $('.loadable').block({
                    message: '<div class="spinner-border mr-2 text-secondary align-self-center loader-sm"></div>',
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        width: '100%',
                        height: '100%',
                        padding: '80px',
                        backgroundColor: 'transparent',
                    }
                });
            },
            success: function(response) {
                console.log(response);
                if (response.html) {
                    $('#body-calculate').html(response.html);
                } else {
                    toastr.error('Erro ao carregar dados da prebenda.');
                }
            },
            error: function(error) {
                $('#body-calculate').html('<div class="modal-body">' + error.responseJSON.message + '</div>');
                toastr.error('Erro ao visualizar dados desta prebenda.');
            },
            complete: function() {
                $('.loadable').unblock();
            }
        });
    }
});
    </script>
@endsection
