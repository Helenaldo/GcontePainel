<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CnpjValidationRule implements Rule
{
    public function passes($attribute, $cnpj)
    {

        // Remova caracteres não numéricos
        $cnpj = preg_replace('/\D/', '', $cnpj);


        // Verifique se a string tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifique se todos os dígitos são iguais (isso não é um CNPJ válido)
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        //Pega o CNPJ sem o dígito verificador
        $cnpjValidacao = substr($cnpj, 0, 12);

        //Concatena com o dígito verificador calculado
        $cnpjValidacao .= self::calcularDigitoVerificador($cnpjValidacao);

        $cnpjValidacao .= self::calcularDigitoVerificador($cnpjValidacao);

        //Compara o CNPJ enviado com o CNPJ calculado
        return $cnpjValidacao == $cnpj;

    }

    public function message()
    {
        return 'O CNPJ informado não é válido.';
    }

    public static function calcularDigitoVerificador($base) {
        $tamanho = strlen($base);
        $multiplicador = 9;
        $soma = 0; //variável que recebe a soma das multiplicações

        //Intera todos os números da base da direita para a esquerda
        for($i = ($tamanho - 1); $i >= 0; $i--) {
            $soma += $base[$i] * $multiplicador; // Soma atual
            $multiplicador--; // Decrementa o multiplicador
            $multiplicador = $multiplicador < 2 ? 9 : $multiplicador; // Limita o decremento até 2
        }
        //Calcula o digito verificador (resto por 11)
        return $soma % 11;
    }
}
