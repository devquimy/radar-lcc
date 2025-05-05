<?php

namespace App\Http\Controllers;

use App\Models\NiveisAcesso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NiveisAcessoController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::check() && Auth::user()->status == false){
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();
        
                return redirect('/login');
            }
            
            if(Auth::user()->nivel_acesso->nome != 'Master'){
                return redirect('/ativos_fisicos')->with('error', 'Erro, você não possui permissão para acessar esta tela.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $niveis_acessos = NiveisAcesso::all();

        return view("niveis_acesso.index",[
            'titulo_pagina' => 'Níveis de Acessos',
            'niveis_acessos' => $niveis_acessos
        ]);
    }
}
