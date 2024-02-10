<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('auth/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('auth/css/login.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>


    <div class="form-signin text-center">
        @include('extras.alerts')
        <img src="{{ asset('auth/images/login.png') }}" alt="Logotipo" class="logo">
        <h4 class="mb-4">Autenticação</h4>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="nome@exemplo.com">
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Senha">
                <label for="floatingPassword">Senha</label>
                <i class="fas fa-eye password-icon" onclick="togglePasswordVisibility()" id="togglePasswordIcon"></i>
            </div>

            <div class="mb-3">
                <a href="/esqueci-senha">Esqueci a senha</a>
            </div>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Lembrar de mim
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" id="loginButton">
                Entrar
            </button>

            <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
        </form>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <link href="{{ asset('auth/js/bootstrap.bundle.min.js') }}" rel="stylesheet">
    <script>
        function togglePasswordVisibility() {
            let passwordInput = document.getElementById('floatingPassword');
            let passwordIcon = document.getElementById('togglePasswordIcon');
            let isPasswordVisible = passwordInput.getAttribute('type') === 'password';

            if (isPasswordVisible) {
                passwordInput.setAttribute('type', 'text');
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.setAttribute('type', 'password');
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
        document.querySelector('form').addEventListener('submit', function() {
            const loginButton = document.getElementById('loginButton');
            loginButton.innerHTML = 'Carregando... <i class="fas fa-spinner fa-spin"></i>';
            loginButton.disabled = true;
        });
    </script>

</body>

</html>