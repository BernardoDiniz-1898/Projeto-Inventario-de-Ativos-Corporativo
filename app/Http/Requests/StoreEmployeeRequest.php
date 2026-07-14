<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'matricula' => 'nullable|string|max:255|unique:employees,matricula',
            'email' => 'nullable|email|max:255|unique:employees,email',
            'telefone' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'centro_custo' => 'nullable|string|max:255',
            'projeto' => 'nullable|string|max:255',
            'setor' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'status' => 'required|in:ativo,afastado,desligado,ferias',
            'data_admissao' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ];
    }
}
