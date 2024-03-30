@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Membros', 'url' => '/membro/', 'active' => false],
    ['text' => 'Recebimento de Membro Externo', 'url' => '#', 'active' => true]
]"></x-breadcrumb>
@endsection

@section('extras-css')
  <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@include('extras.alerts')

@section('content')
  <div class="statbox widget box box-shadow">
    <div class="widget-header">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
              <h4>{{ $pessoa->nome }}</h4>
            </div>
        </div>
    </div>

    <div class="widget-content widget-content-area">
      <form class="form-vertical" method="POST" action="{{ route('membro.receber_membro_externo.store', ['id' => $pessoa->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-dark border-0 mb-4" role="alert">
              <strong>
                ATENÇÃO!!! ESTA AÇÃO NÃO PODE SER REVERTIDA.<br> 
                Após receber este membro de outra igreja, o mesmo será excluído da igreja de origem.<br>
              </strong>
            </div> 
          </div>
        </div>

        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">* Data:</label>
          </div>
          <div class="col-lg-6">
            <input type="date" class="form-control @error('dt_notificacao') is-invalid @enderror" id="dt_notificacao" name="dt_notificacao" value="{{ old('dt_notificacao', date('Y-m-d')) }}" placeholder="ex: 31/12/2000">
            @error('dt_notificacao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-group row mb-4">
          <div class="col-lg-2 text-right">
            <label class="control-label">Congregação:</label>
          </div>
          <div class="col-lg-6">
            <select id="congregacao_id" name="congregacao_id" class="form-control @error('congregacao_id') is-invalid @enderror" >
              <option value="" {{ old('congregacao_id') == '' ? 'selected' : '' }}>Selecione</option>
              @foreach ($congregacoes as $congregacao)
                <option value="{{ $congregacao->id }}" {{ old('congregacao_id') == $congregacao->id ? 'selected' : '' }}>{{ $congregacao->nome }}</option>
              @endforeach
            </select>
            @error('modo_recepcao_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-group mt-4">
          <a href="{{ route('membro.editar', ['id' => $pessoa->id]) }}" class="btn btn-secondary">
            <x-bx-arrow-back/> Voltar
          </a>
          <button type="submit" class="btn btn-success">
            <x-bx-transfer-alt/> Aceitar
          </button>
          <button id="rejeitar" class="btn btn-primary">
            <x-bx-block/> Rejeitar
          </button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg> ... </svg>
                      </button>
                  </div>
                  <div class="modal-body">
                      <p class="modal-text">Mauris mi tellus, pharetra vel mattis sed, tempus ultrices eros. Phasellus egestas sit amet velit sed luctus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse potenti. Vivamus ultrices sed urna ac pulvinar. Ut sit amet ullamcorper mi. </p>
                  </div>
                  <div class="modal-footer">
                      <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                      <button type="button" class="btn btn-primary">Save</button>
                  </div>
              </div>
          </div>
      </div>

      </form>
    </div>


</div>
@endsection
@section('extras-scripts')
    <script>
    </script>
@endsection