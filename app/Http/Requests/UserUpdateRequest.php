<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->userId;
        return [
            'name' => 'string|required',
            'email' => [
                'string',
                'required',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'perfil' => 'string|required|in:Administrador,Operador',
            'ativo' => 'boolean|required',
        ];
    }
}
