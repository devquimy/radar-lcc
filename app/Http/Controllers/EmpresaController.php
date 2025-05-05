<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\Estudo;
use App\Models\LogRemocaoEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
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
            
            $rotasLiberadas = ['empresa.edit', 'empresa.update'];
            
            if(in_array($request->route()->getName(), $rotasLiberadas)){    
                return $next($request);
            }

            if(Auth::user()->nivel_acesso->nome != 'Master'){
                return redirect('/ativos_fisicos')->with('error', 'Erro, você não possui permissão para acessar esta tela.');
            }

            return $next($request);
        });
    }

    /**
     * Listagem de empresas.
     */
    public function index(Request $request)
    {        
        $empresas = Empresa::where('nome', '!=', null);
        
        if($request->busca != "" || $request->status != ""){
            Empresa::filtrar($empresas, $request);
        }
        
        return view("empresa.index", [
                'empresas' => $empresas->paginate(6),
                'titulo_pagina' => 'Empresas'
            ]
        );
    }

    /**
     * Formulário de criação de novas empresas.
     */
    public function create()
    {
        return view("empresa.create",[
            'titulo_pagina' => 'Empresas - Cadastro'
        ]);
    }

    /**
     * Cria um novo registro em empresas.
     */
    public function store(Request $request)
    {
        $validation = $this->validation($request);

        if($validation['status'] == true){
            $empresa = new Empresa();

            $empresa->setValues($empresa, $request);

            try {
                $empresa->save();

            } catch (\Throwable $th) {
                return redirect("/empresas")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

            }

            return redirect("/empresas")->with("success", 'Empresa cadastrada com sucesso');

        }else{
            return redirect("/empresas/create")->with("error", $validation['msg']);

        }
    }

    /**
     * Método que valida o formulário de cadastro
     *
     * @param Request $request
     * @return true|false
     */
    private function validation($request)
    {
        if($request->nome == ""){
            return [
                'status' => false,
                'msg' => 'Necessário inserir a razão social'
            ];
        }

        return [
            'status' => true,
            'msg' => ''
        ];
    }

    /**
     * Método que abre a tela para edição da empresa
     */
    public function edit($id)
    {
        if(Auth::user()->nivel_acesso->nome != 'Master' && $id != Auth::user()->empresa_id){
            return redirect('/ativos_fisicos')->with('error', 'Erro, você não possui permissão para acessar esta tela.');

        }

        $empresa = Empresa::findOrFail($id);
        
        return view("empresa.edit",[
            'empresa' => $empresa,
            'titulo_pagina' => 'Empresas - Edição'
        ]);
    }

    private function verificaEmail($email)
    {
        $usuario = User::where([
            ['email', $email],
            ['id' , '!=', Auth::user()->id]
        ])->first();

        if($usuario != null){
            return false;

        }

        return true;
    }

    /**
     * Método que atualiza uma empresa
     */
    public function update(Request $request, $id)
    {
        $validation = $this->validation($request);
        $validationUser = $this->validationUser($request);

        if($validationUser['status'] == true){
            $user = User::findOrFail(Auth::user()->id);
            
            $verificaEmail = $this->verificaEmail($request->email);

            if(!$verificaEmail){
                return redirect("/empresas/edit/$id")->with("error", 'Não é possível utilizar este e-mail, este e-mail já esta sendo usado por outro usuário');
            }

            $user->email = $request->email;
            $user->name = $request->name;

            if($request->password != ""){
                $user->password = Hash::make($request->password);
            }
            
            $user->save();

        }else{
            return redirect("/empresas/edit/$id")->with("error", $validationUser['msg']);

        }

        if($validation['status'] == true){
            $empresa = Empresa::findOrFail($id);
            $request['status'] = 'ativo';

            $validarEmpresa = Empresa::where('cnpj', $request->cnpj)->where('id', '!=' , $empresa->id)->first();

            if($validarEmpresa != null){
                return redirect()
                    ->back()
                    ->with('error', 'Não é possível utilizar o CNPJ de outra empresa existente no sistema')
                    ->withInput();
            }

            $validarCNPJ = $this->validarCNPJ($request->cnpj);

            if(!$validarCNPJ){
                return redirect()
                    ->back()
                    ->with('error', 'Não é possível utilizar este CNPJ, o CNPJ esta inválido')
                    ->withInput();
            }

            $empresa->setValues($empresa, $request);

            try {
                $empresa->save();

            } catch (\Throwable $th) {
                return redirect("/empresas/edit/$id")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

            }

            return redirect("/empresas/edit/$id")->with("success", 'Dados atualizados com sucesso');

        }else{
            return redirect("/empresas/edit/$id")->with("error", $validation['msg']);

        }
    }

    private function validarCNPJ($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    
        if (strlen($cnpj) != 14) {
            return false;
        }
    
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }
    
        $tamanho = 12;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
    
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
    
        $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        if ($resultado != $digitos[0]) {
            return false;
        }
    
        $tamanho = 13;
        $numeros = substr($cnpj, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
    
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
    
        $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        if ($resultado != $digitos[1]) {
            return false;
        }
    
        return true;
    }
    
    /**
     * Método que valida o formulário de login do usuário
     */
    private function validationUser($request)
    {
        if($request->password != $request->password_confirm){
            return [
                'status' => false,
                'msg' => 'Necessário que as senhas sejam iguais'
            ];
        }else if($request->password != "" && strlen($request->password) < 8){
            return [
                'status' => false,
                'msg' => 'Necessário que a senha seja maior ou igual a 8 caracteres'
            ];
        }else if ($request->email == ""){
            return [
                'status' => false,
                'msg' => 'Necessário que inserir o e-mail de login'
            ];
        }

        return [
            'status' => true,
            'msg' => ''
        ];
    }

    private function removeUsuariosEmpresa($empresa)
    {
        $usuariosEmpresa = User::where('empresa_id', $empresa->id)->get();

        foreach ($usuariosEmpresa as $key => $usuario) {
            $estudos = Estudo::where('user_id', $usuario->id)->get();

            $this->removeEstudoUsuario($estudos);
            
            $usuario->delete();
        }
    }

    private function removeEstudoUsuario($estudos)
    {
        foreach ($estudos as $key => $estudo) {
            $estudo->delete();
        }
    }

    private function geraLog()
    {
        $log = new LogRemocaoEmpresa();
        $log->user_id = Auth::user()->id;
        $log->save();
    }

    /**
     * Deleta uma empresa do banco de dados.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $empresa = Empresa::findOrFail($id);

            $this->removeUsuariosEmpresa($empresa);
            $this->geraLog();

            $empresa->delete();

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect("/empresas")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        return redirect('/empresas')->with('success', 'Empresa deletada com sucesso');
    }
}
