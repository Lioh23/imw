@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Clérigos', 'url' => '/clerigos', 'active' => false],
        ['text' => 'Novo', 'url' => '#', 'active' => true],
    ]">
    </x-breadcrumb>
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
            /* Define que o modal ocupe 90% da largura da página */
        }
    </style>
@endsection

@section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
@endsection

@include('extras.alerts')

@section('content')
    <div class="container-fluid" style="background: #fff">
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


        <div class="widget-header ">
            <h4>Dados do usuário</h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">

                    <p class="my-1">{{ $errors->first() }}</p>

            </div>
        @endif
        <form class="py-2 px-3" method="POST" action="{{ route('clerigos.store') }}">
            @csrf
            <div id="tab_dados_clerigo">

                <div class="row">
                    <div class="col-12 mt-3 col-md-5">
                        <label for="nome">* Nome</label>
                        <input class="form-control" type="text" id="nome" name="nome"
                            value="{{ old('nome') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="categoria">* Categoria</label>
                        <select class="form-control" type="text" id="categoria" name="categoria">
                            <option value="missionária">Missionária</option>
                            <option value="pastor">Pastor</option>
                            <option value="ministro">Ministro</option>
                            <option value="bispo">Bispo</option>
                        </select>

                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cpf">* CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf"
                            value="{{ old('cpf') }}">

                    </div>


                </div>

                <div class="row">
                    <input type="hidden" name="regiao_id" id="regiao_id" value="23">
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="formacao_id">* Formação</label>
                        <select class="form-control" type="text" id="formacao_id" name="formacao_id"
                            value="{{ old('formacao_id') }}">
                            @foreach ($formacoes as $formacao)
<option value="{{ $formacao->id }}">{{ $formacao->nivel }}
                            </option>
                            @endforeach
                            <option value=""></option>
                        </select>

                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}">

                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="sexo">* Sexo</label>
                        <select class="form-control" type="text" id="sexo" name="sexo">
                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="estado_civil">* Estado civil</label>
                        <select class="form-control" type="text" id="estado_civil" name="estado_civil"
                            value="{{ old('estado_civil') }}">
                            <option value="1" {{ old('estado_civil') == 'solteiro' ? 'selected' : '' }}>Solteiro
                            </option>
                            <option value="2" {{ old('estado_civil') == 'casado' ? 'selected' : '' }}>Casado
                            </option>
                            <option value="3" {{ old('estado_civil') == 'divorciado' ? 'selected' : '' }}>
                                Divorciado
                            </option>
                            <option value="4" {{ old('estado_civil') == 'viuvo' ? 'selected' : '' }}>Viúvo
                            </option>
                        </select>

                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_mae">Nome da Mãe</label>
                        <input type="text" class="form-control" id="nome_mae" name="nome_mae"
                            value="{{ old('nome_mae') }}">

                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_pai">Nome do Pai</label>
                        <input type="text" class="form-control" id="nome_pai" name="nome_pai"
                            value="{{ old('nome_pai') }}">
                    </div>
                </div>
            </div>

            <div id="tab_endereco" class="mt-4">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cep">* CEP</label>
                        <input type="text" class="form-control"id="cep" name="cep" value="{{ old('cep') }}">

                    </div>

                    <div class="col-12 mt-3 col-md-8">
                        <label for="endereco">* Logradouro (Rua/Av/Beco)*</label>
                        <input type="text" class="form-control" id="endereco" name="endereco"
                            value="{{ old('endereco') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="numero">* Numero</label>
                        <input type="number" class="form-control" id="numero" name="numero"
                            value="{{ old('numero') }}">

                    </div>

                    <div class="col-12 mt-3 col-md-4">
                        <label for="bairro">* Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro"
                            value="{{ old('bairro') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="complemento">Complemento</label>
                        <textarea class="form-control w-100" id="complemento" name="complemento" rows="4"
                            value="{{ old('complemento') }}"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="cidade">* Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade"
                            value="{{ old('cidade') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="uf">* Estado</label>
                        <select class="form-control" type="text" id="uf" name="uf">
                            @foreach ($ufs as $sigla => $uf)
                                <option value="{{ $sigla }}" {{ old('uf') == $uf ? 'selected' : '' }}>
                                    {{ $uf }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-3">
                        <label for="pais">País</label>
                        <select class="form-control" type="text" id="pais" name="pais"
                            value="{{ old('pais') }}">
                            <option value="BR">Brasil</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4 mt-3" style="gap:10px">
                        <label for="telefone_preferencial">* Telefone preferencial</label>
                        <input type="text" class="form-control" id="telefone_preferencial"
                            name="telefone_preferencial" value="{{ old('telefone_preferencial') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="celular">* Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular"
                            value="{{ old('celular') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="residencia_propria">* Residência Própria</label>
                        <select class="form-control" type="text" id="residencia_propria" name="residencia_propria">
                            <option value="0" {{ old('residencia_propria') == '0' ? 'selected' : '' }}>Não
                            </option>
                            <option value="1" {{ old('residencia_propria') == '1' ? 'selected' : '' }}>Sim
                            </option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="residencia_propria_fgts">Utilizou FGTS?</label>
                        <select class="form-control" type="text" id="residencia_propria_fgts"
                            name="residencia_propria_fgts">
                            <option value="0" {{ old('residencia_propria') == '0' ? 'selected' : '' }}>Não
                            </option>
                            <option value="1" {{ old('residencia_propria') == '1' ? 'selected' : '' }}>Sim
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="tab_registro_geral">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="identidade">* RG</label>
                        <input type="text" class="form-control" id="identidade" name="identidade"
                            value="{{ old('identidade') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="data_emissao">* Data de Emissão</label>
                        <input type="date" class="form-control" id="data_emissao" name="data_emissao"
                            value="{{ old('data_emissao') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="orgao_emissor">* Orgão Emissor</label>
                        <input type="text" class="form-control" id="orgao_emissor" name="orgao_emissor"
                            value="{{ old('orgao_emissor') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="identidade_uf">* Estado</label>
                        <select class="form-control" type="text" id="identidade_uf" name="identidade_uf">
                            @foreach ($ufs as $sigla => $uf)
                                <option value="{{ $sigla }}" {{ old('identidade_uf') == $uf ? 'selected' : '' }}>
                                    {{ $uf }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="tab_carteira_trabalho">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="ctps">* CTPS</label>
                        <input type="text" class="form-control" id="ctps" name="ctps"
                            value="{{ old('ctps') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="ctps_emissao">* Data de Emissão da CTPS</label>
                        <input type="date" class="form-control" id="ctps_emissao" name="ctps_emissao"
                            value="{{ old('ctps_emissao') }}">
                    </div>
                    {{-- <div class="col-12 mt-3 col-md-4">
                        <label for="ctps">CTPS Série</label>
                        <input type="text" class="form-control" type="text" id="ctps" name="ctps">
                    </div> --}}
                </div>
            </div>

            <div id="tab_pis_pasep">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="pispasep">* Pis/Pasep</label>
                        <input type="text" class="form-control" id="pispasep" name="pispasep"
                            value="{{ old('pispasep') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="pispasep_emissao">* Pis/Pasep Data de Emissão</label>
                        <input type="date" class="form-control" id="pispasep_emissao" name="pispasep_emissao"
                            value="{{ old('pispasep_emissao') }}">
                    </div>
                    {{-- <div class="col-12 mt-3 col-md-4">
                        <label for="pispasep_emissao">Pis/Pasep Série</label>
                        <input type="text" class="form-control" id="pispasep_emissao"
                            name="pispasep_emissao">
                    </div> --}}
                </div>
            </div>

            <div id="tab_eleitor">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor">* Título de Eleitor</label>
                        <input type="text" class="form-control" id="titulo_eleitor" name="titulo_eleitor"
                            value="{{ old('titulo_eleitor') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor_zona">* Zona</label>
                        <input type="text" class="form-control" id="titulo_eleitor_zona" name="titulo_eleitor_zona"
                            value="{{ old('titulo_eleitor_zona') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor_secao">* Seção</label>
                        <input type="text" class="form-control" id="titulo_eleitor_secao" name="titulo_eleitor_secao"
                            value="{{ old('titulo_eleitor_secao') }}">
                    </div>
                </div>
            </div>

            <div id="tab_habilitacao">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao">* Habilitacação</label>
                        <input type="text" class="form-control" id="habilitacao" name="habilitacao"
                            value="{{ old('habilitacao') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_categoria" value="{{ old('categoria') }}">* Categoria</label>
                        <select class="form-control" type="text" id="habilitacao_categoria"
                            name="habilitacao_categoria">
                            {{-- <option value="ACC" {{old('habilitacao_categoria') == 'ACC' ? 'selected' : ''}}>ACC</option> --}}
                            <option value="A" {{ old('habilitacao_categoria') == 'A' ? 'selected' : '' }}>A
                            </option>
                            <option value="B" {{ old('habilitacao_categoria') == 'B' ? 'selected' : '' }}>B
                            </option>
                            <option value="C" {{ old('habilitacao_categoria') == 'C' ? 'selected' : '' }}>C
                            </option>
                            <option value="D" {{ old('habilitacao_categoria') == 'D' ? 'selected' : '' }}>D
                            </option>
                            <option value="E" {{ old('habilitacao_categoria') == 'E' ? 'selected' : '' }}>E
                            </option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_emissor">* Emissor</label>
                        <input type="text" class="form-control" id="habilitacao_emissor" name="habilitacao_emissor"
                            value="{{ old('habilitacao_emissor') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_uf">* Estado</label>
                        <select class="form-control" type="text" id="habilitacao_uf" name="habilitacao_uf">
                            @foreach ($ufs as $sigla => $uf)
                                <option value="{{ $sigla }}" {{ old('habilitacao_uf') == $uf ? 'selected' : '' }}>
                                    {{ $uf }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- <div class="d-flex my-3 justify-content-between align-items-center">
                <button type="button" id="backBtn" class="btn btn-primary text-start"> <-Voltar </button>
                        <button type="button" id="nextBtn" class="btn btn-primary text-end"> Proximo-> </button>
            </div> --}}
            <div class="d-flex justify-content-start align-items-center mt-3">
                <div id="button-container" class="d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </div>

        </form>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        document.querySelector('form').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Impede o envio do formulário
            }
        });


        $(document).ready(function() {
            $('#cep').mask('00000-000');
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

        function buscarCep() {
            let cep = document.getElementById('cep').value;

            if (cep !== "") {
                let url = "https://brasilapi.com.br/api/cep/v1/" + cep;
                let req = new XMLHttpRequest()
                req.open("GET", url);
                req.send()

                req.onload = function() {
                    if (req.status === 200) {
                        let endereco = JSON.parse(req.response)
                        document.getElementById('endereco').value = endereco.street
                        document.getElementById('bairro').value = endereco.neighborhood
                        document.getElementById('cidade').value = endereco.city
                        let estado = endereco.state;
                        let ufSelect = document.getElementById('uf');

                        // Itera pelas opções e seleciona a que corresponde ao estado
                        for (let i = 0; i < ufSelect.options.length; i++) {
                            if (ufSelect.options[i].value === estado) {
                                console.log(ufSelect.options[i].value)
                                ufSelect.selectedIndex = i;
                                console.log(ufSelect.selectedIndex)
                                break;
                            }
                        }

                    }
                }

            }
        }

        window.onload = function() {
            let cep = document.getElementById('cep')
            cep.addEventListener("blur", buscarCep)
        }
    </script>
@endsection
