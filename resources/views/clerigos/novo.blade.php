@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[['text' => 'Instituições', 'url' => '/', 'active' => true]]"></x-breadcrumb>
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
    <div class="container-fluid">
        <div class="widget-header">
            <div class="tabs">
                <ul class="nav nav-tabs" id="instituicaoTabs" role="list_tab">
                    <li class="nav-item">
                        <a class="nav-link" href="?tab=tab_dados_clerigo" role="tab_dados_clerigo">Dados do
                            Clérigo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?tab=tab_endereco" role="tab_endereco">Endereço</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?tab=tab_registro_geral" role="tab_registro_geral">Registro Geral</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?tab=tab_carteira_trabalho" role="tab_carteira_trabalho">Carteira de
                            Trabalho</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?tab=tab_pis" role="tab_pis">Tab Pis/Pasep</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?tab=tab_titulo_eleitor" role="tab_titulo_eleitor">Título de Eleitor</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="?tab=tab_habilitacao" role="tab_habilitacao">Carteira de Habilitação</a>
                    </li>

                    <!-- Adicione mais abas conforme necessário -->
                </ul>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Dados do usuário</h4>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class=" d-flex flex-column align-items-start justify-content-start m-0 p-0" style="list-style: none">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="py-4" method="POST" action="{{ route('clerigos.store') }}">
            @csrf
            <div id="tab_dados_clerigo">
                <div class="row">
                    <div class="col-12 mt-3 col-md-6">
                        <label for="nome">Nome*</label>
                        <input class="form-control" type="text" id="nome" name="nome">
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="tipo">Tipo*</label>
                        <input class="form-control" type="text" id="tipo" name="tipo">

                    </div>

                    <div class="col-12 mt-3 col-md-3">
                        <label for="data_abertura">Regime*</label>
                        <select name="" id="" class="form-control">
                            <option value="">Integral </option>
                            <option value="">Parcial </option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cpf">CPF*</label>
                        <input class="form-control" type="text" id="cpf" name="cpf">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="tipo">Data de Consagração*</label>
                        <input class="form-control" type="text" id="tipo" name="tipo">

                    </div>

                    <div class="col-12 mt-3 col-md-4">
                        <label for="data_abertura">Nacionalidade</label>
                        <input type="text" name="" id="" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="escolaridade">Formação*</label>
                        <input class="form-control" type="text" id="escolaridade" name="escolaridade">

                    </div>

                    <div class="col-12 mt-3 col-md-4">
                        <label for="sexo">Sexo*</label>
                        <select name="sexo" id="sexo" class="form-control">
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="estado_civil">Estado Cívil</label>
                        <select name="estado_civil" id="estado_civil" class="form-control"></select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_mae">Nome da Mãe</label>
                        <input class="form-control" type="text" id="nome_mae" name="nome_mae">

                    </div>

                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_pai">Nome da Pai</label>
                        <input type="text" name="nome_pai" id="nome_pai" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <input type="hidden" name="regiao_id" id="regiao_id" value="23">
                </div>
            </div>
            <div id="tab_endereco" class="">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="cep">CEP*</label>
                        <input type="text" class="form-control" type="text" id="cep" name="cep">

                    </div>

                    <div class="col-12 mt-3 col-md-8">
                        <label for="endereco">Logradouro (Rua/Av/Beco)*</label>
                        <input type="text" class="form-control" type="text" id="endereco" name="endereco">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="numero">Numero</label>
                        <input type="number" class="form-control" type="text" id="numero" name="numero">

                    </div>

                    <div class="col-12 mt-3 col-md-4">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" type="text" id="bairro" name="bairro">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="complemento">Complemento</label>
                        <textarea class="form-control w-100" type="text" id="complemento" name="complemento" rows="4"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-8">
                        <label for="cidade">Cidade</label>
                        <select name="cidade" id="cidade" class="form-control">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="uf">Estado</label>
                        <input type="text" class="form-control" type="text" id="uf" name="uf"
                            placeholder="xx">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-3">
                        <label for="pais">País</label>
                        <select name="pais" id="pais" class="form-control p-2">
                            <option value="">Brasil</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-4 d-flex align-items-end mt-3" style="gap:10px">
                        <div>
                            <input type="text" maxlength="3" class="form-control p-2" id="ddd" name="ddd"
                                style="max-width: 55px" placeholder="DDD">
                        </div>
                        <div>
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" type="text" id="telefone" name="telefone">
                        </div>
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" type="text" id="celular" name="celular">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 col-md-3">
                        <label for="residencia_propria">Rêsidencia*</label>
                        <select name="residencia_propria" class="form-control" id="residencia_propria">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="residencia_propria_fgts">Utilizou FGTS*</label>
                        <select name="residencia_propria_fgts" class="form-control" id="residencia_propria_fgts">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>

                </div>
            </div>
            <div id="tab_registro_geral">
                <div class="row">
                    <div class="col-12 mt-3 col-md-3">
                        <label for="indentidade">RG*</label>
                        <input class="form-control" type="text" id="indentidade" name="indentidade">
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="data_emissao">Data de Emissão*</label>
                        <input class="form-control" type="date" name="data_emissao" id="data_emissao">
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="orgao_emissor">Orgão Emissor*</label>
                        <input class="form-control" type="date" name="orgao_emissor" id="orgao_emissor">
                    </div>
                    <div class="col-12 mt-3 col-md-3">
                        <label for="identidade_uf">Estado*</label>
                        <input class="form-control" type="date" name="identidade_uf" id="identidade_uf">
                    </div>

                </div>

            </div>
            <div id="tab_carteira_trabalho">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="ctps">CTPS*</label>
                        <input class="form-control" type="text" id="ctps" name="ctps">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="ctps_emissao">Data de Emissão do CTPS*</label>
                        <input class="form-control" type="date" id="ctps_emissao" name="ctps_emissao">
                    </div>
                    {{-- <div class="col-12 mt-3 col-md-4">
                            <label for="pais">CTPS Série*</label>
                            <input class="form-control" type="date" id="ctps" name="ctps">
                        </div> --}}

                </div>

            </div>
            <div id="tab_pis">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="pispasep">Pis/Pasep*</label>
                        <input class="form-control" type="text" id="pispasep" name="pispasep">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="pispasep_emissao">Data de Emissão do Pis/Pasep*</label>
                        <input class="form-control" type="date" id="pispasep_emissao" name="pispasep_emissao">
                    </div>
                    {{-- <div class="col-12 mt-3 col-md-4">
                            <label for="pais">Pis/Pasep Série*</label>
                            <input class="form-control" type="date">
                        </div> --}}

                </div>

            </div>
            <div id="tab_titulo_eleitor">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor">Titulo de Eleitor*</label>
                        <input class="form-control" type="text" id="titulo_eleitor" name="titulo_eleitor">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor_zona">Zona*</label>
                        <input class="form-control" type="text" id="titulo_eleitor_zona" name="titulo_eleitor_zona">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="titulo_eleitor_secao">Seção*</label>
                        <input class="form-control" type="text" id="titulo_eleitor_secao"
                            name="titulo_eleitor_secao">
                    </div>

                </div>

            </div>
            <div id="tab_habilitacao">
                <div class="row">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao">Habilitação*</label>
                        <input class="form-control" type="text" id="habilitacao" name="habilitacao">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_categoria">Categoria*</label>
                        <input class="form-control" type="date" id="habilitacao_categoria"
                            name="habilitacao_categoria">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_emissor">Emissor*</label>
                        <input class="form-control" type="date" id="habilitacao_emissor" name="habilitacao_emissor">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="habilitacao_uf">Estado*</label>
                        <input class="form-control" type="date" id="habilitacao_uf" name="habilitacao_uf">
                    </div>

                </div>

            </div>

            <div class="d-flex align-items-center justify-content-between">

                <a id="voltarBtn" class="btn btn-primary my-4"><-Voltar </a>
                        <a id="proximoBtn" class="btn btn-primary my-4">Proximo-></a>
            </div>
            <button type="submit" class="btn btn-primary my-4">Salvar</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            $('#cep').mask('00000000');
            $('#telefone').mask('00000-0000');
            $('#cnpj').mask('00.000.000/0000-00', {
                reverse: true
            });
            $('#data_abertura').mask('00/00/0000');
        })

        const btnTabs = document.querySelectorAll('[role^="tab"]');
        const formsID = document.querySelectorAll('[id^="tab_"]')
        const voltarBtn = document.getElementById('voltarBtn');
        const proximoBtn = document.getElementById('proximoBtn');
        const params = new URLSearchParams(window.location.search);
        let urlTab = params.get('tab');

        if (urlTab) {
            // Oculta todos os formulários e define o tipo de input como "hidden"
            formsID.forEach(form => {
                // Aqui, supondo que você tenha um input dentro do form
                const input = form.querySelector('input'); // Se você quiser alterar o tipo de um input específico
                if (input) {
                    input.setAttribute('type', 'hidden');
                }
                form.style.display = 'none'; // Oculta o formulário
            });

            // Mostra o formulário correspondente ao urlTab
            const activeForm = document.getElementById(urlTab);
            if (activeForm) {
                const activeInput = activeForm.querySelector('input'); // Seleciona o input específico
                if (activeInput) {
                    activeInput.setAttribute('type', 'text'); // Define o tipo do input como "text"
                }
                activeForm.style.display = 'block'; // Torna o formulário visível
                const activeTab = Array.from(btnTabs).find(tab => tab.getAttribute('role') === urlTab);
                if (activeTab) {
                    activeTab.classList.add('active');
                }
            }
        }

        if (urlTab) {
            const activeForm = document.getElementById(urlTab);
            if (activeForm) {
                currentTabIndex = Array.from(formsID).indexOf(activeForm);
            }
        }
        showTab(currentTabIndex);

        function showTab(index) {
            formsID.forEach((form, i) => {
                if (i === index) {
                    form.style.display = 'block';
                    btnTabs[i].classList.add('active');
                } else {
                    form.style.display = 'none';
                    btnTabs[i].classList.remove('active');
                }
            });
            document.getElementById('voltarBtn').style.display = index > 0 ? 'inline-block' : 'none';
            document.getElementById('proximoBtn').style.display = index < formsID.length - 1 ? 'inline-block' : 'none';
        }
        
        document.getElementById('voltarBtn').addEventListener('click', () => {
            if (currentTabIndex > 0) {
                currentTabIndex--;
                showTab(currentTabIndex);
            }
        });

        document.getElementById('proximoBtn').addEventListener('click', () => {
            if (currentTabIndex < formsID.length - 1) {
                currentTabIndex++;
                showTab(currentTabIndex);
            }
        });
    </script>
@endsection
