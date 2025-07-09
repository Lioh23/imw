@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Clérigos', 'url' => '#', 'active' => false],
        ['text' => 'Dados', 'url' => '#', 'active' => true],
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
              <h4>Relatório Cadastro dos Clérigos</h4>
          </div>
      </div>
  </div>
    <div class="widget-content widget-content-area">
      <form class="form-vertical" id="filter_form"  method="GET">
        
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Clérigos:</label>
          </div>
          <div class="col-lg-6">
            <select class="form-control" id="buscar" name="buscar" required>
                <option value="todos" {{ request()->input('buscar') == 'buscar' ? 'selected' : '' }}>
                    Todos 
                </option>
            </select>
          </div>
        </div>

        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Status:</label>
          </div>
          <div class="col-lg-6">
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox checkbox-outline-success">
                  <input checked type="checkbox" name="vinculo[]" id="vinculo_membro" value="M" class="new-control-input">
                  <span class="new-control-indicator"></span>Ativo
                </label>
              </div>
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
  <div class="col-lg-12 col-12 layout-spacing">
      <div class="statbox widget box box-shadow">
          <div class="widget-content widget-content-area">
              <div class="table-responsive mt-0">
                <table class="table table-bordered table-striped table-hover mb-4 display nowrap" id="dados-clerigos">
                  <thead>
                      <tr>
                          <th>NOME</th>
                          <th>E-MAIL</th>
                          <th>IDENTIDADE</th>
                          <th>ORGÃO</th>
                          <th>DATA EMISSÃO</th>
                          <th>CPF</th>
                          <!-- <th>NASCIMENTO</th>
                          <th>IDADE</th>
                          <th>TELEFONE</th>
                          <th>PAÍS</th>
                          <th>UF</th>
                          <th>CIDADE</th>
                          <th>BAIRRO</th>
                          <th>ENDEREÇO</th>
                          <th>NÚMERO</th>
                          <th>COMPLEMENTO</th>
                          <th>CEP</th> -->
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($clerigos as $membro)
                          <tr>
                              <td>{{ $membro->nome }}</td>
                              <td>{{ $membro->email }}</td>
                              <td>{{ $membro->identidade }}</td>
                              <td>{{ $membro->orgao_emissor }}</td>
                              <td>{{ $membro->data_emissao }}</td>
                              <td>{{ formatStr($membro->cpf, '###.###.###-##') }}</td>
                              <!-- <td>{{ $membro->data_nascimento }}</td>
                              <td>{{ $membro->idade }}</td>
                              <td>{{ formatStr($membro->contato, '## (##) #####-####') }}</td>
                              <td>{{ $membro->pais }}</td>
                              <td>{{ $membro->uf }}</td>
                              <td>{{ $membro->cidade }}</td>
                              <td>{{ $membro->bairro }}</td>
                              <td>{{ $membro->endereco }}</td>
                              <td>{{ $membro->numero }}</td>
                              <td>{{ $membro->complemento }}</td>
                              <td>{{ $membro->cep }}</td> -->
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

    new DataTable('#dados-clerigos', {
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
                  title: "RELATÓRIO DADOS - CLÉRIGOS"
                },
                {
                  extend: 'pdf',
                  orientation: 'landscape',
                  className: 'btn btn-primary btn-rounded',
                  text: '<i class="fas fa-file-pdf"></i> PDF',
                  titleAttr: 'PDF',
                  title: "RELATÓRIO DADOS - CLÉRIGOS",
                },
                {
                  extend: 'print',
                  className: 'btn btn-primary btn-rounded',
                  text: '<i class="fas fa-print"></i> Imprimir',
                  titleAttr: 'Imprimir',
                  title: "RELATÓRIO DADOS - CLÉRIGOS",
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