@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Contabilidade', 'url' => '#', 'active' => false],
        ['text' => 'IRRF', 'url' => '#', 'active' => true],
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
                        <h4>IRRF por mês/ano</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div>
                    <form class="form-vertical" id="filter_form"  method="GET">
                        <div class="row">
                            <div class="col-md-5">
                                <select class="form-control " name="ano" id="ano">
                                    @foreach ($anos as $item)
                                        <option value="{{ $item->ano }}">
                                            {{ $item->ano }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="form-control " name="mes" id="mes">
                                    @foreach ($meses as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary" id="btn-alcular">Buscar</button>
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

    @if (request()->has('ano'))

    <div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
      <div class="widget-content widget-content-area">
        <div class="table-responsive mt-0">
          <table class="table table-bordered table-striped table-hover mb-4 display nowrap" id="aniversariantes-clerigos">
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>CPF</th>
                    <th>PREBENDAS</th>
                    <th>Nº DEPENDENTES</th>
                    <th>BASE DE CÁLCULOS</th>
                    <th>IRRF CALCULADO</th>
                    <th>RETIDO</th>
                    <th>RECOLHIDO</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                    <td colspan="8">
                        Aguarde, pois estamos em desenvolvimento.
                    </td>
                </tr> -->
                @forelse($prebendas as $item)
                <tr>
                    <td>{{ $item['prebanda']->nome }}</td>
                    <td>{{ formatStr($item['prebanda']->cpf, '###.###.###-##') }}</td>
                    <td>R$ {{ number_format($item['prebanda']->valor_prebendas, 2, ',', '.') }}</td>
                    <td>{{ $item['prebanda']->n_dependentes }}</td>
                    <td>R$ {{ number_format($item['imposto']->valorBase) }}</td>
                    <td>R$ {{ number_format($item['imposto']->valorImposto) }}</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        Não possui dados
                    </td>
                </tr>
                @endforelse
            </tbody>
          </table>            
        </div>
      </div>
    </div>
  </div>
    @endif

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
                    url: '/usuario/clerigos/perfil/imposto-de-renda/load-html/' + prebendaId,
                    beforeSend: function() {
                        $('#body-calculate').html(`<div style="min-height: 200px; display:flex; justify-content: center; align-items:center;">
                            <div class="spinner-border text-primary align-self-center"></div>
                        </div>`);


                    },
                    success: function(html) {
                        if (html) {
                            $('#body-calculate').html(html);
                        } else {
                            toastr.error('Erro ao carregar dados da prebenda.');
                        }
                    },
                    error: function(error) {
                        $('#body-calculate').html('<div class="text-danger">' + error.responseJSON
                            .message + '</div>');
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
