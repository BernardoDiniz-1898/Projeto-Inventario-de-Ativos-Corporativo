<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrupoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255|unique:grupos,nome',
            'descricao' => 'nullable|string',
            'cor' => 'nullable|string|max:7',
        ];
    }
}
