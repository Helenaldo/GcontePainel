<?php

namespace App\Http\Requests;

use App\Rules\CidadeExiste;
use App\Rules\CleanCepRule;
use App\Rules\CnpjValidationRule;
use App\Rules\CpfValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{

    public function rules(): array
    {

        return [
            'tipo_identificacao' => 'string|required|in:cpf,cnpj',


            'cpf_cnpj' => [
                'required',
                'unique:clientes,cpf_cnpj',
                'string',
                function ($attribute, $value, $fail) {
                    if ($this->input('tipo_identificacao') === 'cpf') {
                        $rule = new CpfValidationRule;
                        if ($rule->passes($attribute, $value, $fail)) {
                            return;
                        }
                    } elseif ($this->input('tipo_identificacao') === 'cnpj') {
                        $rule = new CnpjValidationRule;
                        if ($rule->passes($attribute, $value, $fail)) {
                            return;
                        }
                    }

                    $fail("O campo $attribute não pôde ser validado.");
                },
            ],

            'nome' => 'string|required',
            'fantasia' => 'string|nullable',
            'cep' => ['string', 'nullable', new CleanCepRule],
            'logradouro' => 'string|nullable',
            'numero' => 'string|nullable',
            'bairro' => 'string|nullable',
            'complemento' => 'string|nullable',
            'cidade_id' => ['string', 'nullable', new CidadeExiste],
            'data_entrada' => 'date|nullable',
            'data_saida' => 'date|nullable',
            'tipo' => 'string|nullable|in:matriz,filial',
        ];

    }
}
