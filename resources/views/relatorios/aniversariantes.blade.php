@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Relatórios', 'url' => '#', 'active' => false],
    ['text' => 'Relatório Aniversariantes', 'url' => '#', 'active' => true]
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
              <h4>Relatório de Aniversariantes</h4>
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
              <option value="" {{ old('congregacao_id') == '' ? 'selected' : '' }}>TODOS</option>
              @foreach ($congregacoes as $congregacao)
                <option value="{{ $congregacao->id }}" {{ old('congregacao_id') == $congregacao->id ? 'selected' : '' }}>{{ $congregacao->nome }}</option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Meses --}}
        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Meses:</label>
          </div>
          <div class="col-lg-6">
            <select id="mes" name="mes" class="form-control @error('mes') is-invalid @enderror" >
              <option value="" {{ old('mes') == '' ? 'selected hidden' : '' }}>Selecione</option>
              <option value="1" {{ old('mes') == '1' ? 'selected' : '' }}>JANEIRO</option>
              <option value="2" {{ old('mes') == '2' ? 'selected' : '' }}>FEVEREIRO</option>
              <option value="3" {{ old('mes') == '3' ? 'selected' : '' }}>MARÇO</option>
              <option value="4" {{ old('mes') == '4' ? 'selected' : '' }}>ABRIL</option>
              <option value="5" {{ old('mes') == '5' ? 'selected' : '' }}>MAIO</option>
              <option value="6" {{ old('mes') == '6' ? 'selected' : '' }}>JUNHO</option>
              <option value="7" {{ old('mes') == '7' ? 'selected' : '' }}>JULHO</option>
              <option value="8" {{ old('mes') == '8' ? 'selected' : '' }}>AGOSTO</option>
              <option value="9" {{ old('mes') == '9' ? 'selected' : '' }}>SETEMBRO</option>
              <option value="10" {{ old('mes') == '10' ? 'selected' : '' }}>OUTUBRO</option>
              <option value="11" {{ old('mes') == '11' ? 'selected' : '' }}>NOVEMBRO</option>
              <option value="12" {{ old('mes') == '12' ? 'selected' : '' }}>DEZEMBRO</option>
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
                  <input checked type="checkbox" name="vinculo[]" id="vinculo_membro" value="M" class="new-control-input">
                  <span class="new-control-indicator"></span>Membro
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox checkbox-outline-success">
                  <input checked type="checkbox" name="vinculo[]" value="C" class="new-control-input">
                  <span class="new-control-indicator"></span>Congregado
                </label>
              </div>
            </div>
            <div class="form-check form-check-inline">
              <div class="n-chk">
                <label class="new-control new-checkbox checkbox-outline-success">
                  <input checked type="checkbox" name="vinculo[]" value="V" class="new-control-input">
                  <span class="new-control-indicator"></span>Visitante
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
@isset($membros)
  <div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
          <div class="row">
              <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                  <h4 style="text-transform: uppercase">RELATÓRIO SECRETARIA MEMBRESIA - {{ session()->get('session_perfil')->instituicoes->igrejaLocal->nome }}</h4>
                  <p class="pl-3">Vínculo: {{ $vinculos }}</p>
                  <p class="pl-3">Meses: {{ $mes }}</p>
                  <p class="pl-3">Onde Congrega: {{ $ondeCongrega }}</p>
                  <p class="pl-3">Registros Encontrados: {{ $membros->count() }}</p>
              </div>
          </div>
        </div>
        <div class="widget-content widget-content-area">
          
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-4">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>ANIVERSÁRIO</th>
                            <th>NASCIMENTO</th>
                            <th>IDADE</th>
                            <th>TELEFONE</th>
                            <th>ONDE CONGREGA</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($membros as $membro)
                          <tr>
                            <td>{{ $membro->nome }}</td>
                            <td>{{ $membro->aniversario }}</td>
                            <td>{{ optional($membro->data_nascimento)->format('d/m/Y') }}</td>
                            <td>{{ $membro->idade }}</td>
                            <td>{{ formatStr($membro->contato, '(##) #####-####') }}</td>
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
  $('#btn_buscar').click(function () {
    $('#filter_form').removeAttr('target');
  })
  
  $('#btn_relatorio').click(function () {
    $('#filter_form').attr('target', '_blank');
  })
</script>
@endsection