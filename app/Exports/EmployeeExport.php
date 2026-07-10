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
            'Nome', 'Matrícula', 'Email', 'Telefone', 'Departamento',
            'Centro de Custo', 'Projeto', 'Setor', 'Cargo', 'Status',
            'Data Admissão', 'Qtd Notebooks', 'Observações',
        ]);
        $writer->addRow($headerRow);

        $query = Employee::withCount('notebooks');

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
