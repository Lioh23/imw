@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Financeiro', 'url' => '/', 'active' => false],
        ['text' => 'Fornecedor', 'url' => '/fornecedor', 'active' => false],
        ['text' => 'Novo', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection
@section('content')
    <div class="container-fluid">

    </div>
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Inserir novo registro</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <!-- Conteúdo -->
                <form method="POST" action="#">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-lg-3 col-md-3 col-sm-6 grupoCpf lgpd">
                                    <label for="cpf_cnpj">CPF/CPNJ* <small>(somente números)</small></label>
                                    <input class="form-control" id="cpf_cnpj" name="cpf_cnpj" maxlength="20" value=""
                                        type="text" placeholder="">
                                </div>

                                <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                                    <label for="nome">Nome*</label>
                                    <input class="form-control " id="nome" name="nome" maxlength="100"
                                        value="" type="text" placeholder="" required="required">
                                </div>

                                <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                                    <label for="email">E-mail</label>
                                    <input class="form-control " id="email" name="email" maxlength="100"
                                        value="" type="text" placeholder="">
                                </div>

                                <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                                    <label for="sitio">Site</label>
                                    <input class="form-control " id="sitio" name="sitio" maxlength="100"
                                        value="" type="text" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 lgpd">
                        <div class="card-header">
                            <h5 class="mb-0">Localização</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="mb-3 col-lg-3 col-md-3 col-sm-12">
                                    <label for="cep">CEP*</label>
                                    <input class="form-control cep" id="cep" name="cep" maxlength="20"
                                        value="" type="text" placeholder="">
                                </div>

                                <div class="mb-3 col-lg-9 col-md-9 col-sm-12">
                                    <label for="endereco">Logradouro (Rua/Av/Beco)</label>
                                    <input class="form-control " id="endereco" name="endereco" maxlength="255"
                                        value="" type="text" placeholder="">
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-3 col-md-3 col-sm-6">
                                        <label for="numero">Número</label>
                                        <input class="form-control " id="numero" name="numero" maxlength="20"
                                            value="" type="text" placeholder="">
                                    </div>

                                    <div class="mb-3 col-lg-3 col-md-3 col-sm-6">
                                        <label for="complemento">Complemento</label>
                                        <input class="form-control " id="complemento" name="complemento" maxlength="255"
                                            value="" type="text" placeholder="">
                                    </div>

                                    <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                                        <label for="bairro">Bairro</label>
                                        <input class="form-control " id="bairro" name="bairro" maxlength="255"
                                            value="" type="text" placeholder="">
                                    </div>

                                    <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                                        <label for="cidade">Cidade</label>
                                        <input class="form-control " id="cidade" name="cidade" maxlength="255"
                                            value="" type="text" placeholder="">
                                    </div>

                                    <div class="mb-3 col-6">
                                        <label for="estado">Estado</label>
                                        <select class="form-control select2" data-bs-toggle="select2" name="estado"
                                            id="estado">
                                            <option value="" disabled selected>Nenhum</option>
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
                                    </div>

                                    <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                                        <label for="pais">Pais*</label>
                                        <input class="form-control " id="pais" name="pais" maxlength="20"
                                            value="" type="text" placeholder="">
                                    </div>

                                    <div class="mb-3 col-lg-3 col-md-3 col-sm-6">
                                        <label for="telefone">Telefone</label>
                                        <input class="form-control telefone" id="telefone" name="telefone"
                                            maxlength="20" value="" type="text" placeholder="">
                                    </div>
                                    <div class="mb-3 col-lg-3 col-md-3 col-sm-6">
                                        <label for="celular">Celular*</label>
                                        <input class="form-control celular" id="celular" name="celular" maxlength="20"
                                            value="" type="text" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button class="btn btn-success mb-3" type="submit" id="btnSalvar"><i class="far fa-save"></i>Salvar</button>
                    </div>
                </form>
                <!-- Fim Conteúdo -->
            </div>
        </div>
    </div>
@endsection
