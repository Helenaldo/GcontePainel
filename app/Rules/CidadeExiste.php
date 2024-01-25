<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Cidade;

class CidadeExiste implements Rule
{
    public function passes($attribute, $value)
    {

        return Cidade::where('id', $value)->exists();
    }

    public function message()
    {
        return 'A cidade selecionada não existe na base de dados do IBGE.';
    }
}
