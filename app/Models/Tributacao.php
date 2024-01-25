<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tributacao extends Model
{
    use HasFactory;
    protected $table = 'tributacoes';
    protected $fillable = [
        'tipo',
        'data',
        'cliente_id',
    ];

    // Vários clientes tem várias tributações
    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }
}
