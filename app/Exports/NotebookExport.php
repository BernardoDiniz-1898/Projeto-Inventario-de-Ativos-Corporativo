<?php

namespace App\Exports;

use App\Models\Notebook;
use OpenSpout\Writer\Common\Creator\WriterEntityFactory;

class NotebookExport
{
    public function export(?string $status = null)
    {
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser('notebooks_' . date('Y-m-d_H-i-s') . '.xlsx');

        $headerRow = WriterEntityFactory::createRowFromArray([
            'Patrimônio', 'Marca', 'Modelo', 'Nº Série', 'Status',
            'Responsável', 'Sistema Operacional', 'Processador', 'RAM (GB)',
            'Armazenamento', 'Fornecedor', 'Preço (R$)', 'Data Aquisição',
            'Data Garantia', 'Observações',
        ]);
        $writer->addRow($headerRow);

        $query = Notebook::with('funcionario');

        if ($status) {
            $query->where('status', $status);
        }

        $notebooks = $query->orderBy('marca')->get();

        foreach ($notebooks as $notebook) {
            $row = WriterEntityFactory::createRowFromArray([
                $notebook->patrimonio ?? '',
                $notebook->marca,
                $notebook->modelo,
                $notebook->numero_serie,
                $notebook->status_label,
                $notebook->funcionario->nome ?? '',
                $notebook->sistema_operacional ?? '',
                $notebook->processador ?? '',
                $notebook->ram_gb ?? '',
                $notebook->armazenamento ?? '',
                $notebook->forncedor ?? '',
                $notebook->preco ? number_format($notebook->preco, 2, ',', '.') : '',
                $notebook->data_aquisicao?->format('d/m/Y') ?? '',
                $notebook->data_garantia?->format('d/m/Y') ?? '',
                $notebook->observacoes ?? '',
            ]);
            $writer->addRow($row);
        }

        $writer->close();
    }
}
