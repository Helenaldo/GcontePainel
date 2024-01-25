<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'string|required',
            'email' => 'email|required|unique:contatos,email,NULL,id,cliente_id,' . $this->input('cliente_id'),
            'telefone' => 'string|nullable',
            'cliente_id' => 'string|required',
        ];
    }
}
