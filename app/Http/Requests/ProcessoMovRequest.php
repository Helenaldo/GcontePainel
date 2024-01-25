<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessoMovRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $data = $this->all();
        //     dd($data);
        return [

            'user_id' => 'string|required',
            'processo_id' => 'string|required',
            'data' => 'string|required',
            'descricao' => 'string|required',
            'anexo' => 'nullable|file|mimes:pdf',
        ];
    }
}

