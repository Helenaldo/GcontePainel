<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;
    protected $table = 'cidades';
    protected $fillable = [
        'municipio',
        'cod_municipio',
        'UF',
        'cod_UF',
        'regiao'
    ];

    // Uma cidade tem vários clientes
    public function cliente() {
        return $this->hasMany(Cliente::class);
    }
}
