<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;
    protected $table = 'contatos';
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cliente_id',
    ];

    // Vários contatos tem um cliente
    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }
}
