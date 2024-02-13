@extends('template.layout')
@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Home', 'url' => '/', 'active' => false],
    ['text' => 'Visitantes', 'url' => '/visitantes/', 'active' => true]
]"></x-breadcrumb>
@endsection
@section('content')
<div class="container-fluid">

</div>
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
                        <input type="text" name="nome" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Sexo:</label>
                        <select name="sexo" class="form-control">
                            <option value="" selected>Selecione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Data de Nascimento:</label>
                        <input id="dataNascimento" name="dataNascimento" type="text" class="form-control" placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group mb-4 col-md-4">
                        <label class="control-label">Data de Conversão:</label>
                        <input id="dataConversao" name="dataConversao" type="text" class="form-control" placeholder="dd/mm/yyyy">
                    </div>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary ml-3 mt-3">
            </form>

        </div>
    </div>
</div>
@endsection
@section('extras-scripts')
<script>
    $(document).ready(function(){
        $('#dataConversao').mask('00/00/0000');
    });
</script>

@endsection