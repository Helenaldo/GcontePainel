<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CnpjValidationRule implements Rule
{
    public function passes($attribute, $cnpj)
    {
        // Remove caracteres não numéricos
        $cnpj = preg_replace('/\D/', '', $cnpj);

        // Verifica se a string possui exatamente 14 caracteres
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica a existência de uma sequência de dígitos idênticos (CNPJ inválido)
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Obtém a base do CNPJ sem os dígitos verificadores
        $baseCnpj = substr($cnpj, 0, 12);

        // Acrescenta os dígitos verificadores calculados
        $digitosVerificadoresCalculados = self::calcularDigitoVerificador($baseCnpj, 1);
        $digitosVerificadoresCalculados .= self::calcularDigitoVerificador($baseCnpj . $digitosVerificadoresCalculados, 2);

        // Compara o CNPJ fornecido com o CNPJ calculado
        return $baseCnpj . $digitosVerificadoresCalculados == $cnpj;
    }

    public function message()
    {
        return 'O CNPJ informado não é válido.';
    }

    private static function calcularDigitoVerificador($base, $posicao)
    {
        $tamanho = strlen($base);
        $multiplicadores = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        if ($posicao === 2) {
            array_unshift($multiplicadores, 6);
        }

        $soma = 0;
        for ($i = 0; $i < $tamanho; $i++) {
            $soma += $base[$i] * $multiplicadores[$i];
        }

        $resultado = 11 - $soma % 11;
        return $resultado > 9 ? 0 : $resultado;
    }
}
