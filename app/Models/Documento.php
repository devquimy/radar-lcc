<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo('App\Models\User', 'usuario_ultima_edicao_id', 'id');
    }
}
