@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Clerigos', 'url' => '#', 'active' => false],
        ['text' => 'Aniversariantes', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }

        .toggle-icon {
            cursor: pointer;
            margin-right: 5px;
        }

        .child-row {
            display: none;
            /* Filhos ficam escondidos inicialmente */
        }
    </style>
@endsection

@section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-icon').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    let target = this.dataset.target;
                    let rows = document.querySelectorAll(`.child-row[data-parent="${target}"]`);

                    let isHidden = rows[0].style.display === 'none' || rows[0].style.display === '';

                    rows.forEach(row => {
                        row.style.display = isHidden ? 'table-row' : 'none';
                    });

                    if (isHidden) {
                        this.classList.remove('fa-plus-square');
                        this.classList.add('fa-minus-square');
                    } else {
                        this.classList.remove('fa-minus-square');
                        this.classList.add('fa-plus-square');
                    }
                });
            });
            document.getElementById('filter_form').addEventListener('submit', function(event) {
                let visao = parseInt(document.getElementById('visao').value);

                if (!visao) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro na seleção do tipo de visão',
                        text: 'Erro na seleção do tipo de visão!',
                        confirmButtonText: 'Entendi',
                    });
                }
            });
        });
    </script>
@endsection

@include('extras.alerts')

@section('content')
    <form class="form-vertical" id="filter_form" method="GET">
        <div class="form-group row mb-4">
            <div class="col-lg-2 text-right">
                <label class="control-label"></label>
            </div>
            <div class="col-lg-3">
                <select class="form-control" id="buscar" name="buscar" required>
                    <option value="todos" {{ request()->input('buscar') == 'buscar' ? 'selected' : '' }}>
                        Todos 
                    </option>
                </select>
            </div>
            <div class="col-lg-7">
            </div>
            <div class="col-lg-2 text-right">
                <label class="control-label"></label>
            </div>
            <!-- <div class="col-lg-6 mt-4">
                <div class="form-check form-check-inline">
                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                        <input {{ request()->get('situacao') == '' ? 'checked' : 'checked' }}
                                type="radio" name="situacao" value="" class="new-control-input">
                        <span class="new-control-indicator"></span>Todos
                        </label>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-info">
                        <input {{ request()->get('situacao') == '1' ? 'checked' : '' }}
                                type="radio" name="situacao" value="1" class="new-control-input">
                        <span class="new-control-indicator"></span>Titular
                        </label>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <div class="n-chk">
                        <label class="new-control new-checkbox checkbox-outline-success">
                        <input {{ request()->get('ativo') == 1 ? 'checked' : '' }} type="checkbox" name="ativo" value="1" class="new-control-input">
                        <span class="new-control-indicator"></span>Ativos
                        </label>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="form-group row mb-4">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <button id="btn_buscar" type="submit" class="btn btn-primary">
                    <x-bx-search /> Buscar
                </button>
            </div>
        </div>
    </form>
    @if (request()->has('buscar'))
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Clérigos Aniversarintes</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive mt-4">




                    <table class="table table-bordered table-striped table-hover mb-4 display nowrap" id="aniversariantes">
                    <thead>
                            <tr>
                                <th>NOME</th>
                                <th>ANIVERSÁRIO</th>
                                <th>NASCIMENTO</th>
                                <th>IDADE</th>
                                <th>TELEFONE</th>
                                <th>ONDE CONGREGA</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>






                        <!-- <table class="table table-striped" style="font-size: 90%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Distrito</th>
                                    <th>Igreja</th>
                                    <th>Função Ministerial</th>
                                    <th>Data Início</th>
                                    <th>Data Termino</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lancamentos as $lancamento)
                                    <tr>
                                        <td colspan="6">
                                            <i class="fas fa-plus-square toggle-icon"
                                                data-target="pai-{{ $lancamento[0]->id }}"></i>
                                            {{ $lancamento[0]->nome }}
                                        </td>
                                    </tr>
                                    @foreach ($lancamento as $nomeacao)
                                        <tr class="child-row" data-parent="pai-{{ $nomeacao->id }}">
                                            <td>{{ $nomeacao->nome }}</td>
                                            <td>{{ $nomeacao->distrito }}</td>
                                            <td>{{ $nomeacao->igreja }}</td>
                                            <td>{{ $nomeacao->funcao_ministerial }}</td>
                                            <td>{{ \Carbon\Carbon::parse($nomeacao->inicio_nomeacao)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ $nomeacao->fim_nomeacao ? \Carbon\Carbon::parse($nomeacao->fim_nomeacao)->format('d/m/Y') : 'Atual' }}
                                        </tr>
                                    @endforeach
                                @endforeach


                            </tbody>
                        </table> -->
                    </div>

                    <p class="text-center text-muted">Nenhum resultado encontrado para o período selecionado.</p>

                </div>
        @endif
    </div>
    </div>
@endsection
