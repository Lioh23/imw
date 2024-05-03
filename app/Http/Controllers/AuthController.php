<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        session()->flash('error', 'E-mail ou senha inválida!');
        return redirect()->back();
    }

    public function showResetRequestForm() {
        return view('auth.esqueciSenha');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function submitResetRequest(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Verifica o status da solicitação de redefinição de senha
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]);
        } else {
            // Se não for bem-sucedido, passe uma mensagem de erro para a visão
            return back()->withErrors(['email' => __($status)]);
        }
    }



    public function reset(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required|string',
        ]);
    
        // Lógica para redefinir a senha do usuário
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
    
        // Verificar o status da redefinição de senha
        if ($status === Password::PASSWORD_RESET) {
            return back()->with('status', 'Senha redefinida com sucesso!');
        } else {
            return back()->withErrors(['email' => 'Não foi possível redefinir a senha. Token expirado!']);
        }
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        return view('auth.reset')->with(compact('token', 'email'));
    }
    
}
