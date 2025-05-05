<?php

namespace App\Http\Controllers;

use App\Models\AtivoFisico;
use App\Models\Estudo;
use Illuminate\Http\Request;
use App\Models\Capex;
use App\Models\CustosAnuais;
use App\Models\CustosAnuaisEquivalentes;
use App\Models\Documento;
use App\Models\ValorPresente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mpdf\Mpdf;

class EstudosController extends Controller
{
    public function index($id)
    {
        $estudos = Estudo::where('ativo_fisico_id', '=', $id)->get();

        if($estudos->first()->user->empresa_id != Auth::user()->empresa_id && Auth::user()->nivel_acesso->nome != 'Master' ){
            return redirect("/ativos_fisicos")->with("error", 'Não é possível visualizar este estudo, o estudo não pertence a sua empresa');

        }

        return view('estudo.index',[
            'estudos' => $estudos,
            'titulo_pagina' => 'Estudos do ativo ' . $estudos[0]->ativo_fisico->nome_ativo
        ]);
    }

    public function curvaAnualEquivalente($id)
    {
        $estudo = Estudo::findOrFail($id);

        if($estudo->user->empresa_id != Auth::user()->empresa_id && Auth::user()->nivel_acesso->nome != 'Master' ){
            return redirect("/ativos_fisicos")->with("error", 'Não é possível visualizar este estudo, o estudo não pertence a sua empresa');
        }

        return view('estudo.curva_anual_equivalente',[
            'estudo' => $estudo,
            'titulo_pagina' => 'Curva do Custo Anual Equivalente ',
            'timeline' => 4,
            'timeline_card_style_4' => 'timeline-card-4',
            'timeline_bottom_style_4' => 'timeline-bottom-4'
        ]);
    }

    public function gerarCustoAnualEquivalente($opex)
    {
        $ativo_fisico = AtivoFisico::findOrFail($opex->estudo->ativo_fisico_id);
        $capex = Capex::findOrFail($opex->estudo->capex_id);
        $valorPresente = ValorPresente::where("estudo_id", "=", $capex->estudo_id)->first();
        $estudo = Estudo::findOrFail($capex->estudo_id);

        $index = 0;

        // Colocar + 40 anos
        for ($ano = $ativo_fisico->ano_aquisicao; $ano <= $ativo_fisico->ano_aquisicao + 40 ; $ano++) { 
            $vplCapex = $this->getVplCapex($valorPresente, $ano, $ativo_fisico);
            $valorAnualEquivalenteCapex = $this->getValorAnualEquivalenteCapex($vplCapex, $estudo->tma, $index);

            $valoresCapex[$ano] = [
                'vpl' => $vplCapex,
                'valor_anual_equivalente_capex' => $valorAnualEquivalenteCapex
            ];

            $vplOpex = $this->getVplOpex($valorPresente, $ano, $ativo_fisico);
            $valorAnualEquivalenteOpex = $this->getValorAnualEquivalenteOpex($vplOpex, $estudo->tma, $index);

            $valoresOpex[$ano] = [
                'vpl' => $vplOpex,
                'valor_anual_equivalente_opex' => $valorAnualEquivalenteOpex
            ];

            $vplCapexOpex = $this->getVplCapexOpex($valorPresente, $ativo_fisico, $ano);
            $cae = $this->getCustoAnualEquivalente($valoresCapex[$ano]['valor_anual_equivalente_capex'], $valoresOpex[$ano]['valor_anual_equivalente_opex']);

            $estudoArray[$ano] = [
                'capex' => $valoresCapex[$ano],
                'opex' => $valoresOpex[$ano],
                'vpl_capex_opex' => $vplCapexOpex,
                'custo_anual_equivalente' => $cae
            ];

            $index++;
        }

        $custosAnuaisEquivalente = CustosAnuaisEquivalentes::where("estudo_id", "=", $opex->estudo_id)->first();
        
        if($custosAnuaisEquivalente == null){           
            $custosAnuaisEquivalente = new CustosAnuaisEquivalentes();
        }

        // Inicializa o menor valor como null
        $menorValor = null;

        // Percorre o array para encontrar o menor valor de "custo_anual_equivalente"
        foreach ($estudoArray as $ano => $info) {
            if ($menorValor === null || $info['custo_anual_equivalente'] < $menorValor) {
                if($info['custo_anual_equivalente'] != 0){
                    $menorValor = $info['custo_anual_equivalente'];
                    $menorAno = $ano;

                }
            }
        }

        $custosAnuaisEquivalente->calculos = json_encode($estudoArray);
        $custosAnuaisEquivalente->estudo_id = $opex->estudo_id;
        $custosAnuaisEquivalente->menor_valor_cae = json_encode([$menorAno => $menorValor]);

        $custosAnuaisEquivalente->save();
    }

    private function getCustoAnualEquivalente($valoresAnualCapex, $valoresAnualOpex)
    {
        return $valoresAnualCapex + $valoresAnualOpex;
    }

    private function getVplCapexOpex($valorPresente, $ativo_fisico, $ano)
    {
        if($ativo_fisico->ano_aquisicao == $ano){
            return 0;
            
        }else{
            return json_decode($valorPresente->calculos)->$ano->total_capex_opex;

        }
    }

    private function getValorAnualEquivalenteOpex($vplOpex, $tma, $index)
    {
        $porcentagem_tma = $tma / 100;

        if($index == 0){
            return 0;

        }else{
            return $this->calcularPGTO($porcentagem_tma, $index, $vplOpex);

        }
    }

    private function getVplOpex($valorPresente, $ano, $ativo_fisico)
    {
        return json_decode($valorPresente->calculos)->$ano->opex->acumulado;
    }

    private function getValorAnualEquivalenteCapex($vplCapex, $tma, $index)
    {
        $porcentagem_tma = $tma / 100;

        if($index == 0){
            return 0;

        }else{
            return $this->calcularPGTO($porcentagem_tma, $index, $vplCapex);

        }
    }

    private function getVplCapex($valorPresente, $ano, $ativo_fisico)
    {
        return json_decode($valorPresente->calculos)->$ano->capex->acumulado;
    }

    /**
     * Método que gera o valor presente
     *
     * @param Opex $opex
     * @return 
     */
    public function gerarValorPresente($opex)
    {
        $ativo_fisico = AtivoFisico::findOrFail($opex->estudo->ativo_fisico_id);
        $capex = Capex::findOrFail($opex->estudo->capex_id);
        $custosAnuais = CustosAnuais::where("estudo_id", "=", $capex->estudo_id)->first();
        $estudo = Estudo::findOrFail($capex->estudo_id);

        $index = 0;

        // Colocar + 40 anos
        for ($ano = $ativo_fisico->ano_aquisicao; $ano <= $ativo_fisico->ano_aquisicao + 40 ; $ano++) { 
            $totalAnoCustoCapital = $this->getTotalAnoCustoCapitalVP($ano, $custosAnuais);
            $valorPresenteCapex = $this->getValorPresenteCapex($index, $ano, $estudo->tma, $ativo_fisico);
            $acumuladoCapex = $this->getAcumuladoCapexVP($ano, $custosAnuais, $index, $valorPresenteCapex);

            $valoresCapex[$ano] = [
                'total_ano_custo_capital' => $totalAnoCustoCapital,
                'acumulado' => $acumuladoCapex,
                'valor_presente_capex' => $valorPresenteCapex
            ];

            $totalAnoCustoOperacional = $this->getTotalAnoCustoOperacionalVP($ano, $custosAnuais);
            $valorPresenteOpex = $this->getValorPresenteOpex($index, $ano, $estudo->tma, $ativo_fisico);
            $acumuladoOpex = $this->getAcumuladoOpexVP($ano, $custosAnuais, $index, $valorPresenteOpex);

            $valoresOpex[$ano] = [
                'total_ano_custo_operacao' => $totalAnoCustoOperacional,
                'acumulado' => $acumuladoOpex,
                'valor_presente_opex' => $valorPresenteOpex
            ];

            $estudoCapexOpex[$ano] = [
                'capex' => $valoresCapex[$ano],
                'opex' => $valoresOpex[$ano],
                'total_capex_opex' => $this->getTotalCapexOpexVP($valorPresenteCapex ?? 0, $valorPresenteOpex ?? 0)
            ];

            $index++;
        }
        
        $valorPresente = ValorPresente::where("estudo_id", "=", $opex->estudo_id)->first();
        
        if($valorPresente == null){           
            $valorPresente = new ValorPresente();
        }

        $valorPresente->calculos = json_encode($estudoCapexOpex);
        $valorPresente->estudo_id = $opex->estudo_id;

        $valorPresente->save();
    }

    /**
     * Método que calcula o valor total do ano para valor presente
     *
     * @param float $totalAnoCustoCapital
     * @param float $totalAnoCustoOperacional
     * @return float
     */
    private function getTotalCapexOpexVP($totalAnoCustoCapital, $totalAnoCustoOperacional)
    {
        return $totalAnoCustoCapital + $totalAnoCustoOperacional;
    }

    /**
     * Método que calcula o valor presente de opex
     *
     * @param int $index
     * @param int $ano
     * @param float $tma
     * @param AtivoFisico $ativo_fisico
     * @return float
     */
    private function getValorPresenteOpex($index, $ano, $tma, $ativo_fisico)
    {
        $porcentagem_tma = $tma / 100;

        return round($this->calcularVpNovo(Session::get('total_ano_custo_operacional_opex'), $porcentagem_tma, $index), 2);
    }

    /**
     * Método que calcula o valor acumulado de opex para tabela valor presente
     *
     * @param int $ano
     * @param object $custosAnuais
     * @param int $index
     * @return float
     */
    private function getAcumuladoOpexVP($ano, $custosAnuais, $index, $valorPresenteOpex)
    {
        $calculos = json_decode($custosAnuais->calculos);

        if($index == 0){
            Session::put('total_acumulado_opex', $calculos->$ano->opex->total_ano_custo_operacional);

            return $calculos->$ano->opex->total_ano_custo_operacional;

        }else{
            $novoValor = Session::get('total_acumulado_opex') + $valorPresenteOpex;

            Session::put('total_acumulado_opex', $novoValor);

            return $novoValor;
        }
    }

    /**
     * Método que calcula o total de custo operacional do ano para tabela valor presente
     *
     * @param int $ano
     * @param object $custosAnuais
     * @return float
     */
    private function getTotalAnoCustoOperacionalVP($ano, $custosAnuais)
    {
        $calculos = json_decode($custosAnuais->calculos);

        Session::put('total_ano_custo_operacional_opex', $calculos->$ano->opex->total_ano_custo_operacional);

        return $calculos->$ano->opex->total_ano_custo_operacional;
    }

    /**
     * Método que calcula o valor presente de capex
     *
     * @param int $index
     * @param int $ano
     * @param float $tma
     * @param AtivoFisico $ativo_fisico
     * @return float
     */
    private function getValorPresenteCapex($index, $ano, $tma, $ativo_fisico)
    {
        $porcentagem_tma = $tma / 100;

        return round($this->calcularVpNovo(Session::get('total_ano_custo_capital_capex'), $porcentagem_tma, $index), 2);
    }

    private function calcularVpNovo($D7, $B24, $C7) {
        return $D7 / pow((1 + $B24), $C7);
    }

    /**
     * Método que calcula o valor acumalado de capex para tabela valor presente
     *
     * @param int $ano
     * @param object $custosAnuais
     * @param int $index
     * @return float
     */
    private function getAcumuladoCapexVP($ano, $custosAnuais, $index, $valorPresenteCapex)
    {
        $calculos = json_decode($custosAnuais->calculos);

        if($index == 0){
            Session::put('total_acumulado_capex', $calculos->$ano->capex->total_ano_custo_capital);

            return $calculos->$ano->capex->total_ano_custo_capital;

        }else{
            $novoValor = Session::get('total_acumulado_capex') + $valorPresenteCapex;

            Session::put('total_acumulado_capex', $novoValor);

            return $novoValor;
        }
    }

    /**
     * Método que calcula o total de custo capital do ano para tabela valor presente
     *
     * @param int $ano
     * @param object $custosAnuais
     * @return float
     */
    private function getTotalAnoCustoCapitalVP($ano, $custosAnuais)
    {
        $calculos = json_decode($custosAnuais->calculos);

        Session::put('total_ano_custo_capital_capex', $calculos->$ano->capex->total_ano_custo_capital);

        return $calculos->$ano->capex->total_ano_custo_capital;
    }

    /**
     * Método que gera o fluxo de custos anuais
     *
     * @param Opex $opex
     * @return
     */
    public function gerarFluxoCustosAnuais($opex)
    {
        $ativo_fisico = AtivoFisico::findOrFail($opex->estudo->ativo_fisico_id);
        $capex = Capex::findOrFail($opex->estudo->capex_id);

        $index = 0;

        // Colocar + 40 anos
        for ($ano = $ativo_fisico->ano_aquisicao; $ano <= $ativo_fisico->ano_aquisicao + 40 ; $ano++) { 
            if($ano == $ativo_fisico->ano_aquisicao){
                $totalAnoCustoCapital = $ativo_fisico->valor_ativo;

                $valoresCapex[$ano] = [
                    'beneficio_fiscal_despreciacao' => 0,
                    'melhoria' => $this->getMelhoria($capex, $ano),
                    'valor_revenda' => 0,
                    'custo_perda_valor' => 0,
                    'custo_oportunidade' => 0,
                    'total_ano_custo_capital' => $ativo_fisico->valor_ativo + $ativo_fisico->custo_comissionamento + $ativo_fisico->custo_instalacao
                ];
            }else{
                $beneficioFiscalDepreciacao = $this->getBeneficioFiscalDepreciacao($ativo_fisico, $ano);
                $melhoria = $this->getMelhoria($capex, $ano);
                $valorRevenda = $this->getValorRevenda($ativo_fisico, $ano);
                $custoPerdaValor = $this->getCustoPerdaValor($ativo_fisico, $ano);
                $custoOportunidade = $this->getCustoOportunidade($opex->estudo);
                $totalAnoCustoCapital = $this->getTotalAnoCustoCapital($custoPerdaValor, $custoOportunidade, $melhoria, $beneficioFiscalDepreciacao);

                $valoresCapex[$ano] = [
                    'beneficio_fiscal_despreciacao' => $beneficioFiscalDepreciacao,
                    'melhoria' => $melhoria,
                    'valor_revenda' => $valorRevenda,
                    'custo_perda_valor' => $custoPerdaValor,
                    'custo_oportunidade' => $custoOportunidade,
                    'total_ano_custo_capital' => $totalAnoCustoCapital
                ];
            }

            $operacao = $this->getOperacao($opex, $index);
            $manutencaoPlanejada = $this->getManutencaoPlanejada($opex, $index);
            $manutencaoNaoPlanejada = $this->getManutencaoNaoPlanejada($opex, $index);
            $totalAnoCustoOperacional = $this->getTotalAnoCustoOperacional($operacao, $manutencaoPlanejada, $manutencaoNaoPlanejada);

            $valoresOpex[$ano] = [
                'operacao' => $operacao,
                'manutencao_planejada' => $manutencaoPlanejada,
                'manutencao_n_planejada' => $manutencaoNaoPlanejada,
                'total_ano_custo_operacional' => $totalAnoCustoOperacional
            ];

            $estudo[$ano] = [
                'capex' => $valoresCapex[$ano],
                'opex' => $valoresOpex[$ano],
                'total_capex_opex' => $this->getTotalCapexOpex($totalAnoCustoCapital ?? 0, $totalAnoCustoOperacional ?? 0)
            ];

            $index++;
        }
        
        $custosAnuais = CustosAnuais::where("estudo_id", "=", $opex->estudo_id)->first();
        
        if($custosAnuais == null){           
            $custosAnuais = new CustosAnuais();
        }

        $custosAnuais->calculos = json_encode($estudo);
        $custosAnuais->estudo_id = $opex->estudo_id;

        $custosAnuais->save();
    }

    /**
     * Método que calcula o Benefício Fiscal da Depreciação para tabela custos anuais
     *
     * @param AtivoFisico $ativo_fisico
     * @param int $ano
     * @return float
     */
    private function getBeneficioFiscalDepreciacao($ativo_fisico, $ano)
    {
        $anoFinalRegraDepreciacao = $ativo_fisico->ano_aquisicao + $ativo_fisico->anos_depreciar;

        if($ano > $anoFinalRegraDepreciacao){
            return 0;

        }else{
            return round(($ativo_fisico->regra_depreciacao / 100) * $ativo_fisico->valor_ativo *  (Auth::user()->empresa->aliquota / 100), 2);

        }
    }

    /**
     * Método que pega as melhorias informada em capex para tabela custos anuais
     *
     * @param Capex $capex
     * @param int $ano
     * @return float
     */
    private function getMelhoria($capex, $ano){
        $melhorias_reformas = json_decode($capex->melhorias_reformas);

        $getIndexAno = array_search($ano, $melhorias_reformas->melhorias_reformas_ano);
        
        if($getIndexAno !== false){
            $valor_formatado = preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".",$melhorias_reformas->melhorias_reformas_valor[$getIndexAno]));

            return $valor_formatado;

        }else{
            return 0;
        }
    }

    /**
     * Metodo calcula o custo da perda do valor de capex para tabela custos anuais
     *
     * @param AtivoFisico $ativo_fisico
     * @param int $ano
     * @return float
     */
    private function getCustoPerdaValor($ativo_fisico, $ano)
    {
        $validacao = $ativo_fisico->ano_aquisicao + 1;

        if($validacao == $ano){
            return round($ativo_fisico->valor_ativo - Session::get('valor_revenda'), 2);

        }else{
            return round(Session::get('valor_revenda_anterior') - Session::get('valor_revenda'), 2);

        }
    }

    /**
     * Metodo calcula o valor de revenda de capex para tabela custos anuais
     *
     * @param AtivoFisico $ativo_fisico
     * @param int $ano
     * @return float
     */
    private function getValorRevenda($ativo_fisico, $ano)
    {
        $validacao = $ativo_fisico->ano_aquisicao + 1;

        $calculo = $ativo_fisico->valor_ativo - ($ativo_fisico->taxa_perda_ano / 100) * $ativo_fisico->valor_ativo;

        if($validacao == $ano){
            $calculo = $ativo_fisico->valor_ativo - ($ativo_fisico->taxa_perda_ano / 100) * $ativo_fisico->valor_ativo;

            Session::put('valor_revenda', $calculo);
            
            return round($calculo, 2);
        }else{
            $novoValor = Session::get('valor_revenda');

            $calculo = $novoValor - ($ativo_fisico->taxa_perda_ano / 100) * $novoValor;

            Session::put('valor_revenda_anterior', Session::get('valor_revenda'));
            Session::put('valor_revenda', $calculo);

            return round($calculo, 2);
        }
    }

    /**
     * Metodo calcula o total do ano custo capital e custo operacional de capex e opex para tabela custos anuais
     *
     * @param float $totalAnoCustoCapital
     * @param float $totalAnoCustoOperacional
     * @return float
     */
    private function getTotalCapexOpex($totalAnoCustoCapital, $totalAnoCustoOperacional)
    {
        return $totalAnoCustoCapital + $totalAnoCustoOperacional;
    }

    /**
     * Metodo calcula o total do ano custo operacional de opex para tabela custos anuais
     *
     * @param float $operacao
     * @param float $manutencaoPlanejada
     * @param float $manutencaoNaoPlanejada
     * @return void
     */
    private function getTotalAnoCustoOperacional($operacao, $manutencaoPlanejada, $manutencaoNaoPlanejada)
    {
        return $operacao + $manutencaoPlanejada + $manutencaoNaoPlanejada;
    }

    /**
     * Método que pega os valores totais de manutencao nao planejada de capex
     *
     * @param Opex $opex
     * @param int $index
     * @return float
     */
    private function getManutencaoNaoPlanejada($opex, $index)
    {
        return floatval(preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".", $opex->total_manutencao_n_planejada)[$index]));
    }

    /**
     * Método que pega os valores totais de manutencao planejada de capex
     *
     * @param Opex $opex
     * @param int $index
     * @return float
     */
    private function getManutencaoPlanejada($opex, $index)
    {
        return floatval(preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".", $opex->total_manutencao_planejada)[$index]));
    }

    /**
     * Método que pega os valores totais de operacao de capex
     *
     * @param Opex $opex
     * @param int $index
     * @return float
     */
    private function getOperacao($opex, $index)
    {        
        return floatval(preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".", $opex->total_operacao)[$index]));
    }

    /**
     * Metodo calcula o total do ano custo de capital de capex para tabela custos anuais
     *
     * @param float $custoPerdaValor
     * @param float $custoOportunidade
     * @param float $melhoria
     * @param float $beneficioFiscalDepreciacao
     * @return float
     */
    private function getTotalAnoCustoCapital($custoPerdaValor, $custoOportunidade, $melhoria, $beneficioFiscalDepreciacao)
    {
       return ($custoPerdaValor + $custoOportunidade + $melhoria + $beneficioFiscalDepreciacao);
    }

    /**
     * Método que calcula o valor de opoturnidade para tabela de capex
     *
     * @param Estudo $estudo
     * @return floar
     */
    private function getCustoOportunidade($estudo)
    {
        return round(($estudo->tma / 100) * Session::get('valor_revenda'), 2);
    }

    /**
     * Método que calcula a formula do excel PGTO
     *
     * @param float $taxa
     * @param int $nper
     * @param float $vp
     * @param integer $vf
     * @param integer $tipo
     * @return float
     */
    private function calcularPGTO($taxa, $nper, $vp, $vf = 0, $tipo = 0) {
        if ($taxa != 0) {
            // Fórmula do pagamento periódico (PMT)
            $pmt = ($vp * $taxa) / (1 - pow(1 + $taxa, -$nper)) + ($vf * $taxa) / pow(1 + $taxa, $nper);
        } else {
            // Caso a taxa seja 0, o pagamento é o valor presente mais o valor futuro dividido pelos períodos
            $pmt = -($vp + $vf) / $nper;
        }
    
        // Ajusta o pagamento caso seja feito no início do período
        if ($tipo == 1) {
            $pmt /= (1 + $taxa);
        }
    
        return round($pmt, 2);
    }

    /**
     * Método que calcula a formula do excel VP
     *
     * @param float $taxa
     * @param int $nper
     * @param float $pgto
     * @param integer $vf
     * @param integer $tipo
     * @return float
     */
    private function calcularVP($taxa, $nper, $pgto, $vf = 0, $tipo = 0) {
        if ($taxa != 0) {
            // Fórmula do Valor Presente (PV)
            $vp = ($pgto * (1 - pow(1 + $taxa, -$nper)) / $taxa) + ($vf / pow(1 + $taxa, $nper));
        } else {
            // Caso a taxa seja 0, o VP é o pagamento multiplicado pelo número de períodos
            $vp = -($pgto * $nper + $vf);
        }
    
        // Ajusta o valor presente caso o pagamento seja feito no início do período
        if ($tipo == 1) {
            $vp *= (1 + $taxa);
        }
    
        return round($vp, 2);
    }

    public function gerarRelatorio($id)
    {
        $estudo = Estudo::findOrFail($id);
        $cae = CustosAnuaisEquivalentes::where('estudo_id', '=', $id)->first();
        $ativo = $estudo->ativo_fisico;
        $capex = $estudo->capex;
        $opex = $estudo->opex;
        
        $checaRelatorioGerar = $this->checaRelatorioGerar($cae);

        switch ($checaRelatorioGerar) {
            case 1:
                $relatorio = Documento::where('tipo_documento', '=', 'positivo')->first();

                break;

            case 2:
                $relatorio = Documento::where('tipo_documento', '=', 'nulo')->first();
                break;

            case 0:
                $relatorio = Documento::where('tipo_documento', '=', 'negativo')->first();
                break;
        }

        try {
            $relatorio = $this->extrairVariaveis($relatorio, $cae, $estudo, $ativo, $capex, $opex);
            $caminhoRelatorio = $this->gerarPdf($relatorio, $estudo);

        } catch (\Throwable $th) {
            return redirect("/estudo/curva_anual_equivalente/$opex->estudo_id")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');
        }
        
        return redirect($caminhoRelatorio);
    }

    public function extrairVariaveis($relatorio, $cae, $estudo, $ativo, $capex, $opex)
    {
        $ano_posterior_menor_cae = key(json_decode($cae->menor_valor_cae)) + 1;
        $ano_menor_cae = key(json_decode($cae->menor_valor_cae));

        $texto = $relatorio->documento;

        $palavras = [
            "{{nome_ativo}}", 
            "{{data_relatorio}}", 
            "{{ano_posterior_menor_cae}}", 
            "{{ano_estudo}}",
            "{{ano_menor_cae}}",
            "{{valores_entrada}}",
            "{{valor_aquisicao_instalacao_comissionamento}}",
            "{{melhorias_reformas}}",
            "{{opex}}",
            "{{cae}}",
            "{{valor_revenda_ano_estudo}}",
            "{{nome_empresa}}"
        ];

        $substitutos = [
            $ativo->nome_ativo, 
            date('d/m/Y H:i'), 
            $ano_posterior_menor_cae, 
            date('Y'),
            $ano_menor_cae,
            $this->getValoresEntrada($ativo, $estudo),
            $this->getValorAquisicaoInstalacaoComissionamento($ativo),
            $this->getMelhoriasReformas($capex),
            $this->getOpex($opex, $ativo),
            $this->getCAE($cae, $ativo),
            $this->getValorRevendaAnoEstudo($estudo),
            $this->getNomeEmpresa($estudo)
        ];

        $novoTexto = str_ireplace($palavras, $substitutos, $texto);

        return $novoTexto;   
    }

    private function getNomeEmpresa($estudo)
    {
        return $estudo->user->empresa->nome ?? null;
    }

    private function getValorRevendaAnoEstudo($estudo)
    {
        $anoEstudo = date('Y', strtotime($estudo->created_at));

        $calculos = (array)json_decode($estudo->custo_anual->calculos);

        return "R$" . number_format($calculos[$anoEstudo]->capex->valor_revenda, 2,",",".");
    }

    private function getCAE($cae, $ativo)
    {
        $calculos = json_decode($cae->calculos);
        $anosCae = "[";
        $custoAnualEquivalente = "[";

        foreach ($calculos as $ano => $calculo) {
            if($ativo->ano_aquisicao != $ano){
                $minValue[] = $calculo->custo_anual_equivalente;
                
                if ($calculo === end($calculos)) {
                    $anosCae .= $ano;
                    $custoAnualEquivalente .= $calculo->custo_anual_equivalente;
                    
                }else{
                    $anosCae .= $ano . ", ";
                    $custoAnualEquivalente .= $calculo->custo_anual_equivalente . ", ";

                }
            }
        }

        $anosCae .= "]";
        $custoAnualEquivalente .= "]";

        $minValue = min($minValue);

        $arrayAnosCae = json_decode($anosCae);

        $indexMenorAno = array_search(key(json_decode($cae->menor_valor_cae)), $arrayAnosCae);

        $src = "https://quickchart.io/chart?width=500&height=300&chart={
            type:'line',
            data:{
                labels:$anosCae, 
                datasets:[{
                    label:'C.A.E',
                    fill:false,
                    data:$custoAnualEquivalente,
                    pointBackgroundColor: function(context) {
                        return context.dataIndex === $indexMenorAno ? 'rgb(242 142 42)' : 'rgb(79 121 167)';
                    },
                    pointBorderColor: 'transparent',
                    pointBorderWidth: 1,
                    pointRadius: 3, 
                },
                {
                    label:'Ano de Geração do Maior Valor',
                    fill:false,
                    backgroundColor: 'yellow',
                    pointBorderColor: 'transparent',
                    pointBorderWidth: 1,
                    pointRadius: 3,
                }]
            },
            options:{
                scales:{
                    xAxes:[{
                        type:'category',
                        ticks:{
                            autoSkip:false,
                            fontSize:7
                        }
                    }],
                    yAxes:[{
                        ticks:{
                            suggestedMin: $minValue,
                            fontSize:7
                        }
                    }]
                },
                plugins: {
                    tickFormat: {
                        prefix: 'R$ ',
                        locale: 'pt-BR',
                    },
                }
            }
        }";

        $cae = '<img src="'.$src.'" />';

        return $cae;
    }

    private function getOpex($opex, $ativo)
    {
        $html = '<table class="table table-default table-default-sm table-responsive">
                    <thead>
                        <tr>
                            <td style="width:8%" rowspan="2">Ano</td>
                            <td style="width:8%" colspan="3">Operação</td>
                            <td style="width:8%" colspan="3">Manutenção planejada</td>
                            <td style="width:8%" colspan="3">Manutenção não planejada</td>
                        </tr>
                        <tr>
                            <td style="width:8%">Operadores</td>
                            <td style="width:8%">Energia</td>
                            <td style="width:8%">Total</td>
                            <td style="width:8%">Mantenedores</td>
                            <td style="width:8%">Materiais/ Serviços</td>
                            <td style="width:8%">Total</td>
                            <td style="width:8%">Mantenedores</td>
                            <td style="width:8%">Materiais/ Serviços</td>
                            <td style="width:8%">Total</td>
                        </tr>
                    </thead>
                <tbody>';

        $cont = 0;
        $ano_atual = date('Y');

        for($i=$ativo->ano_aquisicao; $i <= $ano_atual; $i++){
            $array[$i] = [
                'ano' => json_decode($opex->ano)[$cont] ?? "",
                'operadores' => json_decode($opex->operadores)[$cont] ?? "",
                'energia' => json_decode($opex->energia)[$cont] ?? "",
                'total_operacao' => json_decode($opex->total_operacao)[$cont] ?? "",
                'mantenedores_manutencao_planejada' => json_decode($opex->mantenedores_manutencao_planejada)[$cont] ?? "",
                'materiais_servicos_manutencao_planejada' => json_decode($opex->materiais_servicos_manutencao_planejada)[$cont] ?? "",
                'total_manutencao_planejada' => json_decode($opex->total_manutencao_planejada)[$cont] ?? "",
                'mantenedores_manutencao_n_planejada' => json_decode($opex->mantenedores_manutencao_n_planejada)[$cont] ?? "",
                'materiais_servicos_manutencao_n_planejada' => json_decode($opex->materiais_servicos_manutencao_n_planejada)[$cont] ?? "",
                'total_manutencao_n_planejada' => json_decode($opex->total_manutencao_n_planejada)[$cont] ?? "",
                'taxa_inflacao' => json_decode($opex->taxa_inflacao)[$cont] ?? "",
            ];

            $html .= '<tr class="trAno" id="trAno{{ $i }}">
                        <td>'. $i  .'</td>
                        <td>R$ '. $array[$i]['operadores'] .'</td>
                        <td>R$ '. $array[$i]['energia']  .'</td>
                        <td>R$ '. $array[$i]['total_operacao'] . '</td>
                        <td>R$ '. $array[$i]['mantenedores_manutencao_planejada'] .'</td>
                        <td>R$ '. $array[$i]['materiais_servicos_manutencao_planejada'] .'</td>
                        <td>R$ '. $array[$i]['total_manutencao_planejada'] .'</td>
                        <td>R$ '. $array[$i]['mantenedores_manutencao_n_planejada'] .'</td>
                        <td>R$ '. $array[$i]['materiais_servicos_manutencao_n_planejada'] .'</td>
                        <td>R$ '. $array[$i]['total_manutencao_n_planejada'] . '</td>
                    </tr>
                    ';

            $cont++;
        }

        $html .= '</tbody>
                        </table>';

        return $html;
    }

    private function getMelhoriasReformas($capex)
    {
        $melhorias_reformas = json_decode($capex->melhorias_reformas);
                                    
        $arrayCheck = max([
            count(json_decode($capex->melhorias_reformas)->melhorias_reformas_ano ?? []),
            count(json_decode($capex->melhorias_reformas)->melhorias_reformas_valor ?? []),
            count(json_decode($capex->melhorias_reformas)->melhorias_reformas_operacao ?? []),
            count(json_decode($capex->melhorias_reformas)->melhorias_reformas_man_n_planejada ?? []),
            count(json_decode($capex->melhorias_reformas)->melhorias_reformas_man_planejada ?? [])
        ]);

        if($melhorias_reformas != null || $arrayCheck != 0){
            $html = '
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ano</th>
                            <th>Valor</th>
                            <th>Operação</tthd>
                            <th>Manut. planejada</th>
                            <th>Manut. não planejada</th>
                        </tr>
                    </thead>
                <tbody>
            ';

            for ($i = 0; $i < $arrayCheck; $i++) {
                if($i == 0 && $melhorias_reformas->melhorias_reformas_valor[$i] == "0,00" && count(json_decode($capex->melhorias_reformas)->melhorias_reformas_valor) == 1){
                    $html .= "<tr><td colspan='5'><i>Não há investimentos Capex feito</i></td></tr></tbody></table>";

                    return $html;
                }

                $html .= "<tr>
                            <td>". $melhorias_reformas->melhorias_reformas_ano[$i] . "</td>
                            <td> R$ " . $melhorias_reformas->melhorias_reformas_valor[$i] . "</td>
                            <td>". $melhorias_reformas->melhorias_reformas_operacao[$i] . "% </td>
                            <td>". $melhorias_reformas->melhorias_reformas_man_planejada[$i]  . "% </td>
                            <td>". $melhorias_reformas->melhorias_reformas_man_n_planejada[$i] . "% </td>
                        </tr>";
            }

            $html .= "</tbody>";
            $html .= "</table>";
            
            return $html;
        }

        return '';
    }

    private function getValorAquisicaoInstalacaoComissionamento($ativo)
    {
        return "R$ " . number_format($ativo->valor_ativo_original + $ativo->custo_instalacao + $ativo->custo_comissionamento , 2,",",".");
    }

    private function getValoresEntrada($ativo, $estudo)
    {
        
        $style = "
            <style>
                /* Estilos de tabela do Bootstrap simplificados */
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 1rem;
                    color: #212529;
                }
                th, td {
                    padding: 0.75rem;
                    vertical-align: top;
                    border: 1px solid #dee2e6;
                }
                thead {
                    background-color: #f8f9fa;
                }
                th {
                    font-weight: bold;
                    text-align: center;
                }
                tbody tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
            </style>
        ";

        $html = $style;
        $html .= "<table class='table'>";
        $html .= "<tbody>";
        $html .= "<tr>";
        $html .=    "<td><b>Ano de Compra:</b></td>";
        $html .=    "<td>" . $ativo->ano_aquisicao . "</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .=    "<td><b>Ano do estudo:</b></td>";
        $html .=    "<td>" . date('Y') . "</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .=    "<td><b>TMA:</b></td>";
        $html .=    "<td>" . $estudo->tma . "%</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .=    "<td><b>Depreciação:</b></td>";
        $html .=    "<td>" . $ativo->regra_depreciacao . "%</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .=    "<td><b>Anos para Depreciar:</b></td>";
        $html .=    "<td>" . $ativo->anos_depreciar . "</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .=    "<td><b>Alíquota do Imposto de Renda:</b></td>";
        $html .=    "<td>" . Auth::user()->empresa->aliquota . "%</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .=    "<td><b>Taxa de Perda de Valor ao Ano:</b></td>";
        $html .=    "<td>" . $ativo->taxa_perda_ano . "%</td>";
        $html .= "</tr>";
        $html .= "</tbody>";
        $html .= "</table>";
        
        return $html;
    }

    public function gerarPdf($relatorio, $estudo)
    {        
        $nomeArquivo = md5('estudo ID:' . $estudo->id) . ".pdf";

        $estudo->nome_relatorio = $nomeArquivo;

        $estudo->save();

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($relatorio);

        if (!is_dir(public_path('relatorios'))) {
            mkdir(public_path('relatorios'), 0755, true);
        }

        $caminhoPdf = public_path("relatorios/$nomeArquivo");

        $mpdf->Output($caminhoPdf, \Mpdf\Output\Destination::FILE);
        
        if(file_exists("relatorios/" . $nomeArquivo)){
            return "relatorios/" . $nomeArquivo;

        }else if(file_exists("public/relatorios/" . $nomeArquivo)){
            return "public/relatorios/" . $nomeArquivo;
        }
    }

    private function gerarMenorCae($cae)
    {
        $calculos = json_decode($cae->calculos);

        $menorValor = null;

        foreach ($calculos as $ano => $info) {
            if ($menorValor === null || $info->custo_anual_equivalente < $menorValor) {
                if($info->custo_anual_equivalente != 0){
                    $menorValor = $info->custo_anual_equivalente;
                    $menorAno = $ano;

                }
            }
        }

        $cae->menor_valor_cae = json_encode([$menorAno => $menorValor]);

        $cae->save();
    }

    private function checaRelatorioGerar($cae)
    {        
        if($cae->menor_valor_cae == null){
            $this->gerarMenorCae($cae);
        }

        $menor_valor_cae = json_decode($cae->menor_valor_cae);
        $ano_atual = date('Y');

        if((key($menor_valor_cae) + 1) == $ano_atual){
            // echo 'relatorio null';
            return 2;

        }else if((key($menor_valor_cae) + 1) > $ano_atual){
            // echo 'relatorio positivo';
            return 1;

        }else if((key($menor_valor_cae) + 1) < $ano_atual){
            // echo 'relatorio negativo';
            return 0;

        }
    }

    public function visualizarRelatorio($id)
    {
        $estudo = Estudo::findOrFail($id);

        if($estudo->user->empresa_id != Auth::user()->empresa_id && Auth::user()->nivel_acesso->nome != 'Master' ){
            return redirect("/ativos_fisicos")->with("error", 'Não é possível visualizar este estudo, o estudo não pertence a sua empresa');
        }

        $nomeRelatorio = $estudo->nome_relatorio;

        $caminhoRelatorio = $this->verificaRelatorio($nomeRelatorio);

        if(!$caminhoRelatorio){
            return redirect("/estudo/curva_anual_equivalente/$estudo->id?status=2" )->with("error", 'Relátório não encontrado, tente novamente mais tarde');

        }

        return view('estudo.visualizar_relatorio',[
            'estudo' => $estudo,
            'titulo_pagina' => 'Relátorio',
            'caminho_relatorio' => $caminhoRelatorio,
            'timeline' => 5,
            'timeline_card_style_5' => 'timeline-card-5',
            'timeline_bottom_style_5' => 'timeline-bottom-5'
        ]);
    }

    private function verificaRelatorio($nomeRelatorio)
    {
        if(file_exists("relatorios/$nomeRelatorio")){
            return url("relatorios/$nomeRelatorio");

        }else if(file_exists("public/relatorios/$nomeRelatorio")){
            return url("public/relatorios/$nomeRelatorio");

        }else{
            return false;

        }
    }
}
