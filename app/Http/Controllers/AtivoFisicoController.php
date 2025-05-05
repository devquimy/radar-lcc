<?php

namespace App\Http\Controllers;

use App\Models\AtivoFisico;
use App\Models\Capex;
use App\Models\Empresa;
use App\Models\Estudo;
use App\Models\Opex;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AtivoFisicoController extends Controller
{

    public function index()
    {                
        if(Auth::user()->nivel_acesso->nome == 'Usuário' || Auth::user()->nivel_acesso->nome == 'Administrador'){
            $ativos_fisicos = AtivoFisico::
            whereHas('estudos', function ($query) {
                $users = User::where('empresa_id', Auth::user()->empresa->id)
                    ->pluck('id')
                    ->toArray();
                $query->whereIn('estudos.user_id', $users);
                $query->orWhere('estudos.user_id',  '=', Auth::user()->id);
            })
            ->paginate(8);

        }else{
            $empresaID = request()->query('empresa_id');

            $query = AtivoFisico::query();
            
            if (!empty($empresaID)) {
                $query->whereHas('estudos.user.empresa', function ($q) use ($empresaID) {
                    $q->where('id', $empresaID);
                });          
            }
            
            $ativos_fisicos = $query->paginate(8);
        }        
        $empresas = Empresa::whereNotNull('cnpj')->pluck('nome', 'id');

        return view("ativo_fisico.index",[
            'titulo_pagina' => "Ativos Físicos",
            'ativos_fisicos' => $ativos_fisicos,
            'empresas' => $empresas
        ]);
    }

    public function create()
    {
        if(Auth::user()->nivel_acesso->nome != 'Master'){
            $opex = new OpexController;
            $verificaCreditos = $opex->verificaCreditos();

            if(!$verificaCreditos){
                return redirect("/ativos_fisicos")->with("error", 'Não é possível realizar um novo estudo, você não possui créditos disponíveis para esta ação');

            }
        }

        return view("ativo_fisico.create",[
            'titulo_pagina' => "Ativos Físicos",
            'timeline' => 1,
            'timeline_card_style_1' => 'timeline-card-1',
            'timeline_bottom_style_1' => 'timeline-bottom-1'
        ]);
    }

    public function store(Request $request)
    {
        $estudo = new Estudo();
        $estudo->save();

        $ativo_fisico = new AtivoFisico();
        $ativo_fisico->setValues($ativo_fisico, $request);

        if($request->aliquota){
            $empresa = Empresa::findOrFail(Auth::user()->empresa_id);
            
            $empresa->aliquota = $request->aliquota;

            $empresa->save();
        }

        try {
            $ativo_fisico->save();

            $capex_id = $this->criarCapexOpex($ativo_fisico, $estudo);

        } catch (\Throwable $th) {
            return redirect("/ativos_fisicos")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        return redirect("/capex/edit/$capex_id")->with("success", 'Ativo fisíco cadastrado com sucesso');
    }

    public function criarNovoEstudo(Request $request)
    {
        if(Auth::user()->nivel_acesso->nome != 'Master'){
            $opex = new OpexController;
            $verificaCreditos = $opex->verificaCreditos();

            if(!$verificaCreditos){
                return redirect("/ativos_fisicos")->with("error", 'Não é possível realizar um novo estudo, você não possui créditos disponíveis para esta ação');
            }
        }

        $estudo = new Estudo();
        $estudo->save();

        $ativo_fisico = AtivoFisico::findOrFail($request->ativo_fisico_id);

        try {
            $ativo_fisico->save();

            $capex_id = $this->criarCapexOpex($ativo_fisico, $estudo, true, true);

        } catch (\Throwable $th) {
            return redirect("/ativos_fisicos")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        return redirect("/capex/edit/$capex_id")->with("success", 'Ativo fisíco cadastrado com sucesso');
    }

    private function criarCapexOpex($ativo_fisico, $estudo, $herdarCapex = false, $herdarOpex = false)
    {        
        $capex = new Capex();
        $opex = new Opex();

        $capex->ativo_fisico_id = $ativo_fisico->id;
        $capex->estudo_id = $estudo->id;
        $capex->motivo_escolha_ativo_fisico = $_POST['motivo_escolha_ativo_fisico'] ?? null;

        if($herdarCapex == true){
            $capexAntigo = Capex::where('ativo_fisico_id', '=', $ativo_fisico->id)->get()->last();

            $capex->melhorias_reformas = $capexAntigo->melhorias_reformas;
            $capex->atualizacao_patrimonial = $capexAntigo->atualizacao_patrimonial;
        }

        if($herdarOpex)
        {
            $opexAntigo = $ativo_fisico->estudos->last()->opex;

            $opex->ano = $opexAntigo->ano;
            $opex->operadores = $opexAntigo->operadores;;
            $opex->energia = $opexAntigo->energia;
            $opex->total_operacao = $opexAntigo->total_operacao;
            $opex->mantenedores_manutencao_planejada = $opexAntigo->mantenedores_manutencao_planejada;;
            $opex->materiais_servicos_manutencao_planejada = $opexAntigo->materiais_servicos_manutencao_planejada;
            $opex->total_manutencao_planejada = $opexAntigo->total_manutencao_planejada;
            $opex->mantenedores_manutencao_n_planejada = $opexAntigo->mantenedores_manutencao_n_planejada;
            $opex->materiais_servicos_manutencao_n_planejada = $opexAntigo->materiais_servicos_manutencao_n_planejada;
            $opex->total_manutencao_n_planejada = $opexAntigo->total_manutencao_n_planejada;
            $opex->taxa_inflacao = $opexAntigo->taxa_inflacao;
            $opex->fator_multiplicador_sugerido = $opexAntigo->fator_multiplicador_sugerido;
        }

        $capex->save();

        $opex->estudo_id = $estudo->id;
        $opex->save();

        $estudo->ativo_fisico_id = $ativo_fisico->id;
        $estudo->capex_id = $capex->id;
        $estudo->opex_id = $opex->id;
        $estudo->tma = $_POST['tma'] ?? null;
        $estudo->user_id = Auth::user()->id;
        $estudo->save();
        
        return $capex->id;
    }

    public function edit($id, $estudo_id = null)
    {
        $ativo_fisico = AtivoFisico::findOrFail($id);
        $estudo = Estudo::findOrFail($estudo_id);
        $capex = Capex::findOrFail($estudo->capex_id);

        if($estudo->user->empresa_id != Auth::user()->empresa_id && Auth::user()->nivel_acesso->nome != 'Master' ){
            return redirect("/ativos_fisicos")->with("error", 'Não é possível visualizar este estudo, o estudo não pertence a sua empresa');
        }

        return view("ativo_fisico.edit",[
            'titulo_pagina' => 'Editar Ativo Físico',
            "ativo_fisico" => $ativo_fisico,
            'estudo' => $estudo,
            'aliquota_empresa' => $estudo->user->empresa->aliquota,
            'capex' => $capex,
            'timeline' => 1,
            'timeline_card_style_1' => 'timeline-card-1',
            'timeline_bottom_style_1' => 'timeline-bottom-1'
        ]);
    }

    public function update(Request $request, $id)
    {
        $ativo_fisico = AtivoFisico::findOrFail($id);      
        $ativo_fisico->setValues($ativo_fisico, $request);

        $capex = Capex::findOrFail($request->capex_id);
        $capex->motivo_escolha_ativo_fisico = $request->motivo_escolha_ativo_fisico;

        if($request->aliquota){
            $empresa = Empresa::findOrFail(Auth::user()->empresa_id);
            
            $empresa->aliquota = $request->aliquota;

            $empresa->save();
        }
        
        try {
            $ativo_fisico->save();
            $capex->save();

        } catch (\Throwable $th) {
            return redirect("/ativos_fisicos")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        if($request->estudo_id == null){           
            return redirect("/capex/edit/" . $ativo_fisico->capex->last()->id)->with("success", 'Ativo fisíco salvo com sucesso');

        }else{
            $estudo = Estudo::findOrFail($request->estudo_id);
            $estudo->tma = $request->tma;
            
            $estudo->save();

            return redirect("/capex/edit/" . $estudo->capex_id)->with("success", 'Ativo fisíco salvo com sucesso');

        }
    }

    public function delete($id)
    {
        $ativo_fisico = AtivoFisico::findOrFail($id);

        foreach($ativo_fisico->estudos()->get() as $estudo){

            try {
                DB::beginTransaction();

                $estudo->delete();

                DB::commit();

            } catch (\Throwable $th) {
                DB::rollBack();

                return redirect("/ativos_fisicos")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');
            }
        }

        return redirect("/ativos_fisicos")->with("success", 'Ativo Físico deletado com sucesso');
    }
}
