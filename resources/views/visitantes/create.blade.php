@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Visitantes', 'url' => '/visitantes/', 'active' => true]
]"></x-breadcrumb>
@endsection
@section('content')
<div id="tableHover" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Novo Visitante</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <form class="form-vertical" action="#">
                <div class="row">
                    <div class="form-group mb-4 col-12">
                        <label class="control-label">Nome:</label>
                        <input type="text" name="nome" class="form-control" required minlength="4">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Sexo:</label>
                        <select name="sexo" class="form-control" required>
                            <option value="" selected>Selecione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Data de Nascimento:</label>
                        <input id="dataNascimento" name="dataNascimento" type="text" class="form-control" placeholder="ex: 31/12/2000" required>
                    </div>
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Data de Conversão:</label>
                        <input id="dataConversao" name="dataConversao" type="text" class="form-control" placeholder="ex: 31/12/2000">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Telefone Preferencial:</label>
                        <input id="telefonePreferencial" name="telefonePreferencial" type="text" class="form-control" placeholder="ex: (00) 0000-0000">
                    </div>
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Telefone Alternativo:</label>
                        <input id="telefoneAlternativo" name="telefoneAlternativo" type="text" class="form-control" placeholder="ex: (00) 0000-0000">
                    </div>
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Whatsapp:</label>
                        <input id="whatsapp" name="whatsapp" type="text" class="form-control" placeholder="ex: (00) 00000-0000">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-4 col-md-6">
                        <label class="control-label">E-mail Preferencial:</label>
                        <input id="emailPreferencial" name="emailPreferencial" type="email" class="form-control">
                    </div>
                    <div class="form-group mb-4 col-md-6">
                        <label class="control-label">E-mail Alternativo:</label>
                        <input id="emailAlternativo" name="emailAlternativo" type="email" class="form-control">
                    </div>
                </div>
                <input type="submit" value="Salvar" class="btn btn-primary ml-3 mt-3">
            </form>
        </div>
    </div>
</div>
@endsection
@section('extras-scripts')
<script>
    $(document).ready(function() {
    // Aplica máscara de data
    $('#dataNascimento, #dataConversao').mask('00/00/0000');
    $('#telefonePreferencial, #telefoneAlternativo, #whatsapp').mask('(00) 00000-0000');
    });
</script>
@endsection