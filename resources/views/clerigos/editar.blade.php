@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[['text' => 'Clérigos', 'url' => '/', 'active' => true]]"></x-breadcrumb>
@endsection
@section('extras-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }

        .modal-xl {
            max-width: 90% !important;
        }
    </style>
@endsection

@section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
@endsection

@include('extras.alerts')

@section('content')
    <div class="container-fluid">
        <div class="widget-header">
            <div class="tabs">
                <ul class="nav nav-tabs" id="instituicaoTabs" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link" href="" data-tab="tab_dados_clerigo" role="tab_dados_clerigo">Dados
                            Clérigos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-tab="tab_endereco" role="tab_endereco">Endereço</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-tab="tab_registro_geral" role="tab_registro_geral">Registro
                            Geral</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-tab="tab_carteira_trabalho"
                            role="tab_carteira_trabalho">Carteira de
                            Trabalho</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-tab="tab_pis_pasep" role="tab_pis_pasep">Pis/Pasep</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-tab="tab_eleitor" role="tab_eleitor">Título de Eleitor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-tab="tab_habilitacao" role="tab_habilitacao">Carteira de
                            Habilitação</a>
                    </li>

                    <!-- Adicione mais abas conforme necessário -->
                </ul>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Editar Dados do Clérigo</h4>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="d-flex flex-column align-items-start justify-content-start m-0 p-0" style="list-style: none">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form class="py-4" method="POST" action="{{ route('clerigos.update', $clerigo->id) }}">
            @csrf
            @method('PUT')

            <div id="tab_dados_clerigo">
                <div class="row">
                    <div class="col-12 mt-3 col-md-5">
                        <label for="nome">Nome*</label>
                        <input class="form-control" type="text" id="nome" name="nome"
                            value="{{ old('nome', $clerigo->nome) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="tipo">Tipo*</label>
                        <select class="form-control" id="tipo" name="tipo">
                            <option value="CLE" {{ $clerigo->tipo == 'CLE' ? 'selected' : '' }}>CLE</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="categoria">Categoaria*</label>
                        <select class="form-control" type="text" id="categoria" name="categoria">
                            <option value="missionária">Missionária</option>
                            <option value="pastor">Pastor</option>
                            <option value="ministro">Ministro</option>
                            <option value="bispo">Bispo</option>
                        </select>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cpf">CPF*</label>
                        <input type="text" class="form-control" id="cpf" name="cpf"
                            value="{{ old('cpf', $clerigo->cpf) }}" required>
                    </div>

                    <input type="hidden" name="regiao_id" id="regiao_id" value="23">
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="formacao_id">Formação*</label>
                        <select class="form-control" id="formacao_id" name="formacao_id">
                            @foreach ($formacoes as $formacao)
                                <option value="{{ $formacao->id }}"
                                    {{ $clerigo->formacao_id == $formacao->id ? 'selected' : '' }}>{{ $formacao->nivel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $clerigo->email) }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="sexo">Sexo*</label>
                        <select class="form-control" id="sexo" name="sexo">
                            <option value="M" {{ $clerigo->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ $clerigo->sexo == 'F' ? 'selected' : '' }}>Feminino</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="estado_civil">Estado civil*</label>
                        <select class="form-control" id="estado_civil" name="estado_civil">
                            <option value="Solteiro" {{ $clerigo->estado_civil == 'Solteiro' ? 'selected' : '' }}>Solteiro
                            </option>
                            <option value="Casado" {{ $clerigo->estado_civil == 'Casado' ? 'selected' : '' }}>Casado
                            </option>
                            <option value="Viúvo" {{ $clerigo->estado_civil == 'Viúvo' ? 'selected' : '' }}>Viúvo</option>
                            <option value="Divorciado" {{ $clerigo->estado_civil == 'Divorciado' ? 'selected' : '' }}>
                                Divorciado</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_mae">Nome da Mãe</label>
                        <input type="text" class="form-control" id="nome_mae" name="nome_mae"
                            value="{{ old('nome_mae', $clerigo->nome_mae) }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_pai">Nome do Pai</label>
                        <input type="text" class="form-control" id="nome_pai" name="nome_pai"
                            value="{{ old('nome_pai', $clerigo->nome_pai) }}">
                    </div>
                </div>
            </div>

            <div id="tab_endereco" class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cep">CEP*</label>
                        <input type="text" class="form-control" id="cep" name="cep"
                            value="{{ old('cep', $clerigo->cep) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-8">
                        <label for="endereco">Logradouro (Rua/Av/Beco)*</label>
                        <input type="text" class="form-control" id="endereco" name="endereco"
                            value="{{ old('endereco', $clerigo->endereco) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="numero">Número</label>
                        <input type="number" class="form-control" id="numero" name="numero"
                            value="{{ old('numero', $clerigo->numero) }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="bairro">Bairro*</label>
                        <input type="text" class="form-control" id="bairro" name="bairro"
                            value="{{ old('bairro', $clerigo->bairro) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cidade">Cidade*</label>
                        <input type="text" class="form-control" id="cidade" name="cidade"
                            value="{{ old('cidade', $clerigo->cidade) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="uf">Estado*</label>
                        <select class="form-control" id="uf" name="uf" required>
                            @foreach ($ufs as $uf)
                                <option value="{{ $uf }}">{{ $uf }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="pais">País</label>
                        <select class="form-control" type="text" id="pais" name="pais">
                            <option value="">Brasil</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="telefone_preferencial">Telefone Preferencial*</label>
                        <input type="text" class="form-control" id="telefone_preferencial"
                            name="telefone_preferencial"
                            value="{{ old('telefone_preferencial', $clerigo->telefone_preferencial) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="celular">Celular*</label>
                        <input type="text" class="form-control" id="celular" name="celular"
                            value="{{ old('celular', $clerigo->celular) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="residencia_propria">Residência Própria</label>
                        <select class="form-control" type="text" id="residencia_propria" name="residencia_propria">
                            <option value="0" {{$clerigo->residencia_propria == '0' ? 'selected' : ''}}>Não</option>
                            <option value="1" {{$clerigo->residencia_propria == '1' ? 'selected' : ''}}>Sim</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="residencia_propria_fgts">Utilizou FGTS?</label>
                        <select class="form-control" type="text" id="residencia_propria_fgts"
                            name="residencia_propria_fgts">
                            <option value="0" {{$clerigo->residencia_propria_fgts == '0' ? 'selected' : ''}}>Não</option>
                            <option value="1" {{$clerigo->residencia_propria_fgts == '1' ? 'selected' : ''}}>Sim</option>
                        </select>
                    </div>
                </div>
            </div>
            </div>


            <div id="tab_registro_geral" class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="identidade">Identidade*</label>
                        <input type="text" class="form-control" id="identidade" name="identidade"
                            value="{{ old('identidade', $clerigo->identidade) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="data_emissao">Data de Emissão*</label>
                        <input type="date" class="form-control" id="data_emissao"
                            name="data_emissao"
                            value="{{ old('data_emissao', $clerigo->data_emissao) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="orgao_emissor">Órgão Emissor*</label>
                        <input type="text" class="form-control" id="orgao_emissor" name="orgao_emissor"
                            value="{{ old('orgao_emissor', $clerigo->orgao_emissor) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="identidade_uf">Estado</label>
                        <select class="form-control" type="text" id="identidade_uf" name="identidade_uf">
                            <option value="{{ old('identidade_uf', $clerigo->identidade_uf) }}">{{ old('identidade_uf', $clerigo->identidade_uf) }}</option>
                            @foreach ($ufs as $uf)
                                <option value="{{ $uf }}">{{ $uf }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="tab_carteira_trabalho" class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="ctps">Número da CTPS*</label>
                        <input type="text" class="form-control" id="ctps" name="ctps"
                            value="{{ old('ctps', $clerigo->ctps) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="ctps_emissao">Data de Emissão*</label>
                        <input type="date" class="form-control" id="ctps_emissao" name="ctps_emissao"
                            value="{{ old('ctps_emissao', $clerigo->ctps_emissao) }}" required>
                    </div>
                    {{-- <div class="col-12 mt-3 col-md-4">
                        <label for="ctps_serie">Série*</label>
                        <input type="text" class="form-control" id="ctps_serie" name="ctps_serie"
                            value="{{ old('ctps_serie', $clerigo->ctps_serie) }}" required>
                    </div> --}}
                </div>
            </div>

            <div id="tab_pis_pasep" class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="pispasep">Número do PIS/PASEP*</label>
                        <input type="text" class="form-control" id="pispasep" name="pispasep"
                            value="{{ old('pispasep', $clerigo->pispasep) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="pispasep_emissao">Data de Emissão*</label>
                        <input type="date" class="form-control" id="pispasep_emissao" name="pispasep_emissao"
                            value="{{ old('pispasep_emissao', $clerigo->pispasep_emissao) }}" required>
                    </div>
                </div>
            </div>

            <div id="tab_eleitor" class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor">Número do Título de Eleitor*</label>
                        <input type="text" class="form-control" id="titulo_eleitor" name="titulo_eleitor"
                            value="{{ old('titulo_eleitor', $clerigo->titulo_eleitor) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor_zona">Zona*</label>
                        <input type="text" class="form-control" id="titulo_eleitor_zona" name="titulo_eleitor_zona"
                            value="{{ old('titulo_eleitor_zona', $clerigo->titulo_eleitor_zona) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor_secao">Seção*</label>
                        <input type="text" class="form-control" id="titulo_eleitor_secao" name="titulo_eleitor_secao"
                            value="{{ old('titulo_eleitor_secao', $clerigo->titulo_eleitor_secao) }}" required>
                    </div>
                </div>
            </div>

            <div id="tab_habilitacao" class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao">Número da Habilitação*</label>
                        <input type="text" class="form-control" id="habilitacao" name="habilitacao"
                            value="{{ old('habilitacao', $clerigo->habilitacao) }}" required>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_categoria">Categoria*</label>
                            <select class="form-control" type="text" id="habilitacao_categoria"
                            name="habilitacao_categoria">
                                <option value="ACC"{{ $clerigo->habilitacao_categoria == 'ACC' ? 'selected' : 'ACC'}}>A</option>
                                <option value="A"{{ $clerigo->habilitacao_categoria == 'A' ? 'selected' : 'A'}}>A</option>
                                <option value="B"{{ $clerigo->habilitacao_categoria == 'B' ? 'selected' : 'B'}}>B</option>
                                <option value="C" {{ $clerigo->habilitacao_categoria == 'C' ? 'selected' : 'C'}}>C</option>
                                <option value="D" {{ $clerigo->habilitacao_categoria == 'D' ? 'selected' : 'D'}}>D</option>
                                <option value="E" {{ $clerigo->habilitacao_categoria == 'E' ? 'selected' : 'E'}}>E</option>
                            </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_emissor">Emissor</label>
                        <input type="text" class="form-control"  id="habilitacao_emissor"
                            name="habilitacao_emissor" value="{{$clerigo->habilitacao_emissor}}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_uf">Estado</label>
                        <input type="text" class="form-control" id="habilitacao_uf"
                            name="habilitacao_uf" value="{{$clerigo->habilitacao_uf}}">
                    </div>
                </div>
            </div>

            <div class="d-flex my-3 justify-content-between align-items-center">
                <button type="button" id="backBtn" class="btn btn-primary text-start"> <-Voltar </button>
                        <button type="button" id="nextBtn" class="btn btn-primary text-end"> Proximo-> </button>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('clerigos.index') }}" class="btn btn-secondary text-start">Cancelar</a>
                <div id="button-container" class="d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
         $(document).ready(function() {
            $('#cep').mask('00000000');
            $('#telefone_preferencial').mask('00000-0000');
            $('#cpf').mask('000.000.000-00');
            $('#celular').mask('(00) 00000-0000');
            $('#identidade').mask('00 000 000-0');
            $('#cnpj').mask('00.000.000/0000-00', {
                reverse: true
            });


        })
        const tabs = document.querySelectorAll('[role^="tab_"]');
        const formulariosId = document.querySelectorAll('[id^="tab_"]');
        const urlAtual = new URL(window.location.href);

        const params = new URLSearchParams(window.location.search);
        let UrlTabId = params.get('tab') || 'tab_dados_clerigo'; // Define uma aba padrão
        handleTabChange(UrlTabId);

        tabs.forEach(tab => {
            tab.addEventListener('click', function(event) {
                event.preventDefault()


                const newTabId = this.getAttribute('data-tab');
                UrlTabId = newTabId;

                urlAtual.searchParams.set('tab', UrlTabId);
                window.history.pushState({}, '', urlAtual);


                handleTabChange(newTabId);
            });
        });

        // Função para alterar as abas
        function handleTabChange(newTabId) {
            tabs.forEach(tab => {
                tab.classList.toggle('active', tab.getAttribute('data-tab') === newTabId);
            });

            formulariosId.forEach(formulario => {
                const inputs = formulario.querySelectorAll('.col-12');
                inputs.forEach(input => {
                    input.style.display = 'none';
                });
            });

            const formCheck = document.getElementById(newTabId);
            const inputs = formCheck.querySelectorAll('.col-12');
            inputs.forEach(input => {
                input.style.display = 'block';
            });

        }

        // Inicializa com a aba atual da URL


        // Funções para navegação entre os formulários
        const listForms = Array.from(formulariosId);
        const nextBtn = document.querySelector('#nextBtn');
        const backBtn = document.querySelector('#backBtn');
        const total = listForms.length;

        nextBtn.addEventListener('click', proximoForm);
        backBtn.addEventListener('click', anteriorForm);


        function proximoForm(event) {
            event.preventDefault();
            const indice = listForms.indexOf(document.getElementById(UrlTabId));
            console.log(UrlTabId);

            if (indice < total - 1) {
                UrlTabId = listForms[indice + 1].id;

                urlAtual.searchParams.set('tab', UrlTabId);
                window.history.pushState({}, '', urlAtual);
                handleTabChange(UrlTabId);

            }
        }

        function anteriorForm(event) {
            event.preventDefault();
            const indice = listForms.indexOf(document.getElementById(UrlTabId));

            if (indice > 0) {
                UrlTabId = listForms[indice - 1].id;
                urlAtual.searchParams.set('tab', UrlTabId);
                window.history.pushState({}, '', urlAtual);
                handleTabChange(UrlTabId);

            }
        }


    </script>
@endsection
