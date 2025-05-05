<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string|null $motivo_escolha_ativo_fisico
 * @property string|null $atualizacao_patrimonial
 * @property string|null $melhorias_reformas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $ativo_fisico_id
 */
class Capex extends Model
{
    use HasFactory;

    protected $table = 'capex';

    public function ativo_fisico() {
        return $this->belongsTo('App\Models\AtivoFisico');
    }

    public function estudo() {
        return $this->belongsTo('App\Models\Estudo');
    }
}
