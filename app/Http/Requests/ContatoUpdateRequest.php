<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContatoUpdateRequest extends FormRequest
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

        $rules = [
            'nome' => 'string|required',
            'telefone' => 'string|nullable',
            'cliente_id' => 'string|required',
        ];

        // Verificar se há um pedido de alteração de e-mail
        if ($this->has('email')) {
            // Adicionar regra de validação para e-mail
            $rules['email'] = [
                'email',
                'required',
                Rule::unique('contatos')->ignore($this->route('contato'))->where(function ($query) {
                    return $query->where('cliente_id', $this->input('cliente_id'));
                }),
            ];
        }
        return $rules;
    }
}
