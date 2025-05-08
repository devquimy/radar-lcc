<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/ativos_fisicos'); 
        }
        
        return view('login');
    }

    /**
     * Método que faz o login do usuário
     */
    public function store(Request $request): RedirectResponse
    {                
        if (Auth::check()) {
            return redirect('/ativos_fisicos'); 
        }

        $request->password = trim($request->password);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'status'  => 'ativo',
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if(Auth::user()->status == 0){
                Auth::logout();

                return redirect('/login')->with('error', 'Usuário inativo');
            }
 
            return redirect()->intended('/ativos_fisicos');
        }
 
        return back()->withErrors([
            'email' => 'E-mail ou senha inválidos',
        ])->onlyInput('email');
    }

    /**
     * Método que faz o logout do usuario
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
