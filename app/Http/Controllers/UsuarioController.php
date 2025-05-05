<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empresa;
use App\Models\NiveisAcesso;
use Illuminate\Validation\Rules;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoricoTransacaoCredito;
use App\Models\CreditoUsuario;

class UsuarioController extends Controller
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
            
            if(Auth::user()->nivel_acesso->nome != 'Master' && Auth::user()->nivel_acesso->nome != 'Administrador'){
                return redirect('/ativos_fisicos')->with('error', 'Erro, você não possui permissão para acessar esta tela.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if(Auth::user()->nivel_acesso->nome  == 'Administrador'){
            $usuarios = User::where([
                ['empresa_id', Auth::user()->empresa->id]
            ])
            ->orWhere('id', Auth::user()->id)
            ->paginate(50);

        }else{
            if($request->nivel_acesso_id){
                $usuarios = User::where('nivel_acesso_id', $request->nivel_acesso_id)->paginate(10);
                
            }else{
                $usuarios = User::paginate(50);
    
            }
        }


        return view("usuario.index",[
            'usuarios' => $usuarios,
            'titulo_pagina' => 'Usuários'
        ]);
    }

    public function create()
    {
        $empresas = Empresa::where('status', 'ativo')->get();
        
        return view("usuario.create",[
            'titulo_pagina' => 'Usuários',
            'empresas' => $empresas
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $user = new User;

        if(Auth::user()->nivel_acesso->nome == 'Administrador'){
            $user->empresa_id = $request->empresa_id;
            $user->nivel_acesso_id = NiveisAcesso::where('nome', '=', 'Usuário')->first()->id;
        }
        
        if(Auth::user()->nivel_acesso->nome == 'Master' && $request->nivel != null){
            $user->nivel_acesso_id = NiveisAcesso::where('nome', '=', $request->nivel)->first()->id;
            $user->empresa_id = $request->empresa_id;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect("/usuarios")->with("success", 'Usuário cadastrado com sucesso');
    }

    private function validator($request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ];

        $messages = [
            'name.required' => 'O campo nome é obrigátorio',
            'email.required'  => 'O campo e-mail é obrigatório.',
            'email.unique'    => ':attribute já está em uso',
            'email.email' => 'Incluir um email válido',
            'password.min' => 'A senha deve ter no mínimo :min caracteres!',
            'password.required' => 'O campo senha é obrigatório',
        ];

        $data = $request->all();

        return Validator::make($data, $rules, $messages);
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        return view("usuario.edit",[
            'titulo_pagina' => 'Usuário',
            "usuario" => $usuario
        ]);
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;

        if($usuario->id != Auth::user()->id){
            $usuario->status = ($request->status == 1) ? '1' : '0';
        }

        if(Auth::user()->nivel_acesso->nome == 'Master' && $request->nivel != null){
            $usuario->nivel_acesso_id = NiveisAcesso::where('nome', '=', $request->nivel)->first()->id;

        }

        if($request->password != ""){
            $usuario->password = Hash::make($request->password);
        }

        try {
            $usuario->save();

        } catch (\Throwable $th) {
            return redirect("/usuarios")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        return redirect("/usuarios")->with("success", 'Usuário editado com sucesso');
    }

    public function adicionarCreditos(Request $request)
    {        
        try {
            $userEscolhido = User::findOrFail($request->id);

            $planoAntigo = CreditoUsuario::where(function($query) use ($userEscolhido) {
                    $query->where('user_id', '=', $userEscolhido->id)
                        ->orWhere('empresa_id', '=', $userEscolhido->empresa_id);
                })
                ->where('status', '=', '1')
                ->orderBy('id', 'desc')
                ->first();

            $historicoTransacaoCredito = new HistoricoTransacaoCredito();

            $historicoTransacaoCredito->user_id = $request->id;
            $historicoTransacaoCredito->quantidade_credito = $request->credito;
            $historicoTransacaoCredito->tipo_transacao = "add";
            $historicoTransacaoCredito->descricao = "Contratado plano de crédito manual, quantidade de créditos adicionados: " . $request->credito;
            $historicoTransacaoCredito->empresa_id = $userEscolhido->empresa_id;

            $historicoTransacaoCredito->save();

            $planoAtual = CreditoUsuario::where(function($query) use ($userEscolhido) {
                    $query->where('user_id', '=', $userEscolhido->id)
                        ->orWhere('empresa_id', '=', $userEscolhido->empresa_id);
                })
                ->where('status', '=', '1')
                ->orderBy('id', 'desc')
                ->first();
    
            if($planoAtual != null){
                $planoAtual->status = '0';
    
                $planoAtual->save();
            }

            $novoCreditosDisponiveis = $request->credito + (($planoAntigo != null) ? $planoAntigo->total_creditos_disponiveis : 0);

            $creditosUsuario = new CreditoUsuario;

            $creditosUsuario->credito_id = null;
            $creditosUsuario->total_creditos_disponiveis = $novoCreditosDisponiveis;
            $creditosUsuario->user_id = $request->id;
            $creditosUsuario->empresa_id = $userEscolhido->empresa_id;
        
            $creditosUsuario->save();

            return redirect("/usuarios")->with("success", 'Créditos adicionados com sucesso');
            
        } catch (\Throwable $th) {
            return redirect("/usuarios")->with("danger", 'Erro ao adicionar créditos');

        }

    }
}
