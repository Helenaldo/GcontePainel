<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;
    protected $table = 'processos';
    protected $fillable = [
        'cliente_id',
        'user_id',
        'numero',
        'titulo',
        'status', // em andamento, atrasado, concluído
        'data',
        'prazo',
        'concluido',
    ];

    // Vários Processos tem um cliente
    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    // Vários Processos tem um usuário
    public function user() {
        return $this->belongsTo(User::class);
    }

    //Define a relação com ProcessosMov.
    public function movimentacoes()
    {
        return $this->hasMany(ProcessoMov::class, 'processo_id');
    }
}

