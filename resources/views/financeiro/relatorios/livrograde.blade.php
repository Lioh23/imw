@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Relatórios - Financeiro', 'url' => '#', 'active' => false],
        ['text' => 'Livro Grade', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <link href="{{ asset('theme/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .year-btn {
            width: auto;
            /* Defina a largura automática */
            position: relative;
            /* Necessário para o posicionamento absoluto do ícone */
        }

        .check-icon {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
@endsection

@include('extras.alerts')

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Relatório Livro Grade - {{ session()->get('session_perfil')->instituicoes->igrejaLocal->nome }}
                        </h4>
                    </div>
                </div>

            </div>
            <div class="widget-content widget-content-area">

                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        @php
                            $currentYear = \Carbon\Carbon::now()->year;
                        @endphp

                        @for ($i = 0; $i < 7; $i++)
                            @php
                                $year = $currentYear - $i;
                            @endphp
                            <button class="btn mb-4 mr-2 btn-lg year-btn btn-primary" data-year="{{ $year }}">
                                <span class="btn-content">{{ $year }}</span>
                                @if ($year == $currentYear)
                                    <i class="fas fa-check"></i>
                                @endif
                            </button>
                        @endfor
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div id="loadingIndicator" class="d-none text-center" style="font-size: 2em;">
                            <i class="fas fa-spinner fa-spin"></i> Carregando...
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 table-responsive">
                        <!-- Alerta de dados não encontrados -->
                        <div id="noDataAlert" class="alert alert-danger d-none" role="alert">
                            Nenhum dado encontrado.
                        </div>

                        <!-- Alerta de erro -->
                        <div id="errorAlert" class="alert alert-danger d-none" role="alert">
                            Ocorreu um erro ao carregar os dados. Por favor, tente novamente mais tarde.
                        </div>

                        <table id="livrograde" class="table table-striped d-none" style="font-size: 90%; margin-top: 15px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ROL</th>
                                    <th>DIZIMISTA</th>
                                    <th>JAN</th>
                                    <th>FEV</th>
                                    <th>MAR</th>
                                    <th>ABR</th>
                                    <th>MAI</th>
                                    <th>JUN</th>
                                    <th>JUL</th>
                                    <th>AGO</th>
                                    <th>SET</th>
                                    <th>OUT</th>
                                    <th>NOV</th>
                                    <th>DEZ</th>
                                    <th>13º</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('extras-scripts')
    <script>
        $(document).ready(function() {
            $('.year-btn').click(function() {
                $('.year-btn').removeClass('btn-success').find('i').remove();
                $(this).addClass('btn-success').append('<i class="fas fa-check"></i>');
                var year = $(this).data('year');
                fetchData(year);
            });

            // Obter o ano atual ao abrir a página
            var currentYear = new Date().getFullYear();
            fetchData(currentYear);
        });

        function fetchData(year) {
            // Exibir indicador de carregamento
            $('#loadingIndicator').removeClass('d-none');
            $('#errorAlert').addClass('d-none');

            $.ajax({
                url: "{{ route('financeiro.livrogradepost') }}",
                method: 'POST',
                data: {
                    ano: year
                }, // Corrigido para 'ano'
                success: function(response) {
                    // Verifica se há resultados na resposta
                    if (response.length > 0) {
                        // Mostra a tabela
                        $('#livrograde').removeClass('d-none');
                        // Esconde o alerta de "Nenhum dado encontrado"
                        $('#noDataAlert').addClass('d-none');

                        // Limpa os dados antigos da tabela
                        $('#livrograde tbody').empty();

                        // Preenche a tabela com os dados retornados
                        response.forEach(function(row) {
                            var newRow = '<tr>';
                            newRow += '<td>' + row.srol + '</td>';
                            newRow += '<td>' + row.dizimista + '</td>';
                            newRow += '<td>' + row.jan + '</td>';
                            newRow += '<td>' + row.fev + '</td>';
                            newRow += '<td>' + row.mar + '</td>';
                            newRow += '<td>' + row.abr + '</td>';
                            newRow += '<td>' + row.mai + '</td>';
                            newRow += '<td>' + row.jun + '</td>';
                            newRow += '<td>' + row.jul + '</td>';
                            newRow += '<td>' + row.ago + '</td>';
                            newRow += '<td>' + row.set + '</td>';
                            newRow += '<td>' + row.out + '</td>';
                            newRow += '<td>' + row.nov + '</td>';
                            newRow += '<td>' + row.dez + '</td>';
                            newRow += '<td>' + row.decimoterceiro + '</td>';
                            newRow += '<td>' + row.total + '</td>';
                            newRow += '</tr>';

                            $('#livrograde tbody').append(newRow);
                        });
                    } else {
                        // Esconde a tabela se não houver resultados
                        $('#livrograde').addClass('d-none');
                        // Mostra o alerta de "Nenhum dado encontrado"
                        $('#noDataAlert').removeClass('d-none');
                    }

                    // Ocultar indicador de carregamento
                    $('#loadingIndicator').addClass('d-none');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Adicione tratamento de erro, se necessário
                    // Exibir mensagem de erro na tela
                    $('#errorAlert').text(
                        'Ocorreu um erro ao carregar os dados. Por favor, tente novamente mais tarde.');
                    $('#errorAlert').removeClass('d-none');

                    // Ocultar indicador de carregamento
                    $('#loadingIndicator').addClass('d-none');
                }
            });
        }
    </script>
@endsection
