@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Financeiro', 'url' => '/', 'active' => false],
        ['text' => 'Cota Orçamentária', 'url' => '#', 'active' => true],
    ]">
    </x-breadcrumb>
@endsection

@section('extras-css')
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/searchbuilder/1.8.2/css/searchBuilder.dataTables.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/datetime/1.5.5/css/dataTables.dateTime.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />
    <style>
        .old {
        color: red;
    }
    .middleaged {
        color: blue;
    }
    .young {
        color: green;
    }
    </style>
@endsection



@section('content')
    @include('extras.alerts')

    <div class="container-fluid">
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Cota Orçamentária - {{ $instituicao }}</h4>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="widget-content widget-content-area">
                <form class="form-vertical" id="filter_form" method="GET">
                    <div class="form-group row mb-4" id="filtros_data">
                        <div class="col-lg-2 text-right">
                            <label class="control-label">* Ano/Mês:</label>
                        </div>
                            <div class="col-lg-5 ano_mes">
                                <div class="input-group">
                                    @if(request()->input('ano'))
                                        <select class="form-control " id="ano" name="ano" required="">
                                            @php
                                                $mesAtual = date('m');
                                                $anoAtual = date('Y');
                                                $anos = range($anoAtual - 2, $anoAtual);
                                            @endphp
                                            @foreach($anos as $ano)
                                                <option value="{{ $ano }}" {{ request()->input('ano') == $ano ? 'selected' : '' }}>{{ $ano }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control " id="mes" name="mes" required="">
                                            @foreach($meses as $mes)
                                                @if($mes->id != 13)
                                                    <option value="{{ $mes->id }}" {{ request()->input('mes') == zeroEsqueda($mes->id) ? 'selected' : '' }}>{{ $mes->descricao }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control " id="ano" name="ano" required="">
                                            @php
                                                $mesAtual = date('m');
                                                $anoAtual = date('Y');
                                                $anos = range($anoAtual - 10, $anoAtual);
                                            @endphp
                                            @foreach($anos as $ano)
                                                <option value="{{ $ano }}" {{ $anoAtual == $ano ? 'selected' : '' }}>{{ $ano }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control " id="mes" name="mes" required="">
                                            @foreach($meses as $mes)
                                                @if($mes->id != 13)
                                                    <option value="{{ $mes->id }}" {{ $mesAtual == zeroEsqueda($mes->id) ? 'selected' : '' }}>{{ $mes->descricao }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        

                            
                            <button id="btn_buscar" type="submit" name="action" value="buscar" title="Buscar dados do Relatório" class="btn btn-primary btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none" viewBox="0 0 24 24"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path></svg> Buscar
                                </button>


                    </div>
                </form>
            </div>
            @if(request()->input('ano'))
                <div class="card mb-3">
                    <div class="card-body">
                        <h4>{{ $titulo }}</h4>
                        <div class="table-responsive mt-4">
                            <table id="cota-orcamentaria" class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                                @php
                                    $dizimosOfertas = $cotaOrcamentaria->dizimos_ofertas ? $cotaOrcamentaria->dizimos_ofertas : 0;
                                    $cotaOrcamentariaTotal = calculoPorcentagem($dizimosOfertas,19);
                                    $dizimosPastoralFiw = $cotaOrcamentaria->dizimos_pastoral_fiw ? $cotaOrcamentaria->dizimos_pastoral_fiw : 0;
                                    $irrfRepasse = $cotaOrcamentaria->irrf_titular ? $cotaOrcamentaria->irrf_titular : 0;
                                    $total = $cotaOrcamentariaTotal + $dizimosPastoralFiw + $irrfRepasse;
                                @endphp
                                <thead class="thead-light">
                                    <tr>
                                        <th>TIPO</th>
                                        <th>CRITÉRIO</th>
                                        <th>VALOR DA COTA LOCAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Arrecadado</td>
                                        <td>Dízimos + Ofertas de Cultos</td>
                                        <td>
                                            R$ {{ number_format($dizimosOfertas, 2,",",".") }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cota</td>
                                        <td>19%</td>
                                        <td>
                                            R$ {{ number_format($cotaOrcamentariaTotal, 2,",",".") }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dízimo Pastoral</td>
                                        <td>100%</td>
                                        <td>
                                            R$ {{ number_format($dizimosPastoralFiw, 2,",",".") }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>IRRF Titular</td>
                                        <td>100% da Tabela</td>
                                        <td>
                                            R$ {{ number_format($irrfRepasse, 2,",",".") }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>TOTAL</b></td>
                                        <td></td>
                                        <td>
                                            R$ {{ number_format($total, 2,",",".") }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
           @endif
        </div>
    </div>
    @section('extras-scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/searchbuilder/1.8.2/js/dataTables.searchBuilder.js"></script>
        <script src="https://cdn.datatables.net/searchbuilder/1.8.2/js/searchBuilder.dataTables.js"></script>
        <script src="https://cdn.datatables.net/datetime/1.5.5/js/dataTables.dateTime.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>
        <script>
            new DataTable('#cota-orcamentaria', {
                ordering: false,
                layout: {
                    //top1: 'searchBuilder',
                    topStart: {
                    buttons: [
                        'pageLength',
                        {
                        extend: 'excel',
                        className: 'btn btn-primary btn-rounded',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        titleAttr: 'Excel',
                        title: "{{ $titulo }}"
                        },
                        {
                        extend: 'pdf',
                        className: 'btn btn-primary btn-rounded',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        titleAttr: 'PDF',
                        title: "{{ $titulo }}",

                        customize: function (doc) {
                                    doc.content.splice(0,1);
                                    var now = new Date();
                                    var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                                    //doc.pageMargins = [20,50,20,30];
                                    doc.defaultStyle.fontSize = 9;
                                    doc.styles.tableHeader.fontSize = 9;

                                    const hoje = new Date();
                                    const dataFormatada = hoje.toLocaleDateString('pt-BR');
                                    const horaFormatada = hoje.toLocaleTimeString('pt-BR');
                                    const dataHoraFormatada = `${dataFormatada} ${horaFormatada}`;
                                    doc['header']=(function() {
                                        return {
                                            columns: [

                                                {
                                                    alignment: 'left',
                                                    italics: false,
                                                    text: `{{ $titulo }}`,
                                                    fontSize: 14,
                                                    margin: [10,0]
                                                },
                                                // {
                                                //     alignment: 'right',
                                                //     fontSize: 14,
                                                //     text: ``
                                                // }
                                            ],
                                            margin: [20,20,0,0]
                                        }
                                    });

                                    var numColumns = doc.content[0].table.body[0].length; 
                                    doc.content[0].table.widths = Array(numColumns).fill('*');


                                    doc['footer']=(function(page, pages) {
                                        return {
                                            columns: [
                                                {
                                                    alignment: 'left',
                                                    text: ['Criado em: ', { text: dataHoraFormatada }]
                                                },
                                                {
                                                    alignment: 'right',
                                                    text: ['Página ', { text: page.toString() },  ' de ', { text: pages.toString() }]
                                                }
                                            ],
                                            margin: 20
                                        }
                                    });

                                    var objLayout = {};
                                    objLayout['hLineWidth'] = function(i) { return .5; };
                                    objLayout['vLineWidth'] = function(i) { return .5; };
                                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                                    objLayout['paddingLeft'] = function(i) { return 4; };
                                    objLayout['paddingRight'] = function(i) { return 4; };
                                    doc.content[0].layout = objLayout;
                                },
                        }
                    ]
                    },
                    topEnd: 'search',
                    bottomStart: 'info',
                bottomEnd: 'paging'
                },
                language: {
                url:"https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                }
            });
        </script>
    @endsection
    
@endsection
