@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Home', 'url' => '/', 'active' => false],
        ['text' => 'Relatórios - Financeiro', 'url' => '#', 'active' => false],
        ['text' => 'Livro Grade', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection

@section('extras-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .editing {
            border: 1px solid #ccc;
            /* Adiciona uma borda cinza suave */
            background-color: #fff;
            /* Define o fundo como branco */
            border-radius: 4px;
            /* Adiciona cantos arredondados */
            padding: 4px 8px;
            /* Adiciona um espaçamento interno */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Adiciona uma sombra suave */
            transition: border-color 0.3s, background-color 0.3s;
            /* Adiciona uma transição suave */
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
                        <div id="loadingIndicator" class="d-none text-center" style="font-size: 3em;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 table-responsive">
                        <!-- Alerta de dados não encontrados -->
                        <div id="noDataAlert" class="alert alert-danger d-none" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16">
                                <path
                                    d="M0 14.42l.719-1.24L7.998 1.58l7.283 11.58.719 1.24H0zm8-1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-.002-3a1 1 0 1 0-.001-2 1 1 0 0 0 0 2z" />
                            </svg> Nenhum dado encontrado.
                        </div>

                        <!-- Alerta de erro -->
                        <div id="errorAlert" class="alert alert-danger d-none" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16">
                                <path
                                    d="M0 14.42l.719-1.24L7.998 1.58l7.283 11.58.719 1.24H0zm8-1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-.002-3a1 1 0 1 0-.001-2 1 1 0 0 0 0 2z" />
                            </svg> Ocorreu um erro ao carregar os dados. Por favor, tente novamente mais tarde.
                        </div>

                        <table id="livrograde" class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="50px">ROL</th>
                                    <th width="450px">DIZIMISTA</th>
                                    <th width="100px">JAN</th>
                                    <th width="100px">FEV</th>
                                    <th width="100px">MAR</th>
                                    <th width="100px">ABR</th>
                                    <th width="100px">MAI</th>
                                    <th width="100px">JUN</th>
                                    <th width="100px">JUL</th>
                                    <th width="100px">AGO</th>
                                    <th width="100px">SET</th>
                                    <th width="100px">OUT</th>
                                    <th width="100px">NOV</th>
                                    <th width="100px">DEZ</th>
                                    <th width="100px">13º</th>
                                    <th width="50px">TOTAL</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
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

            // Adicionar evento de edição aos campos editáveis
            $('#livrograde tbody').on('focus', 'td[contenteditable="true"]', function() {
                var $this = $(this);
                // Aplica a máscara de R$
                $this.inputmask('currency', {
                    'alias': 'numeric',
                    'groupSeparator': '.',
                    'radixPoint': ',',
                    'autoGroup': true,
                    'digits': 2,
                    'digitsOptional': false,
                    'placeholder': '0'
                });
                $(this).addClass('editing');
                // Define uma largura fixa para a célula
                $this.css('width', $this.width() + 'px');
                // Define o alinhamento à esquerda
                $this.css('text-align', 'left');
                // Adiciona a classe 'active' à linha pai (tr) da célula em edição
                $(this).closest('tr').addClass('active');
            });


            // Remover classe CSS temporária ao terminar de editar o campo
            $('#livrograde tbody').on('blur', 'td[contenteditable="true"]', function() {
                var $this = $(this);
                $this.inputmask('remove');
                $this.removeClass('editing');
                // Verifica se o campo está vazio e define como "0,00" se estiver
                if ($this.text().trim() === '') {
                    $this.text('0,00');
                }
                // Remove a classe 'active' da linha pai (tr) da célula ao perder o foco
                $this.closest('tr').removeClass('active');

                // Atualizar o valor total da linha após editar
                updateRowTotal($this.closest('tr'));
            });
        });


        function fetchData(year) {
            // Exibir indicador de carregamento
            $('#livrograde').addClass('d-none');
            $('#loadingIndicator').removeClass('d-none');
            $('#errorAlert').addClass('d-none');

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('financeiro.livrogradepost') }}",
                method: 'POST',
                data: {
                    ano: year
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#livrograde').removeClass('d-none');
                    $('#noDataAlert').addClass('d-none');
                    $('#livrograde tbody').empty();

                    response.forEach(function(row) {
                        var newRow = '<tr id="' + row.id + '">';
                        newRow += '<td>' + row.rol_atual + '</td>';
                        newRow += '<td>' + row.nome + '</td>';
                        newRow += '<td contenteditable="true">' + row.jan + '</td>';
                        newRow += '<td contenteditable="true">' + row.fev + '</td>';
                        newRow += '<td contenteditable="true">' + row.mar + '</td>';
                        newRow += '<td contenteditable="true">' + row.abr + '</td>';
                        newRow += '<td contenteditable="true">' + row.mai + '</td>';
                        newRow += '<td contenteditable="true">' + row.jun + '</td>';
                        newRow += '<td contenteditable="true">' + row.jul + '</td>';
                        newRow += '<td contenteditable="true">' + row.ago + '</td>';
                        newRow += '<td contenteditable="true">' + row.set + '</td>';
                        newRow += '<td contenteditable="true">' + row.out + '</td>';
                        newRow += '<td contenteditable="true">' + row.nov + '</td>';
                        newRow += '<td contenteditable="true">' + row.dez + '</td>';
                        newRow += '<td contenteditable="true">' + row.o13 + '</td>';
                        newRow += '<td class="total-column">' + row.valor_total + '</td>';
                        newRow += '</tr>';

                        $('#livrograde tbody').append(newRow);
                    });

                    $('#loadingIndicator').addClass('d-none');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#errorAlert').html(
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M0 14.42l.719-1.24L7.998 1.58l7.283 11.58.719 1.24H0zm8-1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-.002-3a1 1 0 1 0-.001-2 1 1 0 0 0 0 2z"/></svg>Ocorreu um erro ao carregar os dados. Por favor, tente novamente mais tarde.'
                    );
                    $('#errorAlert').removeClass('d-none');

                    $('#loadingIndicator').addClass('d-none');
                }
            });
        }

        // Função para atualizar o valor total da linha após a edição
        function updateRowTotal($row) {
            var total = 0;
            $row.find('td[contenteditable="true"]').each(function() {
                var value = parseFloat($(this).text().replace(',', '.')) || 0;
                total += value;
            });

            console.log(total);
            $row.find('.total-column').text(total.toFixed(2));

            // Atualizar o valor total no servidor
            var memberId = $row.attr('id');
            var valorTotal = total.toFixed(2);
        }
    </script>
@endsection

