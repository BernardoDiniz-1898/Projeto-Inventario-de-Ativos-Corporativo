<?php

namespace App\Exports;

use App\Models\Employee;
use OpenSpout\Writer\Common\Creator\WriterEntityFactory;

class EmployeeExport
{
    public function export(?string $status = null)
    {
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser('funcionarios_' . date('Y-m-d_H-i-s') . '.xlsx');

        $headerRow = WriterEntityFactory::createRowFromArray([
            __('logs.fields.nome'), __('logs.fields.matricula'), __('logs.fields.email'), __('logs.fields.telefone'), __('logs.fields.departamento'), __('logs.fields.grupo_id'),
            __('logs.fields.centro_custo'), __('logs.fields.projeto'), __('logs.fields.setor'), __('logs.fields.cargo'), __('logs.fields.status'),
            __('logs.fields.data_admissao'), __('employee.notebooks_linked') ?: 'Qtd Notebooks', __('logs.fields.observacoes'),
        ]);
        $writer->addRow($headerRow);

        $query = Employee::with('grupo')->withCount('notebooks');

        if ($status) {
            $query->where('status', $status);
        }

        $employees = $query->orderBy('nome')->get();

        foreach ($employees as $employee) {
            $row = WriterEntityFactory::createRowFromArray([
                $employee->nome,
                $employee->matricula ?? '',
                $employee->email ?? '',
                $employee->telefone ?? '',
                $employee->departamento ?? '',
                $employee->grupo->nome ?? '',
                $employee->centro_custo ?? '',
                $employee->projeto ?? '',
                $employee->setor ?? '',
                $employee->cargo ?? '',
                $employee->status_label,
                $employee->data_admissao?->format('d/m/Y') ?? '',
                $employee->notebooks_count,
                $employee->observacoes ?? '',
            ]);
            $writer->addRow($row);
        }

        $writer->close();
    }
}
