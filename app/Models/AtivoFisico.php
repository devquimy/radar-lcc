<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string|null $setor_tag
 * @property string|null $nome_ativo
 * @property int|null $ano_aquisicao
 * @property int|null $expectativa_vida
 * @property int|null $regra_depreciacao
 * @property int|null $taxa_perda_ano
 * @property float|null $valor_ativo
 * @property float|null $custo_instalacao
 * @property float|null $custo_comissionamento
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $cod_ativo_fisico
 * @property int|null $anos_depreciar
 * @property float|null $valor_depreciacao
 */
class AtivoFisico extends Model
{
    use HasFactory;

    protected $table = 'ativos_fisicos';

    protected $appends = [
        'quantidade_estudos',
    ];

    public function estudos()
    {
        return $this->hasMany(Estudo::class);
    }

    public function getQuantidadeEstudosAttribute()
    {
        $quantidadeEstudos = Estudo::select('id')
            ->where('ativo_fisico_id' , '=', $this->id)
            ->count();

        return $quantidadeEstudos ?? 0;
    }

    public function setValues($model, $request)
    {
        $model->setor_tag             = $request->setor_tag ?? $model->setor_tag;
        $model->nome_ativo            = $request->nome_ativo ?? $model->nome_ativo;
        $model->ano_aquisicao         = $request->ano_aquisicao ?? $model->ano_aquisicao;
        $model->ano_inicio_operacao   = $request->ano_inicio_operacao ?? $model->ano_inicio_operacao;
        $model->expectativa_vida      = $request->expectativa_vida ?? $model->expectativa_vida;
        $model->regra_depreciacao     = $request->regra_depreciacao ?? $model->regra_depreciacao;
        $model->taxa_perda_ano        = $request->taxa_perda_ano ?? $model->taxa_perda_ano;
        $model->valor_ativo_original  = ($request->valor_ativo_original) ? preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".",$request->valor_ativo_original)) : $model->valor_ativo_original;
        $model->valor_ativo           = ($request->valor_ativo) ? preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".",$request->valor_ativo)) : $model->valor_ativo;
        $model->custo_instalacao      = ($request->custo_instalacao) ? preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".",$request->custo_instalacao)) : $model->custo_instalacao;
        $model->custo_comissionamento = ($request->custo_comissionamento) ? preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".",$request->custo_comissionamento)): $model->custo_comissionamento;
        $model->cod_ativo_fisico      = $request->cod_ativo_fisico ?? $model->cod_ativo_fisico;
        $model->anos_depreciar        = $request->anos_depreciar ?? $model->anos_depreciar;
        $model->valor_depreciacao     = ($request->valor_depreciacao) ? preg_replace("/[\,\.](\d{3})/", "$1", str_replace(",", ".",$request->valor_depreciacao)) : $model->valor_depreciacao;
    }

    public function capex() {
        return $this->hasMany('App\Models\Capex');
    }
}
