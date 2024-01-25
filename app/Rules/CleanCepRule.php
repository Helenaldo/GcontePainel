<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CleanCepRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Remove todos os caracteres não numéricos do valor
        $cleanedCep = preg_replace('/\D/', '', $value);

        // Atualize o valor do campo CEP para conter apenas números
        request()->merge([$attribute => $cleanedCep]);

        // Verifica se o CEP tem exatamente 8 dígitos após a limpeza
        return strlen($cleanedCep) === 8;

    }

    public function message()
    {
        return 'O campo :attribute deve conter exatamente 8 dígitos numéricos.';
    }
}
