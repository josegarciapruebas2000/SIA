<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Verificar si el usuario está activo
            if ($user->status) {
                $request->session()->put('user', $user);
                return redirect()->intended('/dashboard');
            } else {
                // Si el usuario está deshabilitado, redirigir de vuelta con un mensaje de error
                return redirect()->back()->withErrors(['auth' => 'Tu cuenta ha sido deshabilitada.'])->withInput($request->only('email'));
            }
        } else {
            return redirect()->back()->withErrors(['auth' => 'Credenciales incorrectas.'])->withInput($request->only('email'));
        }
    }

    public function showLoginForm()
    {
        $error = session('error');
        return view('login')->with('error', $error);
    }
}
