<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessoRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'string|required',
            'user_id' => 'string|required',
            'titulo' => 'string|required',
            'numero' => 'string|nullable',
            'status' => [
                'string',
                'nullable',
                'in:Em andamento,Atrasado,Concluido',
            ],
            'data' => 'date|nullable',
            'prazo' => 'date|nullable',
            'concluido' => $this->getConcluidoRule(),
        ];
    }

     /**
     * Define a regra para o campo "concluido" com base no valor do campo "status".
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected function getConcluidoRule(): array
    {
        $concluidoRule = [
            'nullable',
            'date',
        ];

        // Adiciona a regra 'required' se o status for 'Concluido'
        if ($this->input('status') === 'Concluido') {
            $concluidoRule[] = 'required';
        }

        return $concluidoRule;
    }
}
