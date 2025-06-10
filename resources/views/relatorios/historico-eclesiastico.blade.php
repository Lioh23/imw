@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Relatórios', 'url' => '#', 'active' => false],
    ['text' => 'Relatório Histórico Eclesiástico', 'url' => '#', 'active' => true]
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
              <h4>Relatório de Histórico Eclesiástico</h4>
          </div>
      </div>
  </div>
    <div class="widget-content widget-content-area">
      <form class="form-vertical" id="filter_form">
        
        {{-- Congregação --}}
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Membro:</label>
          </div>
          <div class="col-lg-6">
            <select class="form-control select2 @error('membro_id') is-invalid @enderror" data-bs-toggle="select2" name="membro_id" id="membro_id">              
              <!-- <option value="" {{ old('membro_id') == '' ? 'selected' : '' }} hidden disabled>selecione</option> -->
              <option value="todos" {{ $select == 'todos' ? 'selected' : '' }} >TODOS</option>
              @foreach ($membros as $membro)
                <option value="{{ $membro->id }}" {{ $select == $membro->id  ? 'selected' : '' }} >{{ $membro->nome }}</option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Nomeação --}}
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Nomeação:</label>
          </div>
          <div class="col-lg-6">
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input type="radio" name="nomeacao_ativa" value="0" class="new-control-input" checked>
                  <span class="new-control-indicator"></span>Todas as Nomeações
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                  <input type="radio" name="nomeacao_ativa" value="1" class="new-control-input">
                  <span class="new-control-indicator"></span>Nomeação Ativa
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

@if($membro_unico)
  @isset($historicoEclesiastico)
    <div class="col-lg-12 col-12 layout-spacing">
      <div class="statbox widget box box-shadow">
          <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4 style="text-transform: uppercase">RELATÓRIO HISTORICO ECLESIASTICO - {{ $membroEclesiastico->nome }} - {{ session()->get('session_perfil')->instituicoes->igrejaLocal->nome }}</h4>
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
                              <th>CELULAR</th>
                              <th>MINISTÉRIO</th>
                              <th>FUNÇÃO</th>
                              <th>NOMEAÇÃO</th>
                              <th>EXONERAÇÃO</th>
                          </tr>
                      </thead>
                      <tbody>
                        @forelse ($historicoEclesiastico as $historico)
                          <tr>
                              <td>{{ $membroEclesiastico->rol_atual }}</td>
                              <td>{{ $membroEclesiastico->nome }}</td>
                              <td>{{ formatStr($membroEclesiastico->telefone, '## (##) #####-####') }}</td>
                              <td>{{ $historico->ministerio->descricao }}</td>
                              <td>{{ $historico->tipoAtuacao->descricao }}</td>
                              <td>{{ optional($historico->data_entrada)->format('d/m/Y') }}</td>
                              <td>{{ optional($historico->data_saida)->format('d/m/Y') }}</td>
                          </tr>
                        @empty
                          <tr>
                              <td colspan="6" style="text-align: center">Não existem registros para este membro</td>
                          </tr>
                        @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    </div>
  @endisset
@else
@isset($todos_membros)
  <div class="col-lg-12 col-12 layout-spacing">
      <div class="statbox widget box box-shadow">
          <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4 style="text-transform: uppercase">RELATÓRIO HISTORICO ECLESIASTICO - TODOS - {{ session()->get('session_perfil')->instituicoes->igrejaLocal->nome }}</h4>
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
                              <th>CELULAR</th>
                              <th>MINISTÉRIO</th>
                              <th>FUNÇÃO</th>
                              <th>NOMEAÇÃO</th>
                              <th>EXONERAÇÃO</th>
                          </tr>
                      </thead>
                      <tbody>
                        @forelse ($todos_membros as $membroEclesiastico)
                          @foreach($membroEclesiastico['historicoEclesiastico'] as $historico)
                            <tr>
                                <td>{{ $membroEclesiastico['membro']->rol_atual }}</td>
                                <td>{{ $membroEclesiastico['membro']->nome }}</td>
                                <td>{{ formatStr($membroEclesiastico['membro']->telefone, '## (##) #####-####') }}</td>
                                <td>{{ $historico->ministerio->descricao }}</td>
                                <td>{{ $historico->tipoAtuacao->descricao }}</td>
                                <td>{{ optional($historico->data_entrada)->format('d/m/Y') }}</td>
                                <td>{{ optional($historico->data_saida)->format('d/m/Y') }}</td>
                            </tr>
                          @endforeach
                        @empty
                          <tr>
                              <td colspan="6" style="text-align: center">Não existem registros para este membro</td>
                          </tr>
                        @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    </div>
  @endisset
@endif
@endsection

@section('extras-scripts')
<script>
  $('#btn_buscar').click(function () {
    $('#filter_form').removeAttr('target');
  })
  
  $('#btn_relatorio').click(function () {
    $('#filter_form').attr('target', '_blank');
  })

  $('#membro_id').change(function () {
    if($(this).val()) {
      $('#btn_buscar').removeAttr('disabled')
      $('#btn_relatorio').removeAttr('disabled')
    } else {
      $('#btn_buscar').addAttr('disabled', true)
      $('#btn_relatorio').addAttr('disabled', true)
    }
  })
</script>
@endsection