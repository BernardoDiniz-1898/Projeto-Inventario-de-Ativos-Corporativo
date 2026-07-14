<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id;

        return [
            'nome' => 'required|string|max:255',
            'matricula' => "nullable|string|max:255|unique:employees,matricula,{$employeeId}",
            'email' => "nullable|email|max:255|unique:employees,email,{$employeeId}",
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
