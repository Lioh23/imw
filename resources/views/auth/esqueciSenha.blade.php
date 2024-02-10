<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('auth/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('auth/css/login.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- ALERT TOASTR -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="form-signin text-center">
        <img src="{{ asset('auth/images/login.png') }}" alt="Logotipo" class="logo">
        <h4 class="mb-4">Lembrar Senha</h4>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="nome@exemplo.com" required>
                <label for="floatingInput">Email</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" id="resetPasswordButton">
                Enviar Link de Redefinição de Senha
            </button>
            <div class="mt-3">
                <a href="/login">Voltar ao login</a>
            </div>
        </form>

    </div>
    <!-- Bootstrap Bundle with Popper -->
    <link href="{{ asset('auth/js/bootstrap.bundle.min.js') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>