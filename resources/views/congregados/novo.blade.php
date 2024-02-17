@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Congregados', 'url' => '/congregado/', 'active' => false],
    ['text' => 'Novo', 'url' => '/congregado/novo/', 'active' => true]
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
                    <a class="nav-link active" id="border-top-dados-pessoais" data-toggle="tab" href="#border-top-dados-pessoal" role="tab" aria-controls="border-top-dados-pessoais" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Dados Pessoais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="border-top-profile-tab" data-toggle="tab" href="#border-top-profile" role="tab" aria-controls="border-top-profile" aria-selected="false"> Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="border-top-contact-tab" data-toggle="tab" href="#border-top-contact" role="tab" aria-controls="border-top-contact" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> Contatos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="border-top-setting-tab" data-toggle="tab" href="#border-top-setting" role="tab" aria-controls="border-top-setting" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings</a>
                </li>
            </ul>
            <div class="tab-content" id="borderTopContent">
                <div class="tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel" aria-labelledby="border-top-dados-pessoais">
                  <div class="form-group @error('nome') has-error @enderror">
                    <div style="display:flex; padding: 8px; width: 100%;">
                      <div class="col-sm-6">
                        <label for="nome">* Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                        @error('nome')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>

                      <div class="col-sm-3">
                        <label for="cpf">* CPF</label>
                        <input type="number" class="form-control" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
                        @error('cpf')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      
                      <div class="col-sm-3">
                        <label for="nascimento">* Dia de Nascimento</label>
                        <input type="date" class="form-control" id="nascimento" name="nascimento" value="{{ old('nascimento') }}" required>
                        @error('nascimento')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div style="display:flex; padding: 8px; width: 100%;">
                      <div class="col-sm-3">
                        <label for="sexo">* Sexo</label>
                        <select class="form-control" id="sexo" name="sexo" required>
                          <option value="M">Masculino</option>
                          <option value="F">Feminino</option>
                        </select>
                        @error('sexo')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>

                      <div class="col-sm-3">
                        <label for="estado-civil">* Estado Civíl</label>
                        <select class="form-control" id="estado-civil" name="estado-civil" required>
                          <option value="S">Solteiro</option>
                          <option value="C">Casado</option>
                          <option value="D">Divorciado</option>
                          <option value="V">Viúvo</option>
                        </select>
                        @error('estado-civil')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      
                      <div class="col-sm-3">
                        <label for="nacionalidade">* Nacionalidade</label>
                        <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" value="{{ old('nacionalidade') }}" required>
                        @error('nacionalidade')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-sm-3">
                        <label for="nacionalidade">* UF</label>
                        <select class="form-control" id="uf" name="uf" required>
                          <option value="AC">Acre</option>
                          <option value="AL">Alagoas</option>
                          <option value="AP">Amapá</option>
                          <option value="AM">Amazonas</option>
                          <option value="BA">Bahia</option>
                          <option value="CE">Ceará</option>
                          <option value="DF">Distrito Federal</option>
                          <option value="ES">Espírito Santo</option>
                          <option value="GO">Goiás</option>
                          <option value="MA">Maranhão</option>
                          <option value="MT">Mato Grosso</option>
                          <option value="MS">Mato Grosso do Sul</option>
                          <option value="MG">Minas Gerais</option>
                          <option value="PA">Pará</option>
                          <option value="PB">Paraíba</option>
                          <option value="PR">Paraná</option>
                          <option value="PE">Pernambuco</option>
                          <option value="PI">Piauí</option>
                          <option value="RJ">Rio de Janeiro</option>
                          <option value="RN">Rio Grande do Norte</option>
                          <option value="RS">Rio Grande do Sul</option>
                          <option value="RO">Rondônia</option>
                          <option value="RR">Roraima</option>
                          <option value="SC">Santa Catarina</option>
                          <option value="SP">São Paulo</option>
                          <option value="SE">Sergipe</option>
                          <option value="TO">Tocantins</option>
                        </select>
                        @error('nacionalidade')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div style="display:flex; padding: 8px; width: 100%;">
                      <div class="col-sm-3">
                        <label for="rol">* No. Rol</label>
                        <input type="number" class="form-control" id="rol" name="rol" value="{{ old('rol') }}" required>
                        @error('rol')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-sm-3">
                        <label for="data-conversao">Data de Conversão</label>
                        <input type="date" class="form-control" id="data-conversao" name="data-conversao" value="{{ old('data-conversao') }}">
                        @error('data-conversao')
                        <span class="help-block
                            text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>    
                </div>
                <div class="tab-pane fade" id="border-top-profile" role="tabpanel" aria-labelledby="border-top-profile-tab">
                    <div class="media">
                        <img class="mr-3" src="assets/img/90x90.jpg" alt="Generic placeholder image">
                        <div class="media-body">
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="border-top-contact" role="tabpanel" aria-labelledby="border-top-contact-tab">
                    <p class="dropcap  dc-outline-primary">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
                <div class="tab-pane fade" id="border-top-setting" role="tabpanel" aria-labelledby="border-top-setting-tab">
                    <blockquote class="blockquote">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    </blockquote>
                </div>
            </div>
          </div>
      </div>
    </div>
</div>

<script src="{{ asset('/congregados/js/create.js') }}"></script>

@endsection
