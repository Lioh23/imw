@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Relatórios', 'url' => '#', 'active' => false],
    ['text' => 'Relatório Secretaria/Membresia', 'url' => '#', 'active' => true]
]"></x-breadcrumb>
@endsection

@section('extras-css')
  <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
@endsection

@include('extras.alerts')

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
  <div class="statbox widget box box-shadow">
    <div class="widget-header">
      <div class="row">
          <div class="col-xl-12 col-md-12 col-sm-12 col-12">
              <h4>Relatório de Membresia</h4>
          </div>
      </div>
  </div>
    <div class="widget-content widget-content-area">
      <form class="form-vertical" id="filter_form">
        
        {{-- Congregação --}}
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Onde congrega:</label>
          </div>
          <div class="col-lg-6">
            <select id="congregacao_id" name="congregacao_id" class="form-control @error('congregacao_id') is-invalid @enderror" >
              <option value="" {{ !request()->get('congregacao_id') ? 'selected' : '' }}>TODOS</option>
              @foreach ($congregacoes as $congregacao)
                <option value="{{ $congregacao->id }}" {{ request()->get('congregacao_id') == $congregacao->id ? 'selected' : '' }}>{{ $congregacao->nome }}</option>
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
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox checkbox-outline-success">
                  <input {{ !request()->get('vinculo') || request()->get('vinculo') == 'M' ? 'checked' : '' }} 
                         type="radio" name="vinculo" id="vinculo_membro" value="M" class="new-control-input">
                  <span class="new-control-indicator"></span>Membro
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox checkbox-outline-success">
                  <input {{ request()->get('vinculo') == 'C' ? 'checked' : '' }}
                         type="radio" name="vinculo" value="C" class="new-control-input">
                  <span class="new-control-indicator"></span>Congregado
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox checkbox-outline-success">
                  <input {{ request()->get('vinculo') == 'V' ? 'checked' : '' }} type="radio" name="vinculo" value="V" class="new-control-input">
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
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('situacao') == 'ativos' ? 'checked' : '' }}
                         type="radio" name="situacao" value="ativos" class="new-control-input">
                  <span class="new-control-indicator"></span>Ativos
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('situacao') == 'inativos' ? 'checked' : '' }}
                         type="radio" name="situacao" value="inativos" class="new-control-input">
                  <span class="new-control-indicator"></span>Inativos
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('situacao') == 'todos' || !request()->get('situacao') ? 'checked' : '' }} 
                         type="radio" name="situacao" value="todos" class="new-control-input">
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
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ !request()->get('dt_filtro') ? 'checked' : '' }}
                         type="radio" name="dt_filtro" value="" class="new-control-input">
                  <span class="new-control-indicator"></span>Nenhuma
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('dt_filtro') == 'data_nascimento' ? 'checked' : '' }}
                         type="radio" name="dt_filtro" value="data_nascimento" class="new-control-input">
                  <span class="new-control-indicator"></span>Nascimento
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('dt_filtro') == 'dt_recepcao' ? 'checked' : '' }}
                         type="radio" name="dt_filtro" value="dt_recepcao" class="new-control-input">
                  <span class="new-control-indicator"></span>Recepção
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input {{ request()->get('dt_filtro') == 'dt_exclusao' ? 'checked' : '' }}
                         type="radio" name="dt_filtro" value="dt_exclusao" class="new-control-input">
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

        <div class="form-group row mb-4">
          <div class="col-lg-2"></div>
          <div class="col-lg-6">
            <button id="btn_buscar" type="submit" name="action" value="buscar" title="Buscar dados do Relatório" class="btn btn-primary btn">
              <x-bx-search /> Buscar 
            </button>
            <button id="btn_relatorio" type="submit" name="action" value="relatorio" title="Gerar Relatório PDF" class="btn btn-secondary btn ml-4">
              <x-bx-file /> Relatório
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- TABELA -->
@isset($membros)
  <div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
          <div class="row">
              <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                  <h4 style="text-transform: uppercase">RELATÓRIO SECRETARIA {{ $vinculos }} - {{ session()->get('session_perfil')->instituicoes->igrejaLocal->nome }}</h4>
                  <p class="pl-3">Registros Encontrados: {{ $membros->count() }}</p>
                  <p class="pl-3">Vínculo: {{ $vinculos }}</p>
                  <p class="pl-3">Situação: {{ $situacao }}</p>
                  <p class="pl-3">Onde Congrega: {{ $ondeCongrega }}</p>
              </div>
          </div>
        </div>
        <div class="widget-content widget-content-area">
          
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-4">
                    <thead>
                        <tr>
                            <th>ROL</th>
                            <th>NOME</th>
                            <th>TELEFONE</th>
                            <th>SITUAÇÃO</th>
                            <th>VÍNCULO</th>
                            <th>NASCIMENTO</th>
                            <th>RECEPÇÃO</th>
                            <th>EXCLUSÃO</th>
                            <th>LOCAL</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($membros as $membro)
                          <tr>
                            <td>{{ $membro->rol_atual ?? 0 }}</td>
                            <td>{{ $membro->nome }}</td>
                            <td>{{ formatStr($membro->telefone, '## (##) #####-####') }}</td>
                            <td>
                              @if($membro->vinculo == App\Models\MembresiaMembro::VINCULO_MEMBRO)
                                {{ $membro->rolAtualSessionIgreja->statusText }}
                              @else
                                {{ $membro->statusText }}
                              @endif
                            </td>
                            <td>{{ $membro->vinculoText }}</td>
                            <td>{{ optional($membro->data_nascimento)->format('d/m/Y') }}</td>
                            <td>
                              @if($membro->vinculo == App\Models\MembresiaMembro::VINCULO_MEMBRO)
                                 {{ optional($membro->rolAtualSessionIgreja->dt_recepcao)->format('d/m/Y') }}
                              @else
                                {{ $membro->created_at->format('d/m/Y') }}
                              @endif
                            </td>
                            <td>
                              @if($membro->vinculo == App\Models\MembresiaMembro::VINCULO_MEMBRO)
                                {{ optional($membro->rolAtualSessionIgreja->dt_exclusao)->format('d/m/Y') }}
                              @else
                                {{ optional($membro->deleted_at)->format('d/m/Y') }}
                              @endif
                            </td>
                            <td>{{ optional($membro->congregacao)->nome ?? 'SEDE' }}</td>
                          </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
@endisset

@endsection

@section('extras-scripts')
<script>
  // exibe o campo de "datas" caso seja selecionada uma data para filtro
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
 
</script>
@endsection