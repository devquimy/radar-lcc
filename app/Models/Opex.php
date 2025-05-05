<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opex extends Model
{
    use HasFactory;

    protected $table = 'opex';

    public function estudo() {
        return $this->belongsTo('App\Models\Estudo');
    }
}
