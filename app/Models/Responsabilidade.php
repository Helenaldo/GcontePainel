<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsabilidade extends Model
{
    use HasFactory;
    protected $table = 'responsabilidades';
    protected $fillable = [
        'data',
        'cliente_id',
        'contabil',
        'pessoal',
        'fiscal',
        'paralegal',

    ];

    public function userContabil() {
        return $this->belongsTo(User::class, 'contabil');
    }

    public function userPessoal() {
        return $this->belongsTo(User::class, 'pessoal');
    }

    public function userfiscal() {
        return $this->belongsTo(User::class, 'fiscal');
    }

    public function userParalegal() {
        return $this->belongsTo(User::class, 'paralegal');
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

}
