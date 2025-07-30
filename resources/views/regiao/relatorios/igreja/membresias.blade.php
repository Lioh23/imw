@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Membresia', 'url' => '#', 'active' => false],
        ['text' => 'Ano Eclesiástico', 'url' => '#', 'active' => true],
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
                        <h4>Ano Eclesiático</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div>
                    <form class="form-vertical" id="filter_form"  method="GET">
                        <div class="row">
                            <div class="col-md-5">
                                <select class="form-control " name="ano" id="ano">
                                    <option value="2025" {{ request()->get('ano') == 2025 ? 'selected' : 'selected' }}>2025</option>
                                    <option value="2024" {{ request()->get('ano') == 2024 ? 'selected' : '' }}>2024</option>
                                    <option value="2023" {{ request()->get('ano') == 2023 ? 'selected' : '' }}>2023</option>
                                    <option value="2022" {{ request()->get('ano') == 2022 ? 'selected' : '' }}>2022</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" id="btn-alcular">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (request()->has('ano'))

    <div class="col-lg-12 col-12 layout-spacing">
        <h6>{{ $titulo }}</h6>
    <div class="statbox widget box box-shadow">
      <div class="widget-content widget-content-area">
        <div class="table-responsive mt-0">
          <table class="table table-bordered table-striped table-hover mb-4 display nowrap" id="ano-eclesiastico">
            <thead>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="4">RECEBIDOS</th>
                    <th colspan="4">EXCLUÍDOS</th>
                    <th>TOTAL GERAL</th>
                </tr>
                <tr>
                    <th>DISTRITO</th>
                    <th>IGREJA</th>
                    <th>ADESÃO</th>
                    <th>BATISMO</th>
                    <th>TRANFERENCIA</th>
                    <th>TOTAL</th>
                    <th>ABANDONO</th>
                    <th>A PEDIDO</th>
                    <th>FALECIMENTO</th>
                    <th>TOTAL</th>
                    <th>TOTAL GERAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($membresias as $item)
                    
                    <tr>
                        <td>{{ $item['igreja']->distrito }}</td>
                        <td>{{ $item['igreja']->nome }}</td>
                        <td>{{ $item['membrosRecebidos'][1]->sexo_masculino + $item['membrosRecebidos'][1]->sexo_feminino }}</td>
                        <td>{{ $item['membrosRecebidos'][0]->sexo_masculino + $item['membrosRecebidos'][0]->sexo_feminino }}</td>
                        <td>{{ $item['membrosRecebidos'][3]->sexo_masculino + $item['membrosRecebidos'][3]->sexo_feminino }}</td>
                        <td>{{ $item['membrosRecebidos'][1]->total + $item['membrosRecebidos'][0]->total + $item['membrosRecebidos'][3]->total }}</td>
                        <td>{{ $item['membrosExcluidos'][1]->sexo_masculino + $item['membrosExcluidos'][3]->sexo_feminino }}</td>
                        <td>{{ $item['membrosExcluidos'][0]->sexo_masculino + $item['membrosExcluidos'][0]->sexo_feminino }}</td>
                        <td>{{ $item['membrosExcluidos'][3]->sexo_masculino + $item['membrosExcluidos'][3]->sexo_feminino }}</td>
                        <td>{{ $item['membrosExcluidos'][1]->total + $item['membrosExcluidos'][0]->total + $item['membrosExcluidos'][3]->total }}</td>
                        <td>{{ $item['membrosRecebidos'][1]->total + $item['membrosRecebidos'][0]->total + $item['membrosRecebidos'][3]->total + $item['membrosExcluidos'][1]->total + $item['membrosExcluidos'][0]->total + $item['membrosExcluidos'][3]->total }}</td>
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
