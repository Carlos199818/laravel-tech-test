<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'tblarticulo';
    protected $primaryKey = 'articulo_id';
    public $timestamps = true;

    protected $fillable = [
        'codigo_barra',
        'descripcion',
        'fabricante',
    ];

    public function placements()
    {
        return $this->hasMany(Placement::class, 'articulo_id', 'articulo_id');
    }

}
