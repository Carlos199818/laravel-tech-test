<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'tblclient';
    protected $primaryKey = 'client_id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'telefono',
        'tipo_cliente',
    ];

}
