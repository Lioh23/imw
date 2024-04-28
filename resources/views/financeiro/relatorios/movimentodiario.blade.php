@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Relatórios - Financeiro', 'url' => '#', 'active' => false],
        ['text' => 'Movimento Diário', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
@endsection

@include('extras.alerts')

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Relatório Movimento Diário</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="form-vertical" id="filter_form" method="GET">
                    <div class="form-group row mb-4" id="filtros_data">
                        <div class="col-lg-2 text-right">
                            <label class="control-label">* Período (Inicial e Final):</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="date" class="form-control @error('dt_inicial') is-invalid @enderror"
                                id="dt_inicial" name="dt_inicial" value="{{ request()->input('dt_inicial') }}" required
                                placeholder="ex: 31/12/2000">
                        </div>
                        <div class="col-lg-3">
                            <input type="date" class="form-control @error('dt_final') is-invalid @enderror"
                                id="dt_final" name="dt_final" value="{{ request()->input('dt_final') }}"
                                placeholder="ex: 31/12/2000" required>
                        </div>
                    </div>

                    {{-- Congregação --}}
                    <div class="form-group row mb-4">
                        <div class="col-lg-2 text-right">
                            <label class="control-label">Caixa:</label>
                        </div>
                        <div class="col-lg-6">
                            <select id="caixa_id" name="caixa_id"
                                class="form-control @error('caixa_id') is-invalid @enderror">
                                <option value="all" {{ request()->input('caixa_id') == '99' ? 'selected' : '' }}>Todos
                                </option>
                                @foreach ($caixas as $caixa)
                                    <option value="{{ $caixa->id }}"
                                        {{ request()->input('caixa_id') == $caixa->id ? 'selected' : '' }}>
                                        {{ $caixa->descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-6">
                            <button id="btn_buscar" type="submit" name="action" value="buscar"
                                title="Buscar dados do Relatório" class="btn btn-primary btn">
                                <x-bx-search /> Buscar
                            </button>
                            {{--  <button id="btn_relatorio" type="submit" name="action" value="relatorio" title="Gerar Relatório PDF" class="btn btn-secondary btn ml-4">
                            <x-bx-file /> Relatório
                          </button> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TABELA -->
    @if (!empty(request()->input('dt_inicial')))
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4 style="text-transform: uppercase">Movimento Financeiro -
                            {{ session()->get('session_perfil')->instituicoes->igrejaLocal->nome }}</h4>
                        <p class="pl-3">Período de {{ \Carbon\Carbon::parse(request()->input('dt_inicial'))->format('d/m/Y') }} a {{ \Carbon\Carbon::parse(request()->input('dt_final'))->format('d/m/Y') }}
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th>DATA</th>
                                <th>CAIXA</th>
                                <th>PLANO DE CONTA</th>
                                <th>ENTRADA</th>
                                <th>SAÍDA</th>
                                <th>PAGANTE</th>
                                <th>BENEFICIÁRIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lancamentosPorCaixa as $caixaDescricao => $lancamentos)
                                @php $groupedLancamentos = $lancamentos->groupBy('data_movimento'); @endphp
                                @foreach ($groupedLancamentos as $dataMovimento => $lancamentosData)
                                    <tr>
                                        <td rowspan="{{ count($lancamentosData) }}"><b>{{ \Carbon\Carbon::parse($dataMovimento)->format('d/m/Y') }}</b></td>
                                        <td rowspan="{{ count($lancamentosData) }}"><b>{{ $caixaDescricao }}</b></td>
                                        @foreach ($lancamentosData as $index => $lancamento)
                                            @if ($index !== 0)
                                                <tr>
                                            @endif
                                            <td>{{ $lancamento->planoConta->numeracao }} - {{ $lancamento->planoConta->nome }}</td>
                                            <td style="{{ $lancamento->tipo_lancamento === 'E' ? 'color: green;' : 'color: red;' }}">
                                                {{ $lancamento->tipo_lancamento === 'E' ? 'R$ ' . number_format($lancamento->valor, 2, ',', '.') : '-' }}
                                            </td>
                                            <td style="{{ $lancamento->tipo_lancamento === 'S' ? 'color: red;' : 'color: green;' }}">
                                                {{ $lancamento->tipo_lancamento === 'S' ? 'R$ ' . number_format($lancamento->valor, 2, ',', '.') : '-' }}
                                            </td>                                                                                        
                                            <td>{{ $lancamento->tipo_lancamento === 'E' ? $lancamento->pagante_favorecido : '-' }}</td>
                                            <td>{{ $lancamento->tipo_lancamento === 'S' ? $lancamento->pagante_favorecido : '-' }}</td>
                                            @if ($index !== 0)
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button class="btn btn-success btn-rounded" onclick="exportReportToExcel();"><i
                        class="fa fa-file-excel" aria-hidden="true"></i> Exportar</button>
            </div>
        </div>
    </div>
  @endif
  <script src="{{asset('theme/assets/js/planilha/papaparse.min.js')}}"></script>
    <script src="{{asset('theme/assets/js/planilha/FileSaver.min.js')}}"></script>
    <script src="{{asset('theme/assets/js/planilha/xlsx.full.min.js')}}"></script>
    <script src="{{asset('theme/assets/js/planilha/planilha.js')}}"></script>
    <script src="{{asset('theme/assets/js/pages/movimentocaixa.js')}}"></script>
@endsection
