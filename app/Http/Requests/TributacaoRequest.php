<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TributacaoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $data = $this->all();
        // dd($data);
        return [

            'tipo' => [
                'required',
                'string',
                'in:Lucro Real Anual,Lucro Real Trimestral,Lucro Presumido,Simples Nacional,Pessoa Física',
            ],
            'data' => 'date|required',
            'cliente_id' => 'string|required',
        ];
    }
}


