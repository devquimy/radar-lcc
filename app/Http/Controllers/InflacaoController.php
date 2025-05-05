<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inflacao;
use Illuminate\Support\Facades\Auth;

class InflacaoController extends Controller
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
        $inflacoes = $this->formatarInflacoes(Inflacao::orderBy('ano', 'asc')->get());

        return view("inflacao.index",[
            'titulo_pagina' => 'Inflação',
            'inflacoes' => $inflacoes
        ]);
    }

    public function formatarInflacoes($inflacoes)
    {
        $inflacao_formatada = [];

        if(count($inflacoes) >= 1){
            foreach ($inflacoes as $key => $inflacao) {
                $inflacao_formatada[$inflacao->ano] = [
                    'id' => $inflacao->id,
                    'inflacao' => $inflacao->inflacao
                ];
            }
        }

       return $inflacao_formatada;
    }

    public function create(Request $request)
    {        
        Inflacao::truncate();

        foreach ($request->ano as $i => $ano) {
            try {
                Inflacao::create([
                    'ano' => $ano,
                    'inflacao' => $request->inflacao[$i],
                ]);
            } catch (\Throwable $th) {
                return redirect("/inflacao")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

            }
        }

        return redirect("/inflacao")->with("success", 'Inflações cadastradas com sucesso');
    }
}
