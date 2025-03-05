@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Estatísticas', 'url' => '#', 'active' => false],
        ['text' => 'Estatística Total de Membresia', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
<link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
<style>
    .toggle-icon {
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }
    .collapsed .toggle-icon {
        transform: rotate(180deg);
    }
    .hidden-row {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <h4>Estatística Total de Membresia</h4>
        </div>
        <div class="widget-content widget-content-area">
            <form class="form" id="filter_form" method="GET">
                <div class="form-group row mb-4">
                    <div class="col-lg-3 d-flex align-items-center">
                        <select class="form-control" name="checkIgreja" id="checkIgreja">
                            <option value="distrito" {{ request()->input('checkIgreja') == 'distrito' ? 'selected' : '' }}>Somente Distritos</option>
                            <option value="igreja" {{ request()->input('checkIgreja') == 'igreja' ? 'selected' : '' }}>Exibir Igrejas</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <button id="btn_buscar" type="submit" class="btn btn-primary">
                            <x-bx-search /> Buscar
                        </button>
                    </div>
                </div>
            </form>

            @if (!empty($dados))
            <div class="table-responsive mt-4">
                <table class="table table-striped" style="font-size: 90%;">
                    <thead class="thead-dark">
                        <tr>
                            <th style="text-align: left;">Nome</th>
                            <th style="text-align: right;">Total de Membros</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $ultimoDistrito = null; @endphp

                        @foreach ($dados as $dado)
                            @if ($tipo == 'igreja')
                                @if ($ultimoDistrito !== $dado->distrito_id)
                                    <tr class="distrito-row" data-distrito="{{ $dado->distrito_id }}">
                                        <td>
                                            <span class="toggle-icon" onclick="toggleDistrito({{ $dado->distrito_id }})">▼</span>
                                            <strong>{{ $dado->distrito_nome }}</strong>
                                        </td>
                                        <td style="text-align: right;"><strong>{{ $dados->where('distrito_id', $dado->distrito_id)->sum('total_membros') }}</strong></td>
                                    </tr>
                                    @php $ultimoDistrito = $dado->distrito_id; @endphp
                                @endif
                                <tr class="igreja-row hidden-row" data-parent="{{ $dado->distrito_id }}">
                                    <td style="padding-left: 30px;">- {{ $dado->igreja_nome }}</td>
                                    <td style="text-align: right;">{{ $dado->total_membros }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $dado->distrito_nome }}</td>
                                    <td style="text-align: right;">{{ $dado->total_membros }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: left;">Total Geral</th>
                            <th style="text-align: right;">{{ $totalGeral }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@section('extras-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleDistrito(distritoId) {
        let distritoRow = $(`.distrito-row[data-distrito="${distritoId}"]`);
        let igrejaRows = $(`.igreja-row[data-parent="${distritoId}"]`);

        igrejaRows.toggleClass('hidden-row');
        distritoRow.toggleClass('collapsed');
    }
</script>
@endsection
@endsection
