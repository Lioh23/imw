@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Membresia', 'url' => '#', 'active' => false],
        ['text' => 'Mapa estatístico de membros', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
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
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Relatório Mapa Estatístico de Membros</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div>
                    <form class="form-vertical" id="filter_form"  method="GET">
                        <div class="row col-md-12">
                            <div class="form-group mb-4 col-md-4" id="filtros_data_inicial">
                                <div class="col-md-12">
                                    <label class="control-label">* Data Inicial:</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="date" class="form-control @error('data_inicial') is-invalid @enderror"
                                        id="data_inicial" name="data_inicial" value="{{ request()->input('data_inicial') }}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group mb-4 col-md-4" id="filtros_data_final">
                                <div class="col-lg-12">
                                    <label class="control-label">* Data Final:</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="date" class="form-control @error('data_final') is-invalid @enderror"
                                        id="data_final" name="data_final" value="{{ request()->input('data_final') }}" required>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <button class="btn btn-primary" title="Buscar dados" style="margin-top: 30px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none" viewBox="0 0 24 24"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path></svg>
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (request()->has('data_inicial'))

    <div class="col-lg-12 col-12 layout-spacing">
        <h6>{{ $titulo }}</h6>
    <div class="statbox widget box box-shadow">
      <div class="widget-content widget-content-area">
        <div class="table-responsive mt-0">
          <table class="table table-bordered table-striped table-hover mb-4 display nowrap" id="ano-eclesiastico">
            <thead>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="8" style="text-align: center;">RECEBIDOS</th>
                    <th colspan="8" style="text-align: center;">EXCLUÍDOS</th>
                    <th colspan="2" style="text-align: center;"></th>
                </tr>
                <tr>
                    <th>DISTRITO</th>
                    <th>IGREJA</th>
                    <th colspan="2" style="text-align: center;">ADESÃO</th>
                    <th colspan="2" style="text-align: center;">BATISMO</th>
                    <th colspan="2" style="text-align: center;">TRANFERENCIA</th>
                    <th colspan="2" style="text-align: center;">TOTAL</th>
                    <th colspan="2" style="text-align: center;">ABANDONO</th>
                    <th colspan="2" style="text-align: center;">PEDIDO</th>
                    <th colspan="2" style="text-align: center;">FALECIMENTO</th>
                    <th colspan="2" style="text-align: center;">TOTAL</th>
                    <th colspan="2" style="text-align: center;">TOTAL GERAL</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th style="text-align: left">M</th>
                    <th style="text-align: left;">F</th>
                    <th style="text-align: left;">M</th>
                    <th style="text-align: left;">F</th>
                    <th style="text-align: left;">M</th>
                    <th style="text-align: left;">F</th>
                    <th style="text-align: left;">M</th>
                    <th style="text-align: left;">F</th>
                    <th style="text-align: left;">M</th>
                    <th style="text-align: left;">F</th>
                    <th style="text-align: left;">M</th>
                    <th style="text-align: left;">F</th>
                    <th style="text-align: left;">M</th>
                    <th style="text-align: left;">F</th>
                    <th style="text-align: left;">M</th>
                    <th style="text-align: left;">F</th>
                    <th style="text-align: left;">M</th>
                    <th style="text-align: left;">F</th>
                </tr>
            </thead>
            <tbody>
                @forelse($membresias as $item)
                    <tr>
                        <td>{{ $item['igreja']->distrito }}</td>
                        <td>{{ $item['igreja']->nome }}</td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][1]->sexo_masculino }}</td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][1]->sexo_feminino }}</td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][0]->sexo_masculino }}
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][0]->sexo_feminino }}</td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][3]->sexo_masculino }} </td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][3]->sexo_feminino }}</td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][1]->sexo_masculino + $item['membrosRecebidos'][0]->sexo_masculino + $item['membrosRecebidos'][3]->sexo_masculino }}</td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][1]->sexo_feminino + $item['membrosRecebidos'][0]->sexo_feminino + $item['membrosRecebidos'][3]->sexo_feminino }}</td>
                        <td style="text-align: center;">{{ $item['membrosExcluidos'][1]->sexo_masculino }}</td>
                        <td style="text-align: center;">{{ $item['membrosExcluidos'][3]->sexo_feminino }}</td>
                        <td style="text-align: center;">{{ $item['membrosExcluidos'][0]->sexo_masculino }}</td>
                        <td style="text-align: center;">{{ $item['membrosExcluidos'][0]->sexo_feminino }}</td>
                        <td style="text-align: center;">{{ $item['membrosExcluidos'][3]->sexo_masculino }}</td>
                        <td style="text-align: center;">{{ $item['membrosExcluidos'][3]->sexo_feminino }}</td>
                        <td style="text-align: center;">{{ $item['membrosExcluidos'][1]->sexo_masculino + $item['membrosExcluidos'][0]->sexo_masculino + $item['membrosExcluidos'][3]->sexo_masculino }}</td>
                        <td style="text-align: center;">{{ $item['membrosExcluidos'][3]->sexo_feminino + $item['membrosExcluidos'][0]->sexo_feminino + $item['membrosExcluidos'][3]->sexo_feminino }}</td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][1]->sexo_masculino + $item['membrosRecebidos'][0]->sexo_masculino + $item['membrosRecebidos'][3]->sexo_masculino + $item['membrosExcluidos'][1]->sexo_masculino + $item['membrosExcluidos'][0]->sexo_masculino + $item['membrosExcluidos'][3]->sexo_masculino}}</td>
                        <td style="text-align: center;">{{ $item['membrosRecebidos'][1]->sexo_feminino + $item['membrosRecebidos'][0]->sexo_feminino + $item['membrosRecebidos'][3]->sexo_feminino + $item['membrosExcluidos'][3]->sexo_feminino + $item['membrosExcluidos'][0]->sexo_feminino + $item['membrosExcluidos'][3]->sexo_feminino }}</td>
                    </tr>
                @empty
                <tr>
                    <td colspan="8">
                        Não possui dados
                    </td>
                </tr>
                @endforelse
                @if($membresias)
                    <tr>
                        <td>RESUMO</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total de Rol Anterior:</td>
                        <td>M: {{ $item['rolAnterior']->sexo_masculino }} &nbsp;&nbsp; F: {{ $item['rolAnterior']->sexo_feminino }} &nbsp;&nbsp; Total: {{ $item['rolAnterior']->total }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total de Líquido:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total de Rol Atual:</td>
                        <td>M: {{ $item['rolAtual']->sexo_masculino }} &nbsp;&nbsp; F: {{ $item['rolAtual']->sexo_feminino }} &nbsp;&nbsp; Total: {{ $item['rolAtual']->total }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.8.2/js/dataTables.searchBuilder.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.8.2/js/searchBuilder.dataTables.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.5/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>
    <script>
    $('#btn_buscar').click(function () {
        $('#filter_form').removeAttr('target');
    })
    
    $('#btn_relatorio').click(function () {
        $('#filter_form').attr('target', '_blank');
    })

    new DataTable('#ano-eclesiastico', {
        scrollX: true,
        scrollY: 400,
        scrollCollapse: true,
        layout: {
            //top1: 'searchBuilder',
            topStart: {
            buttons: [
                'pageLength',
                {
                  extend: 'excel',
                  className: 'btn btn-primary btn-rounded',
                  text: '<i class="fas fa-file-excel"></i> Excel',
                  titleAttr: 'Excel',
                  title: "{{ $titulo }}"
                },
                {
                  extend: 'pdf',
                  orientation: 'landscape',
                  className: 'btn btn-primary btn-rounded',
                  text: '<i class="fas fa-file-pdf"></i> PDF',
                  titleAttr: 'PDF',
                  title: "{{ $titulo }}",
                },
                {
                  extend: 'print',
                  className: 'btn btn-primary btn-rounded',
                  text: '<i class="fas fa-print"></i> Imprimir',
                  titleAttr: 'Imprimir',
                  title: "{{ $titulo }}",
                  customize: function ( win ) {
                      $(win.document.body)
                      .css( 'font-size', '14pt' )
                      .find( 'h1' )
                              .css( 'text-align', 'center' ).css( 'font-size', '18pt' ).css( 'font-weight', 'bold');

                      $(win.document.body).find('table')
                      .addClass('compact')
                      .css('font-size', 'inherit');
                  }
                }]
            },
            topEnd: 'search',
            bottomStart: 'info',
            bottomEnd: 'paging'
        },
        language: {
        url:"https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
        }
    });
    </script>

@endsection
