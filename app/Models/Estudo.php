<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudo extends Model
{
    use HasFactory;

    protected $table = 'estudos';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($estudo) {
            $estudo->custo_anual_equivalente()->delete();
            $estudo->valor_presente()->delete();
            $estudo->custo_anual()->delete();
            $estudo->ativo_fisico()->delete();
            $estudo->capex()->delete();
            $estudo->opex()->delete();
        });
    }

    public function ativo_fisico() {
        return $this->belongsTo('App\Models\AtivoFisico');
    }

    public function capex() {
        return $this->belongsTo('App\Models\Capex');
    }

    public function opex() {
        return $this->belongsTo('App\Models\Opex');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function custo_anual_equivalente() {
        return $this->belongsTo('App\Models\CustosAnuaisEquivalentes', 'id', 'estudo_id');
    }

    public function valor_presente() {
        return $this->belongsTo('App\Models\ValorPresente', 'id', 'estudo_id');
    }

    public function custo_anual() {
        return $this->belongsTo('App\Models\CustosAnuais', 'id', 'estudo_id');
    }
}
