<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoMov extends Model
{
    use HasFactory;
    protected $table = 'processos_mov';
    protected $fillable = [
        'user_id',
        'processo_id',
        'data',
        'descricao',
        'anexo'
    ];

    // Vários Movimentos tem um usuário
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function processo() {
        return $this->belongsTo(Processo::class);
    }
}
