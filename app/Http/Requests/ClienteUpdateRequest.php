<?php

namespace App\Http\Requests;

use App\Rules\CidadeExiste;
use App\Rules\CleanCepRule;
use App\Rules\CnpjValidationRule;
use App\Rules\CpfValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ClienteUpdateRequest extends FormRequest
{

    public function rules(): array
    {

        return [

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
