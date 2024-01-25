<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'string|required',
            'email' => 'string|required|unique:users,email',
            'perfil' => 'string|required|in:Administrador,Operador',
            'ativo' => 'boolean|required',
            'password' => 'string|required|confirmed',

        ];
    }
}
