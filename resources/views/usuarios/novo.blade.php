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
                                    <input type="hidden" name="email_hidden" id="email_hidden"
                                        value="{{ old('email') }}" />
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
                        <div class="col-lg-4" id="col-perfil">
                            <div class="form-group">
                                <label>* Perfil de Acesso</label>
                                <select class="form-control @error('perfil_id') is-invalid @enderror" name="perfil_id"
                                    disabled>
                                    <option value="">Selecione um perfil</option>
                                    @foreach ($perfis as $perfil)
                                        <option value="{{ $perfil->id }}">{{ $perfil->nome }}</option>
                                    @endforeach
                                </select>
                                @error('perfil_id')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

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


                    </div>

                    <div class="row" >
                        <div class="col-lg-5" id="col-cpf" >
                            <div class="form-group">
                                <label>* CPF</label>
                                <div class="input-group">
                                    <input type="text" name="cpf" id="cpf"
                                        class="form-control @error('cpf') is-invalid @enderror" autocomplete="off"
                                        value="{{ old('cpf') }}" disabled />
                                </div>
                                @error('cpf')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-5" id="col-telefone">
                            <div class="form-group">
                                <label>* Telefone</label>
                                <div class="input-group">
                                    <input type="text" name="telefone" id="telefone"
                                        class="form-control @error('telefone') is-invalid @enderror" autocomplete="off"
                                        value="{{ old('telefone') }}" disabled />
                                </div>
                                @error('telefone')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5" id="col-senha" hidden>
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
                        <div class="col-lg-5">
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
                    </div>
            </div>
            <input type="text" name="tipo" id="tipo" hidden />
            <br><br>
            <button type="button" id="btn-reset" class="btn btn-secondary btn-rounded mr-2">Limpar</button>
            <button type="submit" id="btn-salvar" disabled class="btn btn-primary btn-rounded">Salvar</button>
            </form>

        </div>
    </div>
    </div>
@endsection

@section('extras-scripts')
    <script>
        $(document).ready(function() {
            $('#telefone').mask('(00) 00000-0000');
            $('#cpf').mask('000.000.000-00');

            $('#email').on('input', function() {
                $('#email_hidden').val($(this).val());
            });

            $('#btn-reset').on('click', function() {
                // Habilitar o campo de e-mail e limpar seu valor
                $('#email').prop('disabled', false).val('');
                $('#name').val('').prop('disabled', true);
                $('#cpf').val('').prop('disabled', true);
                $('#telefone').val('').prop('disabled', true);
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
                var cpf = $('#cpf').val();
                var telefone = $('#telefone').val();
                var perfil = $('[name="perfil_id"]').val();
                if (email && name && perfil && cpf && telefone) {
                    $('#btn-salvar').prop('disabled', false);
                } else {
                    $('#btn-salvar').prop('disabled', true);
                }
            }

            function enableAllFields() {
                $('#name').prop('disabled', false);
                $('#cpf').prop('disabled', false);
                $('#telefone').prop('disabled', false);
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
                    $.ajax({
                        url: '{{ route('usuarios.checkEmail') }}',
                        type: 'GET',
                        data: {
                            email: email
                        },
                        success: function(response) {
                            $('#email').prop('disabled', true);
                            if (response.exists) {
                                if (response.context === 'institution') {
                                    alert(
                                        'Este usuário já está vinculado a esta instituição, você pode alterar o perfil pela edição do usuário.'
                                    );
                                    $('#email').prop('disabled', false).val('');
                                    $('#name').val('').prop('disabled', true);
                                    $('#cpf').val('').prop('disabled', true);
                                    $('#telefone').val('').prop('disabled', true);
                                    $('#email_hidden').val('');
                                    $('[name="perfil_id"]').val('').prop('disabled', true);
                                    $('#password').val('').prop('hidden', true);
                                    $('#confirmPassword').val('').prop('hidden', true);
                                    $('#col-senha').prop('hidden', true);
                                    $('#col-confirmar-senha').prop('hidden', true);
                                    // Desabilitar o botão "Salvar"
                                    $('#btn-salvar').text('Salvar').prop('disabled', true);
                                    $('#tipo').val('');
                                } else if (response.context === 'general') {
                                    alert(
                                        'Este usuário já foi cadastrado no sistema. Se deseja vinculá-lo a esta instituição, selecione um perfil e clique no botão "Vincular Usuário".'
                                    );
                                    $('#tipo').val('vinculo');
                                    $('#name').val(response.user.name).prop('disabled', true);
                                    $('#cpf').prop('hidden', true);
                                    $('#telefone').prop('hidden', true);
                                    $('#password').prop('hidden', true);
                                    $('#confirmPassword').prop('hidden', true);
                                    $('#col-nome').prop('hidden', true);
                                    $('#col-cpf').prop('hidden', true);
                                    $('#col-telefone').prop('hidden', true);
                                    $('#col-senha').prop('hidden', true);
                                    $('#col-confirmar-senha').prop('hidden', true);
                                    $('#btn-salvar').text('Vincular Usuário').prop('disabled', false);
                                    $('[name="perfil_id"]').prop('disabled', false);
                                }
                            } else {
                                $('#tipo').val('cadastro');
                                $('#name').val('').prop('disabled', false);
                                $('#cpf').val('').prop('disabled', false);
                                $('#telefone').val('').prop('disabled', false);
                                $('#password').prop('hidden', false);
                                $('#confirmPassword').prop('hidden', false);
                                $('#col-nome').prop('hidden', false);
                                $('#col-cpf').prop('hidden', false);
                                $('#col-telefone').prop('hidden', false);
                                $('#col-senha').prop('hidden', false);
                                $('#col-confirmar-senha').prop('hidden', false);
                                $('#btn-salvar').text('Salvar');
                                toggleSaveButton();
                                $('#email').prop('disabled', true);
                                $('[name="perfil_id"]').prop('disabled', false);
                            }

                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
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

            $('#cpf').on('input', function() {
                toggleSaveButton();
            });

            $('#telefone').on('input', function() {
                toggleSaveButton();
            });

            $('[name="perfil_id"]').on('change', function() {
                toggleSaveButton();
            });
        });
    </script>
@endsection
