@extends('template.layout')
@section('breadcrumb')
@if ($mode == 'create')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Membros', 'url' => '/membros/', 'active' => false],
    ['text' => 'Novo', 'url' => '/membros/form/', 'active' => true]
]"></x-breadcrumb>
@else
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Secretaria', 'url' => '/', 'active' => false],
    ['text' => 'Membros', 'url' => '/membros/', 'active' => false],
    ['text' => 'Editar', 'url' => '/membros/form/', 'active' => true]
]"></x-breadcrumb>
@endif
@endsection
@section('content')
<div style="margin: 0px 23px;">
  <div class="row">
      <div class="col-md-12">
          <h4>{{$mode == 'create' ? 'Novo Membro' : 'Editar Membro'}}</h4>
      </div>
  </div>
    <div class="row">
      <div class="col-md-12">
          <form action="" method="POST" id="post-form">
              @csrf
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="personal-data-tab" data-bs-toggle="tab" data-bs-target="#personal-data" type="button" role="tab" aria-controls="personal-data" aria-selected="true">
                        Dados Pessoais
                      </button>
                  </li>
                  <li class="nav-item" role="presentation">
                      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                        Contatos
                      </button>
                  </li>
                  <li class="nav-item" role="presentation">
                      <button class="nav-link" id="family-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab" aria-controls="family" aria-selected="false">
                        Familiar
                      </button>
                  </li>
                  <li class="nav-item" role="presentation">
                      <button class="nav-link" id="family-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab" aria-controls="family" aria-selected="false">
                        Ministerial
                      </button>
                  </li>
                  <li class="nav-item" role="presentation">
                      <button class="nav-link" id="family-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab" aria-controls="family" aria-selected="false">
                        Formação Eclesiástica
                      </button>
                  </li>
                  <li class="nav-item" role="presentation">
                      <button class="nav-link" id="family-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab" aria-controls="family" aria-selected="false">
                        Histórico Eclesiástico
                      </button>
                  </li>
              </ul>
              <div class="tab-content" style="background-color: #fff; border: 1px solid #dee2e6; border-top: none">
                <div class="tab-pane fade show active" id="personal-data" role="tabpanel" aria-labelledby="personal-data-tab">
                  <div class="form-group @error('nome') has-error @enderror" style="padding: 8px 0px;">
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
              </div>
          </form>
      </div>
    </div>
</div>

<script src="{{ asset('/membros/js/form.js') }}"></script>


@endsection