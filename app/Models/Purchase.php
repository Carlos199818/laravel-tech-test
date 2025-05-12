<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'tblcompra';
    protected $primaryKey = 'compra_id';
    public $timestamps = true;

    protected $fillable = [
        'cliente_id',
        'articulo_id',
        'colocacion_id',
        'unidades',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function article()
    {
        return $this->belongsTo(Item::class, 'articulo_id');
    }

    public function placement()
    {
        return $this->belongsTo(Placement::class, 'colocacion_id');
    }
}
