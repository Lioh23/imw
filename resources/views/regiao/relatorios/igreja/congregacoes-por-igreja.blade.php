@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Igreja', 'url' => '#', 'active' => false],
        ['text' => 'Congregações por Igrejas', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/searchbuilder/1.8.2/css/searchBuilder.dataTables.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/datetime/1.5.5/css/dataTables.dateTime.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />
    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }

        .toggle-icon {
            cursor: pointer;
            margin-right: 5px;
        }

        .child-row {
            display: none;
            /* Filhos ficam escondidos inicialmente */
        }
    </style>
@endsection

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
  <div class="statbox widget box box-shadow">
    <div class="widget-header">
      <div class="row">
          <div class="col-xl-12 col-md-12 col-sm-12 col-12">
              <h4>Congregações por Igrejas</h4>
          </div>
      </div>
  </div>
    <div class="widget-content widget-content-area">
      <form class="form-vertical" id="filter_form"  method="GET">
        <input type="hidden" name="buscar" value="todos">
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Igrejas:</label>
          </div>
          <div class="col-lg-6">
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('congregacao') == 1 ? 'checked' : 'checked' }} type="radio" name="congregacao" value="1" class="new-control-input">
                  <span class="new-control-indicator"></span>Com congregações
                </label>
              </div>
             <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('congregacao') == '' ? 'checked' : '' }} type="radio" name="congregacao" value="" class="new-control-input">
                  <span class="new-control-indicator"></span>Sem congregações
                </label>
              </div>
              <!-- <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('status') == '0' ? 'checked' : '' }} type="radio" name="status" value="0" class="new-control-input">
                  <span class="new-control-indicator"></span>Inativos
                </label>
              </div> -->
            </div>
          </div>
        </div>
        <div class="form-group row mb-4">
          <div class="col-lg-2"></div>
          <div class="col-lg-6">
            <button id="btn_buscar" type="submit" name="action" value="buscar" title="Buscar dados do Relatório" class="btn btn-primary btn">
              <x-bx-search /> Buscar 
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@if (request()->has('buscar'))
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <div class="table-responsive mt-0">
              <table class="table table-bordered table-striped table-hover mb-4 display nowrap" id="dado0s-clerigos">
                <thead>
                    <tr>
                        <th>DISTRITO</th>
                        <th>IGREJA</th>
                        <th>CONGREGAÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($igrejas as $item)
                      <tr>
                          <td>{{ $item->igreja->distrito_nome }}</td>
                          <td>{{ $item->igreja->igreja_nome }}</td>
                          <td>
                            <table>
                              @forelse ($item->congregacoes as $item)
                                <tr>
                                  <td>
                                      {{ $item->congregacao }}
                                  </td>
                                </tr>
                              @empty
                                <p> - </p>
                              @endforelse
                            </table>
                          </td>
                      </tr>
                    @empty
                      <p class="text-center text-muted">Nenhum resultado encontrado para o período selecionado.</p>
                    @endforelse
                </tbody>
              </table>
                
        </div>
      </div>
    </div>
  </div>
  @endif
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

    new DataTable('#dado0s-clerigos', {
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
                  title: "IMW - RELATÓRIO CONGREGAÇÕES POR IGREJAS"
                },
                {
                  extend: 'pdf',
                  className: 'btn btn-primary btn-rounded',
                  text: '<i class="fas fa-file-pdf"></i> PDF',
                  titleAttr: 'PDF',
                  title: "IMW - RELATÓRIO CONGREGAÇÕES POR IGREJAS",
                },
                {
                  extend: 'print',
                  className: 'btn btn-primary btn-rounded',
                  text: '<i class="fas fa-print"></i> Imprimir',
                  titleAttr: 'Imprimir',
                  title: "IMW - RELATÓRIO CONGREGAÇÕES POR IGREJAS",
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