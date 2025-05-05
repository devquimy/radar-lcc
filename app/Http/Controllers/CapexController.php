<?php
namespace App\Http\Controllers;

use App\Models\AtivoFisico;
use App\Models\Capex;
use App\Models\Estudo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CapexController extends Controller
{
    private function formataRequisicaoJson($request)
    {
        $melhorias_reformas = json_encode([
            'melhorias_reformas_ano' => $request->melhorias_reformas_ano, 
            'melhorias_reformas_valor' => $request->melhorias_reformas_valor, 
            'melhorias_reformas_operacao' => $request->melhorias_reformas_operacao, 
            'melhorias_reformas_man_planejada' => $request->melhorias_reformas_man_planejada,
            'melhorias_reformas_man_n_planejada' => $request->melhorias_reformas_man_n_planejada
        ]);

        $atualizacao_patrimonial = json_encode([
            'atualizacao_patrimonial_ano' => $request->atualizacao_patrimonial_ano,
            'atualizacao_patrimonial_valor' => $request->atualizacao_patrimonial_valor
        ]);

        $json = json_encode([
            'atualizacao_patrimonial' => $atualizacao_patrimonial, 
            'melhorias_reformas' => $melhorias_reformas
        ]);

        return $json;
    }

    public function edit($id)
    {
        $capex = Capex::findOrFail($id);
        $ativo_fisico = AtivoFisico::findOrFail($capex->ativo_fisico_id);

        if($capex->estudo->user->empresa_id != Auth::user()->empresa_id && Auth::user()->nivel_acesso->nome != 'Master' ){
            return redirect("/ativos_fisicos")->with("error", 'Não é possível visualizar este estudo, o estudo não pertence a sua empresa');
        }

        return view("capex.edit",[
            'titulo_pagina' => "Cadastrar os Valores das Despesas de Capital (CAPEX)",
            'capex' => $capex,
            'ativo_fisico' => $ativo_fisico,
            'estudo' => $capex->estudo,
            'timeline' => 2,
            'timeline_card_style_2' => 'timeline-card-2',
            'timeline_bottom_style_2' => 'timeline-bottom-2'
        ]);
    }

    public function update(Request $request, $id)
    {
        $capex = Capex::findOrFail($id);
        $ativo_fisico = AtivoFisico::findOrFail($capex->ativo_fisico_id);

        try {
            DB::beginTransaction();

            $ativo_fisico->setValues($ativo_fisico, $request);
            
            $valorAtivoAtualizado = $this->atualizaValorAquisicao($request, $ativo_fisico, $capex);

            $ativo_fisico->valor_ativo = $valorAtivoAtualizado;

            $ativo_fisico->save();

            $formataRequisicaoJson = $this->formataRequisicaoJson($request);

            $capex->motivo_escolha_ativo_fisico = $request->motivo_escolha_ativo_fisico;
            $capex->atualizacao_patrimonial = json_decode($formataRequisicaoJson)->atualizacao_patrimonial;
            $capex->melhorias_reformas = json_decode($formataRequisicaoJson)->melhorias_reformas;
            $capex->ativo_fisico_id = $request->ativo_fisico_id;        

            $capex->save();

            if($request->atualizar_cae){
                $estudo_id = $capex->estudo->opex->estudo_id;
                $estudo = new EstudosController;

                $estudo->gerarFluxoCustosAnuais($capex->estudo->opex);
                $estudo->gerarValorPresente($capex->estudo->opex);
                $estudo->gerarCustoAnualEquivalente($capex->estudo->opex);
            }

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect("/capex/edit/$id")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        if($request->atualizar_cae){
            return redirect("/estudo/curva_anual_equivalente/$estudo_id")->with("success", 'C.A.E atualizado com sucesso');
        }

        // return redirect("/capex/edit/$id")->with("success", 'Capex salvo com sucesso');
        return redirect("/opex/edit/" . $capex->estudo->opex_id)->with("success", 'Capex salvo com sucesso');
    }

    private function atualizaValorAquisicao($request, $ativo_fisico, $capex)
    {       
        $soma = [];

        foreach ($request->atualizacao_patrimonial_ano as $i => $ano) {
            if($ano != null){
                $diferencaAno = $ano - $ativo_fisico->ano_aquisicao;
                $valor = preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".", $request->atualizacao_patrimonial_valor[$i]));
                $tma = $capex->estudo->tma / 100;

                $soma[] = $this->calcularValor($valor, $tma, $diferencaAno);
            }
        }

        if(count($soma) >= 1){
            $valorAtivoAtualizado = $ativo_fisico->valor_ativo_original + array_sum($soma); 

            return $valorAtivoAtualizado;
        }
        
        return $ativo_fisico->valor_ativo_original;
    }

    private function calcularValor($B8, $B4, $D8) {
        // Cálculo da fórmula B8 / (1 + B4)^D8
        $resultado = $B8 / pow((1 + $B4), $D8);
        
        // Retorna o resultado
        return $resultado;
    }
}
