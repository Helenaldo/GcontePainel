<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = [
        'tipo_identificacao',
        'cpf_cnpj',
        'nome',
        'fantasia',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'complemento',
        'cidade_id',
        'data_entrada',
        'data_saida',
        'tipo', // Matriz ou Filial
    ];

    // Vários clientes tem uma cidade
    public function cidade() {
        return $this->belongsTo(Cidade::class);
    }

    // várias tem cliente tem vários tribvutações
    public function tributaoes() {
        return $this->hasMany(Tributacao::class);
    }

    // Uma cliente tem várias categorias
    public function categorias() {
        return $this->hasMany(Categoria::class);
    }

    // Uma cliente tem vários estabelecimentos
    // public function estabelecimentos() {
    //     return $this->hasMany(Estabelecimento::class);
    // }

    // Um Cliente tem vários contatos
    public function contatos() {
        return $this->hasMany(Contato::class);
    }

    // Um Cliente tem vários processos
    public function processos() {
       return $this->hasMany(Processo::class);
    }
}
