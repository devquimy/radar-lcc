<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\AtivoFisico;
use App\Models\Capex;
use App\Models\Estudo;
use App\Models\HistoricoTransacaoCredito;
use App\Models\Inflacao;
use App\Models\Opex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class OpexController extends Controller
{
    private function getMelhoriasReformas($melhorias_reformas)
    {
        if($melhorias_reformas->melhorias_reformas_ano[0] == null){
            return null;
        }

        $melhorias_reformas->melhorias_reformas_ano = array_map('intval', $melhorias_reformas->melhorias_reformas_ano);

        return $melhorias_reformas;
    }

    public function edit($id){
        $opex = Opex::findOrFail($id);
        $ativo_fisico = AtivoFisico::findOrFail($opex->estudo->ativo_fisico_id);

        if($ativo_fisico->valor_ativo == null){
            return redirect("/capex/edit/" . $opex->estudo->capex->id)->with("error", 'Insira o valor de aquisição antes de prosseguir');
        }

        if($opex->estudo->user->empresa_id != Auth::user()->empresa_id && Auth::user()->nivel_acesso->nome != 'Master' ){
            return redirect("/ativos_fisicos")->with("error", 'Não é possível visualizar este estudo, o estudo não pertence a sua empresa');
        }

        $melhorias_reformas = $this->getMelhoriasReformas(json_decode($opex->estudo->capex->melhorias_reformas));
        $inflacaoController = new InflacaoController;
        $inflacoes = $inflacaoController->formatarInflacoes(Inflacao::all());

        return view("opex.edit",[
            'titulo_pagina' => "Cadastrar os Valores das Despesas Operacionais (OPEX)",
            'opex' => $opex,
            'melhorias_reformas' => $melhorias_reformas,
            'ativo_fisico' => $ativo_fisico,
            'inflacoes' => $inflacoes,
            'timeline' => 3,
            'estudo' => $opex->estudo,
            'timeline_card_style_3' => 'timeline-card-3',
            'timeline_bottom_style_3' => 'timeline-bottom-3'
        ]);
    }

    public function verificaCreditos()
    {
        if(Auth::user()->credito_empresa->last() == null || Auth::user()->credito_empresa->last()->total_creditos_disponiveis == 0){
            return false;
        }

        return true;
    }

    private function debitarCreditos($estudo_id)
    {
        if(Auth::user()->nivel_acesso->nome == 'Master'){
            return;
        }
        
        $historicoTransacaoCredito = new HistoricoTransacaoCredito();

        $historicoTransacaoCredito->user_id = Auth::user()->id;
        $historicoTransacaoCredito->quantidade_credito = 1;
        $historicoTransacaoCredito->tipo_transacao = "sub";
        $historicoTransacaoCredito->descricao = "Debito crédito após conclusão do estudo ID: " . $estudo_id;
        $historicoTransacaoCredito->empresa_id = Auth::user()->empresa_id;

        $historicoTransacaoCredito->save();

        $credito = Auth::user()->credito_empresa->last();
        $credito->total_creditos_disponiveis = Auth::user()->credito_empresa->last()->total_creditos_disponiveis - 1;
        
        $credito->save();
    }

    public function store(Request $request)
    {
        $opex = Opex::findOrFail($request->opex_id);

        if(Auth::user()->nivel_acesso->nome != 'Master'){
            $verificaCreditos = $this->verificaCreditos();

            if(!$verificaCreditos && $opex->estudo->custo_anual_equivalente == null){
                return redirect("/opex/edit/" . $request->opex_id)->with("error", 'Não é possível finalizar o estudo, você não possui créditos disponíveis para esta ação');

            }
        }
        
        try {
            if($request->dados && $opex->dados_preenchidos_cliente){
                $array1 = $request->dados;
                $array2 = json_decode($opex->dados_preenchidos_cliente, true);
                
                $novoArray = array_replace_recursive($array1, $array2);
            }
    
            DB::beginTransaction();

            $formataRequisicaoJson = $this->formataRequisicaoJson($request);

            $estudo = new EstudosController;

            $opex->ano = json_decode($formataRequisicaoJson)->ano ;
            $opex->operadores = json_decode($formataRequisicaoJson)->operadores ;
            $opex->energia = json_decode($formataRequisicaoJson)->energia ;
            $opex->total_operacao = json_decode($formataRequisicaoJson)->total_operacao ;
            $opex->mantenedores_manutencao_planejada = json_decode($formataRequisicaoJson)->mantenedores_manutencao_planejada ;
            $opex->materiais_servicos_manutencao_planejada = json_decode($formataRequisicaoJson)->materiais_servicos_manutencao_planejada ;
            $opex->total_manutencao_planejada = json_decode($formataRequisicaoJson)->total_manutencao_planejada ;
            $opex->mantenedores_manutencao_n_planejada = json_decode($formataRequisicaoJson)->mantenedores_manutencao_n_planejada ;
            $opex->materiais_servicos_manutencao_n_planejada = json_decode($formataRequisicaoJson)->materiais_servicos_manutencao_n_planejada ;
            $opex->total_manutencao_n_planejada = json_decode($formataRequisicaoJson)->total_manutencao_n_planejada ;
            $opex->taxa_inflacao = json_decode($formataRequisicaoJson)->taxa_inflacao ;
            $opex->fator_multiplicador_sugerido = json_decode($formataRequisicaoJson)->fator_multiplicador_sugerido ;

            if($opex->ano_referencia_anterior == null){
                $opex->ano_referencia_anterior = $request->ano_referencia_anterior;
            }

            if(isset($novoArray)){
                $opex->dados_preenchidos_cliente = json_encode($novoArray);

            }else{
                $opex->dados_preenchidos_cliente = ($request->dados != null) ? json_encode($request->dados) : $opex->dados_preenchidos_cliente;

            }

            $opex->save();

            $this->verificaCapex($opex->estudo_id);

            $verificaAtivo = $this->verificaAtivo($opex->estudo_id);

            if($verificaAtivo['error'] == true){
                return redirect($verificaAtivo['redirect'])->with("error", $verificaAtivo['msg']);
            }

            if($opex->estudo->custo_anual_equivalente == null){
                $this->debitarCreditos($opex->estudo_id);

            }else if($opex->estudo->status == 1 && $this->verificaDataValidade($opex->estudo) == true){
                //Finaliza o estudo ao gerar o CAE novamente e bloqueia o acesso
                $opex->estudo->status = 2;
                $opex->estudo->save();
            }

            $estudo->gerarFluxoCustosAnuais($opex);
            $estudo->gerarValorPresente($opex);
            $estudo->gerarCustoAnualEquivalente($opex);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect("/opex/edit/$request->opex_id")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');
        }

        return redirect("/estudo/curva_anual_equivalente/$opex->estudo_id")->with("success", 'Opex salvo com sucesso');
    }

    private function verificaDataValidade($estudo)
    {
        // Data que você quer verificar
        $dataVerificacao = new DateTime(date('Y-m-d', strtotime($estudo->created_at)));

        // Data de um ano a partir da data de verificação
        $dataUmAnoDepois = (clone $dataVerificacao)->modify('+1 year');

        // Data atual
        $dataAtual = new DateTime();

        // Verifica se a data está dentro do intervalo de um ano a partir de hoje
        if ($dataAtual >= $dataVerificacao && $dataAtual <= $dataUmAnoDepois) {
            return true;

        } else {
            return false;

        }
    }

    private function verificaAtivo($estudo_id)
    {
        $estudo = Estudo::findOrFail($estudo_id);
        $ativo = AtivoFisico::findOrFail($estudo->ativo_fisico_id);

        if($ativo->valor_ativo == '0.00' || $ativo->valor_ativo == null){
            return [
                'error' => true,
                'msg' => 'Não é possível gerar a curva sem preencher o valor de aquisição do ativo físico',
                'redirect' => "/capex/edit/$estudo->capex_id"
            ];

        }else if($estudo->tma == null){
            return [
                'error' => true,
                'msg' => 'Não é possível gerar a curva sem preencher o TMA',
                'redirect' => "/ativos_fisicos/edit/$estudo->ativo_fisico_id/$estudo->id"
            ];
        }

        return [
            'error' => false
        ];
    }

    private function verificaCapex($estudo_id)
    {
        $melhoria_reformas_padrao = '{"melhorias_reformas_ano": [null], "melhorias_reformas_valor": ["0,00"], "melhorias_reformas_operacao": [null], "melhorias_reformas_man_planejada": [null], "melhorias_reformas_man_n_planejada": [null]}';
        $atualizacao_patrimonial_padrao = '{"atualizacao_patrimonial_ano": [null, null, null, null, null], "atualizacao_patrimonial_valor": ["0,00", "0,00", "0,00", "0,00", "0,00"]}';

        $capex = Capex::where('estudo_id', '=', $estudo_id)->first();

        if($capex->melhorias_reformas == null){
            $capex->melhorias_reformas = $melhoria_reformas_padrao;
        }

        if($capex->atualizacao_patrimonial == null){
            $capex->atualizacao_patrimonial = $atualizacao_patrimonial_padrao;
        }

        $capex->save();
    }

    private function formataRequisicaoJson($request)
    {
        $json = json_encode([
            'ano' => $request->ano, 
            'operadores' => $request->operadores, 
            'energia' => $request->energia, 
            'total_operacao' => $request->total_operacao,
            'mantenedores_manutencao_planejada' => $request->mantenedores_manutencao_planejada,
            'materiais_servicos_manutencao_planejada' => $request->materiais_servicos_manutencao_planejada,
            'total_manutencao_planejada' => $request->total_manutencao_planejada,
            'mantenedores_manutencao_n_planejada' => $request->mantenedores_manutencao_n_planejada,
            'materiais_servicos_manutencao_n_planejada' => $request->materiais_servicos_manutencao_n_planejada,
            'total_manutencao_n_planejada' => $request->total_manutencao_n_planejada,
            'taxa_inflacao' => $request->taxa_inflacao,
            'fator_multiplicador_sugerido' => $request->fator_multiplicador_sugerido
        ]);

        return $json;
    }
}
