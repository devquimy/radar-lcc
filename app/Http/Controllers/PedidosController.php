<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\CreditoUsuario;
use App\Models\HistoricoTransacaoCredito;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    public function index()
    {
        if(Auth::user()->nivel_acesso->nome == 'Master'){
            $pedidos = Pedido::paginate(10);

        }else{
            $pedidos = Pedido::where('user_id', '=', Auth::user()->id)->paginate(10);

        }
        
        return view("pedido.index",[
            'pedidos' => $pedidos,
            'titulo_pagina' => 'Pedidos'
        ]);
    }

    public function gerarPedido(Request $request)
    {
        $credito = $this->getCredito($request->credito_id);

        try {
            $validaCnpj = $this->validarCNPJ(Auth::user()->empresa->cnpj);

            if(!$validaCnpj){
                return redirect("/empresas/edit/" . Auth::user()->empresa->id)->with("error", 'CNPJ inválido, favor atualizar para um CNPJ válido');

            }

            $pedidoPagSeguro = $this->criarPedidoPagSeguro($request, $credito);

            $pedido = new Pedido();
            $pedido->json_pedidos = json_encode($pedidoPagSeguro);
            $pedido->user_id = Auth::user()->id;
            $pedido->save();

            if($pedidoPagSeguro->charges[0]->status == 'PAID' || $pedidoPagSeguro->charges[0]->status == 'AUTHORIZED'){
                $planoAntigo = $this->getPlanoAtual();
                $novoPlano = $this->gerarCreditoCliente($credito, $planoAntigo);

                return redirect("/creditos/plano_contratado_sucesso")
                    ->with('novoPlano', $novoPlano)
                    ->with('planoAntigo', $planoAntigo);

            }else{
                return redirect("/pedidos")->with("error", 'Pagamento não aprovado, verifique se o cartão possui saldo disponível para compra');

            }
        } catch (\Throwable $th) {
            return redirect("/creditos")->with("error", 'Erro encontrado nos dados de pagamento, verifique os dados inserido e tente novamente');

        }
    }

    public function gerarCreditoCliente($credito, $planoAntigo)
    {
        $novoCreditosDisponiveis = $credito->qtd_estudos + (($planoAntigo != null) ? $planoAntigo->total_creditos_disponiveis : 0);

        $this->criarHistoricoTransacaoCredito($credito);
        $this->desabilitarPlanoAtual();
        $novoPlano = $this->criarNovoPlano($novoCreditosDisponiveis, $credito);

        return $novoPlano;
    }

    private function criarNovoPlano($novosCreditos, $novoPlano)
    {
        $creditosUsuario = new CreditoUsuario;

        $creditosUsuario->credito_id = $novoPlano->id;
        $creditosUsuario->total_creditos_disponiveis = $novosCreditos;
        $creditosUsuario->user_id = Auth::user()->id;
        $creditosUsuario->empresa_id = Auth::user()->empresa_id;
    
        $creditosUsuario->save();

        return $creditosUsuario;
    }

    private function desabilitarPlanoAtual()
    {
        $planoAtual = CreditoUsuario::where(function($query) {
                $query->where('user_id', '=', Auth::user()->id)
                    ->orWhere('empresa_id', '=', Auth::user()->empresa_id);
            })
            ->where('status', '=', '1')
            ->orderBy('id', 'desc')
            ->first();

        if($planoAtual != null){
            $planoAtual->status = '0';

            $planoAtual->save();
        }
    }

    private function criarHistoricoTransacaoCredito($planoCreditoSelecionado)
    {
        $historicoTransacaoCredito = new HistoricoTransacaoCredito();

        $historicoTransacaoCredito->user_id = Auth::user()->id;
        $historicoTransacaoCredito->quantidade_credito = $planoCreditoSelecionado->qtd_estudos;
        $historicoTransacaoCredito->tipo_transacao = "add";
        $historicoTransacaoCredito->descricao = "Contratado plano de crédito, plano ID: " . $planoCreditoSelecionado->id;
        $historicoTransacaoCredito->empresa_id = Auth::user()->empresa_id;

        $historicoTransacaoCredito->save();
    }

    public function getPlanoAtual()
    {
        $planoAtual = CreditoUsuario::where(function($query) {
                $query->where('user_id', '=', Auth::user()->id)
                    ->orWhere('empresa_id', '=', Auth::user()->empresa_id);
            })
            ->where('status', '=', '1')
            ->orderBy('id', 'desc')
            ->first();

        return $planoAtual;
    }

    private function getCredito($id)
    {
        $credito = Credito::findOrFail($id);

        return $credito;
    }

    private function validarCNPJ($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    
        if (strlen($cnpj) != 14) {
            return false;
        }
    
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }
    
        $peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $peso2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    
        $soma1 = 0;
        for ($i = 0; $i < 12; $i++) {
            $soma1 += $cnpj[$i] * $peso1[$i];
        }
        $resto1 = $soma1 % 11;
        $digito1 = ($resto1 < 2) ? 0 : 11 - $resto1;
    
        $soma2 = 0;
        for ($i = 0; $i < 13; $i++) {
            $soma2 += $cnpj[$i] * $peso2[$i];
        }
        $resto2 = $soma2 % 11;
        $digito2 = ($resto2 < 2) ? 0 : 11 - $resto2;
    
        return ($cnpj[12] == $digito1 && $cnpj[13] == $digito2);
    }

    private function criarPedidoPagSeguro($request, $credito)
    {
        $ultimoPedidoID = (Pedido::latest()->first() != null) ? Pedido::latest()->first()->id + 1 : 1;
        
        $json = '{
            "reference_id": "Pedido-'.$ultimoPedidoID.'",
            "customer": {
                "name": "'. Auth::user()->name .'",
                "email": "'. Auth::user()->email .'",
                "tax_id": "'. str_replace([".", "-", "/"], "", Auth::user()->empresa->cnpj) .'",
                "phones": [
                    {
                        "country": "55",
                        "area": "11",
                        "number": "99999999",
                        "type": "MOBILE"
                    }
                ]
            },
            "items": [
                {
                    "reference_id": "'. $credito->id .'",
                    "name": "Crédito ID: '. $credito->id .'",
                    "quantity": '.$credito->qtd_estudos.',
                    "unit_amount": '. $credito->valor * 100 .'
                }
            ],
            "shipping": {
                "address": {
                    "street": "Rua teste",
                    "number": "123",
                    "complement": "Teste",
                    "locality": "São Paulo",
                    "city": "São Paulo",
                    "region_code": "SP",
                    "country": "BRA",
                    "postal_code": "01452002"
                }
            },
            "notification_urls": [
                "https://meusite.com/notificacoes"
            ],
            "charges": [
                {
                    "reference_id": "Pedido-Cobranca ID: '.$ultimoPedidoID.'",
                    "description": "Contratação de novos crédito",
                    "amount": {
                        "value": '. $credito->valor * 100 .',
                        "currency": "BRL"
                    },
                    "payment_method": {
                        "type": "CREDIT_CARD",
                        "installments": 1,
                        "capture": true,
                        "card": {
                            "encrypted": "'.$_POST['encrypted-card'].'",
                            "store": true
                        },
                        "holder": {
                          "name": "'. $request->nomeCartao .'",
                          "tax_id": "'. str_replace([".", "-", "/"], "", $request->cpfCartao) .'"
                        }
                    }
                }
            ]
        }';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', (env("PAGSEGURO_SANDBOX") == true) ? 'https://sandbox.api.pagseguro.com/orders' : 'https://api.pagseguro.com/orders', [
            'body' => $json,
            'headers' => [
                'Authorization' => env("PAGSEGURO_TOKEN"),
                'accept' => '*/*',
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody());
    }
}
