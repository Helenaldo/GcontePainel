<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $fillable = [
        'nome',
        'data',
        'cliente_id',
    ];

   // Várias categorias tem um cliente
   public function cliente() {
    return $this->belongsTo(Cidade::class);
}
}

