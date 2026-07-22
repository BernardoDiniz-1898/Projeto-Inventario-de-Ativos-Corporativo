<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrupoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('grupo')?->id;

        return [
            'nome' => "required|string|max:255|unique:grupos,nome,{$id}",
            'descricao' => 'nullable|string',
            'cor' => 'nullable|string|max:7',
        ];
    }
}
