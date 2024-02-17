@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Membros', 'url' => '/membro/', 'active' => false],
    ['text' => 'Editar', 'url' => '#', 'active' => true]
]"></x-breadcrumb>

@endsection
@section('extras-css')
  <link href="{{ asset('theme/assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div style="margin: 0px 23px;">
  {{-- <div class="row">
      <div class="col-md-12">
          <h4>Novo Congregado</h4>
      </div>
  </div> --}}
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
                <li class="nav-item">
                  <a class="nav-link" id="border-top-historicoeclesiastico" data-toggle="tab" href="#border-top-historico" role="tab" aria-controls="border-top-historico" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg> 
                    Histórico Eclesiástico
                  </a>
                </li>
            </ul>
            <div class="tab-content" id="borderTopContent">
                <div class="tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel" aria-labelledby="border-top-dados-pessoais">
                   <!-- CONTEUDO-->
                      <blockquote class="blockquote">
                        <div class="form-group @error('nome') has-error @enderror">
                          <div class="row mb-4">
                            <div class="col-md-6">
                              <label for="nome">* Nome</label>
                              <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                              @error('nome')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                  
                            <div class="col-md-3">
                              <label for="cpf">* CPF</label>
                              <input type="number" class="form-control" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
                              @error('cpf')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            
                            <div class="col-md-3">
                              <label for="nascimento">* Dia de Nascimento</label>
                              <input type="date" class="form-control" id="nascimento" name="nascimento" value="{{ old('nascimento') }}" required>
                              @error('nascimento')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                          </div>
                          
                          <div class="row mb-4">
                            <div class="col-md-3">
                              <label for="sexo">* Sexo</label>
                              <select class="form-control" id="sexo" name="sexo" required>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                              </select>
                              @error('sexo')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                  
                            <div class="col-md-3">
                              <label for="estado-civil">* Estado Civíl</label>
                              <select class="form-control" id="estado-civil" name="estado-civil" required>
                                <option value="S">Solteiro</option>
                                <option value="C">Casado</option>
                                <option value="D">Divorciado</option>
                                <option value="V">Viúvo</option>
                              </select>
                              @error('estado-civil')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            
                            <div class="col-md-3">
                              <label for="nacionalidade">* Nacionalidade</label>
                              <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" value="{{ old('nacionalidade') }}" required>
                              @error('nacionalidade')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                  
                            <div class="col-md-3">
                              <label for="uf">* UF</label>
                              <select class="form-control" id="uf" name="uf" required>
                                <!-- Opções de UF -->
                              </select>
                              @error('uf')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                          </div>
                          
                          <div class="row mb-4">
                            <div class="col-md-3">
                              <label for="rol">* No. Rol</label>
                              <input type="number" class="form-control" id="rol" name="rol" value="{{ old('rol') }}" required>
                              @error('rol')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                  
                            <div class="col-md-3">
                              <label for="data-conversao">Data de Conversão</label>
                              <input type="date" class="form-control" id="data-conversao" name="data-conversao" value="{{ old('data-conversao') }}">
                              @error('data-conversao')
                              <span class="help-block text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                          </div>
                        </div>   
                      </blockquote>                      
                </div>
                <div class="tab-pane fade" id="border-top-familia" role="tabpanel" aria-labelledby="border-top-familiar">
                  <blockquote class="blockquote">
                    Familia
                </blockquote>
                </div>
                <div class="tab-pane fade" id="border-top-contato" role="tabpanel" aria-labelledby="border-top-contatos">
                  <blockquote class="blockquote">
                    Contato
                </blockquote>
                </div>
                <div class="tab-pane fade" id="border-top-ministerio" role="tabpanel" aria-labelledby="border-top-ministerial">
                    <blockquote class="blockquote">
                        Ministerio
                    </blockquote>
                </div>
                <div class="tab-pane fade" id="border-top-formacao" role="tabpanel" aria-labelledby="border-top-formacao">
                  <blockquote class="blockquote">
                    Formação Eclesiástica
                </blockquote>
                </div>
                <div class="tab-pane fade" id="border-top-historico" role="tabpanel" aria-labelledby="border-top-historico">
                  <blockquote class="blockquote">
                    Histórico Eclesiástico
                </blockquote>
                </div>
            </div>
          </div>
      </div>
    </div>
</div>

<script src="{{ asset('/congregados/js/create.js') }}"></script>

@endsection
