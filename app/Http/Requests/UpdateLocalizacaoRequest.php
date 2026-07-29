<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocalizacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'predio' => 'nullable|string|max:255',
            'andar' => 'nullable|string|max:255',
            'sala' => 'nullable|string|max:255',
            'grupo_id' => 'nullable|exists:grupos,id',
        ];
    }
}
