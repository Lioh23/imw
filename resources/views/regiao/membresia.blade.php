@extends('template.layout')

@section('breadcrumb')
  <x-breadcrumb :breadcrumbs="[
      ['text' => 'Home', 'url' => '/', 'active' => false],
      ['text' => 'Relatórios', 'url' => '#', 'active' => false],
      ['text' => 'Relatório Região/Membresia', 'url' => '#', 'active' => true]
  ]"></x-breadcrumb>
@endsection

@section('extras-css')
  <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
  <style>
    table{
            font-size: 12px;
            font-style: normal !important;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            text-align: start;
            border-spacing: 0;
            border-collapse: separate;
        }

        .table>thead>tr>th {
            vertical-align: middle;
            background-color: #e8eaea;
            color:#777;
        }

        .table>tbody>tr>td {
            vertical-align: middle;
            color:#777;
        }

        .table-center{
            padding-top: 6px !important;
        }
        .table-responsive {
            margin-bottom: 5px;
        }

        .table_fixed_box{
            overflow: auto; 
            height: 53vh;
        }

        .table_fixed_box thead {
            position: -webkit-sticky;
            position: sticky !important; 
            top: 0 !important; 
            z-index: 1;
            background: #e8eaea;
            color:#777;
        }
        .table td, .table th {
            padding: .25rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table-striped>tbody>tr:nth-of-type(odd)>* {
            --bs-table-color-type: var(--bs-table-striped-color);
            --bs-table-bg-type: rgb(215 215 215 / 17%);
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 0;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #e8eaea;
        }
  </style>
@endsection

@include('extras.alerts')

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
  <div class="statbox widget box box-shadow">
    <div class="widget-header">
      <div class="row">
          <div class="col-xl-12 col-md-12 col-sm-12 col-12">
              <h4>Relatório de Membresia Região: {{ $regiao_nome }}</h4>
          </div>
      </div>
  </div>
    <div class="widget-content widget-content-area">
      <form class="form-vertical" id="filter_form">
        
        {{-- Congregação --}}
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Distrito:</label>
          </div>
          <div class="col-lg-6">
            <select id="distritoId" name="distrito_id" class="form-control @error('distrito_id') is-invalid @enderror" >
              <option value="" {{ !request()->get('distrito_id') ? 'selected' : '' }}>TODOS</option>
              @foreach ($distritos as $distrito)
                <option value="{{ $distrito->id }}" {{ request()->get('distrito_id') == $distrito->id ? 'selected' : '' }}>{{ $distrito->nome }}</option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Vínculo --}}
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Vínculo:</label>
          </div>
          <div class="col-lg-6">
            <input type="hidden" id="vinculoEscolhido">
            <div class="form-check form-check-inline">
              <div class="n-chk">
                 <label class="new-control new-checkbox checkbox-outline-success">
                  <input {{ request()->get('vinculo') == 'M' ? 'checked' : '' }}
                         type="radio" name="vinculo" value="M" class="new-control-input vinculoMembro vinculo">
                  <span class="new-control-indicator"></span>Membro
                </label>
               
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox checkbox-outline-success">
                   <input {{ request()->get('vinculo') == 'C' ? 'checked' : '' }}
                         type="radio" name="vinculo" value="C" class="new-control-input vinculo">
                  <span class="new-control-indicator"></span>Congregado
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox checkbox-outline-success">
                  <input {{ request()->get('vinculo') == 'V' ? 'checked' : '' }}
                         type="radio" name="vinculo" value="V" class="new-control-input vinculo">
                  <span class="new-control-indicator"></span>Visitante
                </label>
              </div>
            </div>
          </div>
        </div>

        {{-- Situação --}}
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Situação:</label>
          </div>
          <div class="col-lg-6">
            <input type="hidden" id="situacaoEscolhida">
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('situacao') == 'ativos' ? 'checked' : '' }}
                         type="radio" name="situacao" value="ativos" class="new-control-input situacao">
                  <span class="new-control-indicator"></span>Ativos
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('situacao') == 'inativos' ? 'checked' : '' }}
                         type="radio" name="situacao" value="inativos" class="new-control-input situacao">
                  <span class="new-control-indicator"></span>Inativos
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('situacao') == 'todos' || !request()->get('situacao') ? 'checked' : '' }} 
                         type="radio" name="situacao" value="todos" class="new-control-input situacao">
                  <span class="new-control-indicator"></span>Todos
                </label>
              </div>
            </div>
          </div>
        </div>

        {{-- Seletor do tipo de data --}}
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Filtro:</label>
          </div>
          <div class="col-lg-6">
            <input type="hidden" id="filtroEscolhido">
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ !request()->get('dt_filtro') ? 'checked' : '' }}
                         type="radio" name="dt_filtro" value="" class="new-control-input filtro" >
                  <span class="new-control-indicator"></span>Nenhuma
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('dt_filtro') == 'data_nascimento' ? 'checked' : '' }} disabled
                         type="radio" name="dt_filtro" value="data_nascimento" class="new-control-input filtro">
                  <span class="new-control-indicator"></span>Nascimento
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('dt_filtro') == 'dt_recepcao' ? 'checked' : '' }} disabled
                         type="radio" name="dt_filtro" value="dt_recepcao" class="new-control-input filtro">
                  <span class="new-control-indicator"></span>Recepção
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('dt_filtro') == 'dt_exclusao' ? 'checked' : '' }} disabled
                         type="radio" name="dt_filtro" value="dt_exclusao" class="new-control-input filtro">
                  <span class="new-control-indicator"></span>Exclusão
                </label>
              </div>
            </div>
          </div>
        </div>

        {{-- Inserção de data --}}
        <div class="form-group row mb-4 {{ !request()->get('dt_filtro') ? 'd-none' : '' }}" id="filtros_data">
          <div class="col-lg-2 text-right">
            <label class="control-label">Período (Inicial e Final):</label>
          </div>
          <div class="col-lg-3">
            <input type="date" class="form-control @error('dt_inical') is-invalid @enderror" id="dt_inicial" name="dt_inicial" value="{{ request()->get('dt_inicial') }}" placeholder="ex: 31/12/2000">
          </div>
          <div class="col-lg-3">
            <input type="date" class="form-control @error('dt_final') is-invalid @enderror" id="dt_final" name="dt_final" value="{{ request()->get('dt_final') }}" placeholder="ex: 31/12/2000">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@include('regiao.ajax.membresia')

@endsection

@section('extras-scripts')

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
  $(document).ready(function() {
    $('.vinculoMembro').click();
  })
  $('[name="dt_filtro"]').change(function () {
    if ($(this).val()) {
      $('#filtros_data').removeClass('d-none');
      resetDateFields()
    } else {
      $('#filtros_data').addClass('d-none');
      resetDateFields()
    }
  });

  $('#btn_buscar').click(function () {
    $('#filter_form').removeAttr('target');
  })
  
  $('#btn_relatorio').click(function () {
    $('#filter_form').attr('target', '_blank');
  })

  function resetDateFields() {
    $('#dt_inicial').val('')
    $('#dt_final').val('')
  }


  //////////////////////PAGINAÇÃO AJAX///////////////////////////
  $(document).on('click', '.pagination a', function (e) {
      e.preventDefault();
      var url = $(this).attr("href");
      fetchData(url);
  })

  function fetchData(url) {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        type: "GET",
        url: url,
        dataType: "html",
        success: function (response) {
          $('#conteudo-lista').html(response)                
        },
        error: function (request, status, error) {
          location.reload();
        }
    });

  }
 //////////////////////FILTROS///////////////////////////
  $(document).on('click', '.vinculo', function (e) {
    //e.preventDefault();
    let vinculo = $(this).val();
    $('#vinculoEscolhido').val(vinculo);
    getUrlAll();
	})

  $(document).on('click', '.situacao', function (e) {
    //e.preventDefault();
    $('#situacaoEscolhida').val($(this).val());
    getUrlAll();
	})

  $(document).on('change', '.filtro', function (e) {
    //e.preventDefault();
    $('#filtroEscolhido').val($(this).val());
    getUrlAll();
	})

  $(document).on('change', '#distritoId', function (e) {
    e.preventDefault();
    getUrlAll();
	})

  $(document).on('change', '#dt_inicial', function (e) {
    e.preventDefault();
    getUrlAll();
	})

  $(document).on('change', '#dt_final', function (e) {
    e.preventDefault();
    getUrlAll();
	})

  $(document).on('change', '#totalPorPagina', function (e) {
    e.preventDefault();
    getUrlAll();
	})

  //////////////////////URL DA LISTA///////////////////////////
  function getUrlAll(){
      let vinculo = $('#vinculoEscolhido').val();
      if(vinculo == 'M'){
        $('.situacao').prop('disabled', false)
      }else{
        $('.situacao').prop('disabled', true)
      }
      let situacao = $('#situacaoEscolhida').val();
      let filtro = $('#filtroEscolhido').val();
      let distritoId = $('#distritoId').val();
      let dtInicial = $('#dt_inicial').val();
      let dtFinal = $('#dt_final').val();
      let totalPorPagina = $('#totalPorPagina').val();
      let urlAtual = `{{ route('regiao.membresia') }}`;
      let ordem = $('#input-ordenar').val();
      url = `${urlAtual}?distritoId=${distritoId}&vinculo=${vinculo}&situacao=${situacao}&filtro=${filtro}&dtInicial=${dtInicial}&dtFinal=${dtFinal}&totalPorPagina=${totalPorPagina}`;
      fetchData(url)
  }
</script>
@endsection