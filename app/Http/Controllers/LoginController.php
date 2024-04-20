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
            $request->session()->put('user', $user);
            return redirect()->intended('/dashboard');
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
