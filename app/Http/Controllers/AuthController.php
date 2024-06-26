<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'usuario' => ['required', 'string'],
            'senha' => ['required', 'string'],
        ]);

        if (Auth::attempt(['username' => $credentials['usuario'], 'password' => $credentials['senha']])) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        // Se as credenciais estiverem incorretas, redirecionar de volta para o login
        // com uma mensagem de erro
        return back()->withErrors([
            'erroLogin' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->withInput($request->only('usuario'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
