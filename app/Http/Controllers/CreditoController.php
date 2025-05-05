<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\CreditoUsuario;
use App\Models\HistoricoTransacaoCredito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditoController extends Controller
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
            
            $rotasNaoLiberadas = ['credito.create'];

            if(in_array($request->route()->getName(), $rotasNaoLiberadas) && Auth::user()->nivel_acesso->nome != 'Master'){
                return redirect('/ativos_fisicos')->with('error', 'Erro, você não possui permissão para acessar esta tela.');
            }

            return $next($request);
        });
    }

    public function testePagamento(Request $request)
    {

        // $client = new \GuzzleHttp\Client();

        // //Consulta pedido
        // $response = $client->request('GET', 'https://sandbox.api.pagseguro.com/orders/ORDE_2536FD53-FD1E-4813-A60F-905372A653FE', [
        //     'headers' => [
        //         'Authorization' => env("PAGSEGURO_TOKEN"),
        //         'accept' => '*/*',
        //     ],
        // ]);

        // //Consulta pagamento
        // $response = $client->request('GET', 'https://sandbox.api.pagseguro.com/charges/CHAR_CF8D8B36-6703-4DA2-8F93-13EB33AC3D61', [
        //     'headers' => [
        //         'Authorization' => env("PAGSEGURO_TOKEN"),
        //         'accept' => '*/*',
        //     ],
        // ]);

    }

    public function index(Request $request)
    {        
        if(Auth::user()->nivel_acesso->nome == 'Master'){
            $mode_view = 'adm';
            $creditos = Credito::paginate(6);


        }else{
            $mode_view = 'user';
            $creditos = Credito::all();

        }

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', (env("PAGSEGURO_SANDBOX") == true) ? 'https://sandbox.api.pagseguro.com/public-keys' : 'https://api.pagseguro.com/public-keys', [
            'body' => '{"type":"card"}',
            'headers' => [
                'Authorization' => 'Bearer ' . env("PAGSEGURO_TOKEN"),
                'accept' => '*/*',
                'content-type' => 'application/json',
            ],
        ]);

        return view("credito.index",[
            'creditos' => $creditos,
            'mode_view' => $mode_view,
            'key' => json_decode($response->getBody())->public_key,
            'titulo_pagina' => 'Créditos para estudo'
        ]);
    }

    public function create()
    {
        return view("credito.create",[
            'titulo_pagina' => 'Adicionar planos de créditos'
        ]);
    }

    public function store(Request $request)
    {
        $credito = new Credito;

        $credito->qtd_estudos = $request->qtd_estudos;
        $credito->valor = preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".",$request->valor));
        
        try {
            $credito->save();

        } catch (\Throwable $th) {
            return redirect("/creditos")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        return redirect("/creditos")->with("success", 'Plano de crédito cadastrado com sucesso');
    }

    public function edit($id)
    {
        $credito = Credito::findOrFail($id);

        return view("credito.edit",[
            'titulo_pagina' => 'Editar plano de crédito',
            "credito" => $credito
        ]);
    }

    public function update(Request $request, $id)
    {
        $credito = Credito::findOrFail($id);

        $credito->qtd_estudos = $request->qtd_estudos;
        $credito->valor = preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".",$request->valor));
        
        try {
            $credito->save();

        } catch (\Throwable $th) {
            return redirect("/creditos")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        return redirect("/creditos")->with("success", 'Plano de crédito editado com sucesso');
    }

    public function planoContratadoSucesso()
    {
        return view('credito.plano_contratado_sucesso', [
            'titulo_pagina' => 'Créditos contratados com sucesso'
        ]);
    }

}
