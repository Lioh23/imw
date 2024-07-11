@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Relatórios - Financeiro', 'url' => '#', 'active' => false],
        ['text' => 'Livro Razão', 'url' => '#', 'active' => true],
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
                        <h4>Relatório Livro Razão</h4>
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
                            <input type="date" class="form-control @error('dt_inicial') is-invalid @enderror" id="dt_inicial" name="dt_inicial" value="{{ request()->input('dt_inicial') }}" required>
                            @error('dt_inicial')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <input type="date" class="form-control @error('dt_final') is-invalid @enderror" id="dt_final" name="dt_final" value="{{ request()->input('dt_final') }}" required>
                            @error('dt_final')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-lg-2 text-right">
                            <label class="control-label">Caixa:</label>
                        </div>
                        <div class="col-lg-6">
                            <select id="caixa_id" name="caixa_id" class="form-control @error('caixa_id') is-invalid @enderror">
                                <option value="all" {{ request()->input('caixa_id') == 'all' ? 'selected' : '' }}>Todos</option>
                                @foreach ($caixas as $caixa)
                                    <option value="{{ $caixa->id }}" {{ request()->input('caixa_id') == $caixa->id ? 'selected' : '' }}>
                                        {{ $caixa->descricao }}
                                    </option>
                                @endforeach
                            </select>
                            @error('caixa_id')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-6">
                            <button id="btn_buscar" type="submit" name="action" value="buscar" title="Buscar dados do Relatório" class="btn btn-primary btn">
                                <x-bx-search /> Buscar
                            </button>
                            <button id="btn_relatorio" type="button" class="btn btn-secondary btn ml-4">
                                <i class="fa fa-file-pdf"></i> Relatório
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (!empty(request()->input('dt_inicial')))
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 style="text-transform: uppercase">Movimento Financeiro - {{ session()->get('session_perfil')->instituicoes->igrejaLocal->nome }}</h4>
                            <p class="pl-3">Período de {{ \Carbon\Carbon::parse(request()->input('dt_inicial'))->format('d/m/Y') }} a {{ \Carbon\Carbon::parse(request()->input('dt_final'))->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-4">
                            <thead>
                            <tr>
                                <th>PLANO DE CONTA</th>
                                <th>DATA</th>
                                <th>ORIGEM/DESTINO</th>
                                <th>ENTRADA</th>
                                <th>SAÍDA</th>
                                <th>PAGANTE/FAVORECIDO</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                // Combine all transactions into a single array
                                $allLancamentos = [];
                                foreach ($lancamentosPorCaixa as $caixaDescricao => $lancamentos) {
                                    foreach ($lancamentos as $lancamento) {
                                        $lancamento->caixaDescricao = $caixaDescricao; // Add caixaDescricao to each transaction
                                        $allLancamentos[] = $lancamento;
                                    }
                                }

                                // Sort all transactions by conta, data, origem/destino
                                usort($allLancamentos, function ($a, $b) {
                                    // Ordena primeiro por conta (numeracao do plano de conta)
                                    $cmp = strcmp($a->planoConta->numeracao, $b->planoConta->numeracao);
                                    if ($cmp !== 0) return $cmp;

                                    // Se as contas forem iguais, ordena por data de movimento
                                    $cmp = strcmp($a->data_movimento, $b->data_movimento);
                                    if ($cmp !== 0) return $cmp;

                                    // Se as datas forem iguais, ordena por descrição (origem/destino)
                                    $cmp = strcmp($a->descricao, $b->descricao);
                                    if ($cmp !== 0) return $cmp;

                                    // Se as descrições forem iguais, ordena por pagante_favorecido
                                    return strcmp($a->pagante_favorecido, $b->pagante_favorecido);
                                });

                                // Group transactions by date
                                $groupedLancamentos = [];
                                foreach ($allLancamentos as $lancamento) {
                                    $groupedLancamentos[$lancamento->data_movimento][] = $lancamento;
                                }
                            @endphp

                            @foreach ($groupedLancamentos as $dataMovimento => $lancamentosData)
                                <tr>
                                    <td><b>{{ $lancamentosData[0]->caixaDescricao }}</b></td>
                                    <td><b>{{ \Carbon\Carbon::parse($dataMovimento)->format('d/m/Y') }}</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($lancamentosData as $lancamento)
                                    <tr>
                                        <td>{{ $lancamento->planoConta->numeracao }} - {{ $lancamento->planoConta->nome }}</td>
                                        <td>{{ \Carbon\Carbon::parse($lancamento->data_movimento)->format('d/m/Y') }}</td>
                                        <td>{{ $lancamento->descricao }}</td>
                                        <td style="{{ $lancamento->tipo_lancamento === 'E' ? 'color: green;' : 'color: red;' }}">
                                            {{ $lancamento->tipo_lancamento === 'E' ? 'R$ ' . number_format($lancamento->valor, 2, ',', '.') : '-' }}
                                        </td>
                                        <td style="{{ $lancamento->tipo_lancamento === 'S' ? 'color: red;' : 'color: green;' }}">
                                            {{ $lancamento->tipo_lancamento === 'S' ? 'R$ ' . number_format($lancamento->valor, 2, ',', '.') : '-' }}
                                        </td>
                                        <td>{{ $lancamento->pagante_favorecido }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                <div class="col-12 text-center">
                    <button class="btn btn-success btn-rounded" onclick="exportReportToExcel();"><i class="fa fa-file-excel" aria-hidden="true"></i> Exportar</button>
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
