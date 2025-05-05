<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $cnpj
 * @property string|null $cidade
 * @property string|null $estado
 * @property float|null $tma
 * @property float|null $aliquota
 * @property string|null $nome_contato_tecnico
 * @property string|null $email_contato_tecnico
 * @property string|null $telefone_contato_tecnico
 * @property string|null $nome_contato_comercial
 * @property string|null $email_contato_comercial
 * @property string|null $telefone_contato_comercial
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 */
class Empresa extends Model
{
    protected $table = 'empresas';

    use HasFactory;

    public function setValues($model, $request)
    {
        $model->nome                       = $request->nome;
        $model->cnpj                       = $request->cnpj;
        $model->cidade                     = $request->cidade;
        $model->estado                     = $request->estado;
        $model->nome_contato_tecnico       = $request->nome_contato_tecnico;
        $model->email_contato_tecnico      = $request->email_contato_tecnico;
        $model->telefone_contato_tecnico   = $request->telefone_contato_tecnico;
        $model->nome_contato_comercial     = $request->nome_contato_comercial;
        $model->email_contato_comercial    = $request->email_contato_comercial;
        $model->telefone_contato_comercial = $request->telefone_contato_comercial;
        $model->status                     = $request->status;
    }

    static public function filtrar($model, $request)
    {
        if($request->busca != ''){
            $model->where("nome", "LIKE", "%" . $request->busca ."%");
        }

        if($request->status != ''){
            $model->where('status', $request->status);
        }

        return $model;
    }

    public function user_empresa() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
