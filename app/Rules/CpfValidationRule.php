<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfValidationRule implements Rule
{
    public function passes($attribute, $cpf)
    {

        // Remova caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $cpf);

        // Verifique se a string tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifique se todos os dígitos são iguais (isso não é um CPF válido)
        if (preg_match('/(\d)\1{13}/', $cpf)) {
            return false;
        }

        //Pega o CPF sem o dígito verificador
        $cpfValidacao = substr($cpf, 0, -2);

        //Concatena com o dígito verificador calculado
        $cpfValidacao .= self::calcularDigitoVerificador($cpfValidacao);
        $cpfValidacao .= self::calcularDigitoVerificador($cpfValidacao);

        //Compara o Cpf enviado com o CNPJ calculado
        return $cpfValidacao == $cpf;

    }

    public function message()
    {
        return 'O CPF informado não é válido.';
    }

    public static function calcularDigitoVerificador($base) {
        $tamanho = strlen($base);
        $multiplicador = $tamanho + 1;
        $soma = 0; //variável que recebe a soma das multiplicações

        //Intera todos os números da base da direita para a esquerda
        for($i = 0; $i < $tamanho; $i++) {
            $soma += $base[$i] * $multiplicador; // Soma atual
            $multiplicador--; // Decrementa o multiplicador
        }
        //Calcula o digito verificador (resto por 11)
        $resto = $soma % 11;
        //Se o resto for 0 ou 1 retorna 0 caso contrário retorna 11 menos o resto
        return ($resto > 1 ? 11 - $resto : 0);
    }
}
