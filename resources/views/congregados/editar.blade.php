@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Congregados', 'url' => '/congregado/', 'active' => false],
    ['text' => 'Tornar Congregado', 'url' => '#', 'active' => true]
]"></x-breadcrumb>

@endsection
@section('extras-css')
  <link href="{{ asset('theme/assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
  <style> 
    .centralizado {
        display: flex;
        justify-content: center;
        align-items: center;
    }
  </style>
@endsection
@section('content')
<div style="margin: 0px 23px;">
  {{-- <div class="row">
      <div class="col-md-12">
          <h4>Novo Congregado</h4>
      </div>
  </div> --}}
  <form method="POST" action="{{ route('congregado.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-md-12">
          <!-- conteudo -->
          <div class="widget-content widget-content-area border-top-tab">
            <ul class="nav nav-tabs mb-3 mt-3" id="borderTop" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="border-top-dados-pessoais" data-toggle="tab" href="#border-top-dados-pessoal" role="tab" aria-controls="border-top-dados-pessoais" aria-selected="true">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> 
                      Dados Pessoais
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="border-top-contatos" data-toggle="tab" href="#border-top-contato" role="tab" aria-controls="border-top-contato" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> 
                    Contatos
                  </a>
                </li>
                <li class="nav-item">       
                    <a class="nav-link" id="border-top-familiar" data-toggle="tab" href="#border-top-familia" role="tab" aria-controls="border-top-familia" aria-selected="false">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> 
                      Familiar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="border-top-ministerial" data-toggle="tab" href="#border-top-ministerio" role="tab" aria-controls="border-top-ministerio" aria-selected="false">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg> 
                      Ministerial
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="border-top-formacaoEclesiatica" data-toggle="tab" href="#border-top-formacao" role="tab" aria-controls="border-top-formacao" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg> 
                    Formação Eclesiática
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a class="nav-link" id="border-top-historicoeclesiastico" data-toggle="tab" href="#border-top-historico" role="tab" aria-controls="border-top-historico" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg> 
                    Histórico Eclesiástico
                  </a>
                </li> --}}
            </ul>
            <div class="tab-content" id="borderTopContent">
                @include('congregados.tab-dados-pessoal')
                @include('congregados.tab-familia')
                @include('congregados.tab-contato')
                @include('congregados.tab-ministerio')
                @include('congregados.tab-formacao')
           {{--      @include('congregados.tab-historico') --}}
            </div>
          </div>
      </div>
    </div>

    <div class="form-group mt-4" style="margin-top: -25px !important;">
      <button type="submit" title="Salvar como congregado" class="btn btn-primary btn-lg ml-4">Salvar</button>
  </div>

</form>
</div>
@endsection
@section('extras-scripts')
    <script src="{{ asset('congregados/js/editar.js') }}"></script>
@endsection