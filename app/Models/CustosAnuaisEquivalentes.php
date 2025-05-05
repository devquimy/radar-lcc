<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustosAnuaisEquivalentes extends Model
{
    use HasFactory;

    protected $table = 'custos_anuais_equivalentes';

    public function estudo() {
        return $this->belongsTo('App\Models\Estudo');
    }
}
