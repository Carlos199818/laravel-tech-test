<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'tblcliente';
    protected $primaryKey = 'cliente_id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'telefono',
        'tipo_cliente',
    ];

}
