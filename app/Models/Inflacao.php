<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int|null $ano
 * @property string|null $inflacao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Inflacao extends Model
{
    use HasFactory;

    protected $table = 'inflacoes';

    protected $fillable = [
        'ano',
        'inflacao',
    ];
}
