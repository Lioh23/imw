@extends('template.layout')
@section('extras-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Segurança', 'url' => '/', 'active' => false],
        ['text' => 'Usuarios', 'url' => '/usuarios/', 'active' => false],
        ['text' => 'Incluir', 'url' => '/usuarios/novo', 'active' => true],
    ]">
    </x-breadcrumb>
@endsection
@include('extras.alerts')
@section('content')
    <div id="tableHover" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Incluir Usuário</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form autocomplete="off" class="form-horizontal" method="POST" id="formCreatePaciente"
                    action="{{ route('usuarios.store') }}">
                    @csrf
                    <div class="row mb-1">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>* E-mail</label>
                                <div class="input-group">
                                    <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" autocomplete="off"
                                    value="{{ old('email') }}" />
                                    <input type="hidden" name="email_hidden" id="email_hidden" value="{{ old('email') }}" />
                                    <button type="button" id="checkEmailButton" class="btn btn-secondary">
                                        <i class="fa fa-search"></i> Analisar
                                    </button>
                                </div>
                                @error('email')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6" id="col-nome">
                            <div class="form-group">
                                <label>* Nome Completo</label>
                                <div class="controls">
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" minlength="8"
                                        autocomplete="off" value="{{ old('name') }}" disabled>
                                    @error('name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" id="col-perfil">
                            <div class="form-group">
                                <label>* Perfil de Acesso</label>
                                <select class="form-control @error('perfil_id') is-invalid @enderror" name="perfil_id"
                                    disabled>
                                    <option value="">Selecione um perfil</option>
                                    @foreach ($perfis as $perfil)
                                        <option value="{{ $perfil->id }}">{{ $perfil->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @error('perfil_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror

                        <div class="col-lg-4" id="col-senha" hidden>
                            <div class="form-group">
                                <label>* Senha</label>
                                <div class="controls">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="new-password" />
                                    @error('password')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="col-confirmar-senha" hidden>
                                <label>* Confirmar Senha</label>
                                <div class="controls">
                                    <input type="password" name="password_confirmation" id="confirmPassword"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        autocomplete="new-password" />
                                    @error('password_confirmation')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 d-flex align-items-center">
                            <div class="password-strength-meter-container text-center">
                                <div id="password-strength-meter" class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0;"></div>
                                </div>
                                <div id="password-strength-text"></div>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="tipo" id="tipo" hidden />
                    <br><br>
                    <button type="button" id="btn-reset" class="btn btn-secondary btn-rounded mr-2">Resetar</button>
                    <button type="submit" id="btn-salvar" disabled class="btn btn-primary btn-rounded">Salvar</button>
                </form>
                <!-- Modal de carregamento -->
                <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Carregando...</span>
                                </div>
                                <p class="mt-2">Aguarde...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extras-scripts')
    <script>
        $(document).ready(function() {
            $('#email').on('input', function() {
                $('#email_hidden').val($(this).val());
            });

            $('#btn-reset').on('click', function() {
                // Habilitar o campo de e-mail e limpar seu valor
                $('#email').prop('disabled', false).val('');
                $('#name').val('').prop('disabled', true);
                // Limpar o valor dos outros campos e redefinir o estado
                $('#email_hidden').val('');
                $('[name="perfil_id"]').val('').prop('disabled', true);
                $('#password').val('').prop('hidden', true);
                $('#confirmPassword').val('').prop('hidden', true);
                $('#col-senha').prop('hidden', true);
                $('#col-confirmar-senha').prop('hidden', true);
                // Desabilitar o botão "Salvar"
                $('#btn-salvar').text('Salvar').prop('disabled', true);
                $('#tipo').val('');
            });

            function toggleSaveButton() {
                var email = $('#email').val();
                var name = $('#name').val();
                var perfil = $('[name="perfil_id"]').val();
                if (email && name && perfil) {
                    $('#btn-salvar').prop('disabled', false);
                } else {
                    $('#btn-salvar').prop('disabled', true);
                }
            }

            function enableAllFields() {
                $('#name').prop('disabled', false);
                $('[name="perfil_id"]').prop('disabled', false);
                $('#password').prop('hidden', false);
                $('#confirmPassword').prop('hidden', false);
            }

            function validateEmail(email) {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            }

            function analyzeEmail() {
                var email = $('#email').val();
                if (email) {
                    // Exibir o modal de carregamento
                    $('#loadingModal').modal({
                        backdrop: 'static', // Impedir que o modal seja fechado clicando fora dele
                        keyboard: false // Impedir que o modal seja fechado pressionando a tecla 'Esc'
                    });
                    $.ajax({
                        url: '{{ route('usuarios.checkEmail') }}',
                        type: 'GET',
                        data: {
                            email: email
                        },
                        success: function(response) {
                            $('#loadingModal').modal('hide');
                            $('#email').prop('disabled', true);
                            if (response.exists) {
                                $('#tipo').val('vinculo');
                                $('#name').val(response.user.name).prop('disabled', true);
                                $('#password').prop('hidden', true);
                                $('#confirmPassword').prop('hidden', true);
                                $('#col-nome').prop('hidden', true);
                                $('#col-senha').prop('hidden', true);
                                $('#col-confirmar-senha').prop('hidden', true);
                                $('#btn-salvar').text('Vincular Usuário').prop('disabled', false);
                            } else {
                                $('#tipo').val('cadastro');
                                $('#name').val('').prop('disabled', false);
                                $('#password').prop('hidden', false);
                                $('#confirmPassword').prop('hidden', false);
                                $('#col-nome').prop('hidden', false);
                                $('#col-senha').prop('hidden', false);
                                $('#col-confirmar-senha').prop('hidden', false);
                                $('#btn-salvar').text('Salvar');
                                toggleSaveButton();
                                $('#email').prop('disabled', true);
                            }
                            $('[name="perfil_id"]').prop('disabled', false);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            $('#loadingModal').modal('hide');
                        }
                    });
                }
            }


            $('#checkEmailButton').on('click', function() {
                var email = $('#email').val();
                // Verificar se o email possui pelo menos 4 caracteres e está no padrão de email
                if (email.length >= 4 && validateEmail(email)) {
                    analyzeEmail();
                    enableAllFields();
                    $('#email').prop('disabled', true);
                } else {
                    // Exibir mensagem de erro ou tomar outra ação apropriada
                    alert('Formato de e-mail inválido.');
                }
            });

            $('#name').on('input', function() {
                toggleSaveButton();
            });

            $('[name="perfil_id"]').on('change', function() {
                toggleSaveButton();
            });
        });
    </script>
@endsection
