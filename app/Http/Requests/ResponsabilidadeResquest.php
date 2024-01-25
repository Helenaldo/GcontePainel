<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponsabilidadeResquest extends FormRequest
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
            'data' => 'date|required',
            'contabil' => 'string|nullable',
            'pessoal' => 'string|nullable',
            'fiscal' => 'string|nullable',
            'paralegal' => 'string|nullable',
        ];
    }
}
