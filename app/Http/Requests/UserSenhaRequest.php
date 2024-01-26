<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSenhaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'string|required|confirmed|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        ];
    }
}
