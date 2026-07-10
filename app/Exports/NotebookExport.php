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
            'Responsável', 'Data Entrega', 'Sistema Operacional', 'Processador', 'RAM (GB)',
            'Armazenamento', 'Fornecedor', 'Preço (R$)', 'Data Aquisição',
            'Data Garantia', 'Observações',
            'Classificação', 'Localização', 'Prédio', 'Andar', 'Sala',
            'Criticidade', 'Fim Vida Útil', 'Data Baixa', 'Motivo Baixa', 'Método Descarte',
            'Criptografia', 'Antivírus', 'Status Patches', 'Backup',
            'Última Manutenção', 'Próxima Manutenção', 'Histórico Manutenção',
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
                $notebook->data_entrega?->format('d/m/Y') ?? '',
                $notebook->sistema_operacional ?? '',
                $notebook->processador ?? '',
                $notebook->ram_gb ?? '',
                $notebook->armazenamento ?? '',
                $notebook->forncedor ?? '',
                $notebook->preco ? number_format($notebook->preco, 2, ',', '.') : '',
                $notebook->data_aquisicao?->format('d/m/Y') ?? '',
                $notebook->data_garantia?->format('d/m/Y') ?? '',
                $notebook->observacoes ?? '',
                $notebook->classificacao_label ?? '',
                $notebook->localizacao ?? '',
                $notebook->predio ?? '',
                $notebook->andar ?? '',
                $notebook->sala ?? '',
                $notebook->criticidade_label ?? '',
                $notebook->data_vida_util?->format('d/m/Y') ?? '',
                $notebook->data_baixa?->format('d/m/Y') ?? '',
                $notebook->motivo_baixa_label ?? '',
                $notebook->metodo_descarte_label ?? '',
                $notebook->criptografia ? 'Sim' : 'Não',
                $notebook->antivirus ? 'Sim' : 'Não',
                $notebook->patches_label ?? '',
                $notebook->backup_configurado ? 'Sim' : 'Não',
                $notebook->ultima_manutencao?->format('d/m/Y') ?? '',
                $notebook->proxima_manutencao?->format('d/m/Y') ?? '',
                $notebook->historico_manutencao ?? '',
            ]);
            $writer->addRow($row);
        }

        $writer->close();
    }
}
