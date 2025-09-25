@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Carteira Digital', 'url' => '/usuario/perfil/carteira-digital', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

    <style>
        #content {
            width: unset;
        }
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }
        .widget-content{
            color: #333;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
        }
        .regiao_top{
            position: absolute; top:213px; margin-left: 330px; font-size: 14px; color: #4361ee;
        }
        .foto{
            position: absolute; top:169px; margin-left: 633px;
            width: 210px;
            height: 268px;
        }
        .nome{
            position: absolute; top:565px; margin-left:70px;
        }
        .rol{
            position: absolute; top:565px; margin-left: 615px;
        }
        .cpf{
            position: absolute; top:660px; margin-left: 70px;
        }
        .rg{
            position: absolute; top:660px; margin-left: 340px;
        }
        .dt-nascimento{
            position: absolute; top:660px; margin-left: 620px;
        }
        .categoria{
            position: absolute; top:757px; margin-left: 70px;
        }
        .dt-ordenacao{
            position: absolute; top:757px; margin-left:620px;
        }        
        .dt-consagracao{
            position: absolute; top:757px; margin-left: 346px;
        }
        .contato-sede{
            position: absolute; top:860px; margin-left: 280px; font-size: 20px;
        }
        .regiao_bottom{
            position: absolute; top:1030px; margin-left: 240px; font-size: 14px; color: #4361ee;
        }
        .validade{
            position: absolute; top:1070px; margin-left: 90px; font-size: 14px;
        }
    </style>
@endsection

@section('content')
    @include('extras.alerts')

    <!-- TABELA -->
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Carteira Digital</h4>
                    </div>
                </div>
            </div>
            @if($usuario['pessoa_id'])
            <div class="widget-content widget-content-area">
                <div class="regiao_top">{{ mb_convert_case($usuario->nome_regiao, MB_CASE_TITLE, "UTF-8") }} Eclesiástica</div>
                <img src="{{ $usuario->foto }}" class="foto" alt="">
                <div class="rol">{{ $usuario->rol }}</div>
                <div class="nome">{{ $usuario->nome }}</div>
                <div class="cpf">{{ $usuario->cpf }}</div>
                <div class="rg">{{ $usuario->identidade }}</div>
                <div class="dt-nascimento">{{ formatDate($usuario->data_nascimento) }}</div>
                <div class="categoria">{{ isset($usuario->categoria) ? mb_convert_case($usuario->categoria, MB_CASE_TITLE, "UTF-8") : '' }}</div>
                <div class="dt-consagracao">{{ formatDate($usuario->data_consagracao) }}</div>
                <div class="dt-ordenacao">{{ formatDate($usuario->data_ordenacao) }}</div>
                <div class="contato-sede">Sede Administrativa: (21) 98456-0937</div>
                <div class="validade">Essa credencial terá validade enquanto seu portador estiver inscrito como clérigo ativo de sua Região Eclesiástica</div>
                <div class="regiao_bottom">{{ mb_convert_case($usuario->nome_regiao, MB_CASE_TITLE, "UTF-8") }} Eclesiástica</div>
                <img src="{{ asset('theme/images/carteira-digital.png') }}" alt="">
            </div>
            @else
                <div class="widget-content widget-content-area">
                    Não possui acesso a credencial
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL DE VISUALIZAÇÃO -->
    <div class="modal fade" tabindex="-1" id="visualizarVisitantesModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content loadable">
                <div class="modal-body" style="min-height: 200px"></div>
            </div>
        </div>
    </div>
@endsection

@section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('custom/js/imw_datatables.js') }}?time={{ time() }}"></script>
    <script src="{{ asset('perfil/clerigos/prebendas/js/index.js') }}?time={{ time() }}"></script>
@endsection
