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
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }
        .widget-content{
            color: #333;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
        }
        .foto{
            position: absolute; top:171px; margin-left: 635px;
            width: 210px;
            height: 268px;
        }
        .rol{
            position: absolute; top:555px; margin-left: 90px;
        }
        .categoria{
            position: absolute; top:555px; margin-left: 480px;
        }
        .nome{
            position: absolute; top:630px; margin-left: 90px;
        }
        .cpf{
            position: absolute; top:690px; margin-left: 90px;
        }
        .rg{
            position: absolute; top:690px; margin-left: 480px;
        }
        .dt-ordenacao{
            position: absolute; top:760px; margin-left: 90px;
        }
        .dt-nascimento{
            position: absolute; top:760px; margin-left: 480px;
        }
        .validade{
            position: absolute; top:830px; margin-left: 90px;
        }
        .sexo{
            position: absolute; top:830px; margin-left: 400px;
        }
        .estado-civil{
            position: absolute; top:830px; margin-left: 640px;
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
            <div class="widget-content widget-content-area">
                <img src="{{ $usuario->foto }}" class="foto" alt="">
                <div class="rol">{{ $usuario->rol }}</div>
                <div class="categoria">{{ isset($usuario->categoria) ? $usuario->categoria : 'Clérigo' }}</div>
                <div class="nome">{{ $usuario->nome }}</div>
                <div class="cpf">{{ $usuario->cpf }}</div>
                <div class="rg">{{ $usuario->identidade }}</div>
                <div class="dt-ordenacao">{{ $usuario->data_ordenacao }}</div>
                <div class="dt-nascimento">{{ $usuario->data_nascimento }}</div>
                <div class="validade">{{ $usuario->data_integralização }}</div>
                <div class="sexo">{{ $usuario->sexo }}</div>
                <div class="estado-civil">
                    @if($usuario->estado_civil == 'S')
                        Solteiro
                    @elseif($usuario->estado_civil == 'C')
                        Casado
                    @elseif($usuario->estado_civil == 'D')
                        Divorciado
                    @elseif($usuario->estado_civil == 'V')
                        Viúvo
                    @endif
                </div>
                <img src="{{ asset('theme/images/carteira-digital.png') }}" alt="">
            </div>
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
