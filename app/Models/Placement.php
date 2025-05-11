<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    protected $table = 'tblcolocacion';
    protected $primaryKey = 'colocacion_id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'precio',
        'articulo_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'articulo_id', 'articulo_id');
    }
}
