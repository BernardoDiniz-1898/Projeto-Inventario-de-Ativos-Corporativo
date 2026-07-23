<?php

namespace App\Exports;

use App\Models\Notebook;
use App\Models\Grupo;
use OpenSpout\Writer\Common\Creator\WriterEntityFactory;

class NotebookExport
{
    public function export(array $filters = [])
    {
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser('notebooks_' . date('Y-m-d_H-i-s') . '.xlsx');

        $headerRow = WriterEntityFactory::createRowFromArray([
            __('logs.fields.patrimonio'), __('logs.fields.marca'), __('logs.fields.modelo'), __('logs.fields.numero_serie'), __('logs.fields.status'), __('logs.fields.grupo_id'),
            __('logs.fields.funcionario_id'), __('notebook.delivery_date') ?: __('logs.fields.data_entrega'), __('logs.fields.sistema_operacional'), __('logs.fields.processador'), __('logs.fields.ram_gb') . ' (GB)',
            __('logs.fields.armazenamento'), __('logs.fields.fornecedor'), __('logs.fields.preco') . ' (R$)', __('logs.fields.data_aquisicao'),
            __('logs.fields.data_garantia'), __('logs.fields.observacoes'),
            __('logs.fields.classificacao'), __('logs.fields.localizacao'), __('logs.fields.predio'), __('logs.fields.andar'), __('logs.fields.sala'),
            __('logs.fields.criticidade'), __('logs.fields.data_vida_util'), __('logs.fields.data_baixa'), __('logs.fields.motivo_baixa'), __('logs.fields.metodo_descarte'),
            __('logs.fields.criptografia'), __('logs.fields.antivirus'), __('logs.fields.status_patches'), __('logs.fields.backup_configurado'),
            __('logs.fields.ultima_manutencao'), __('logs.fields.proxima_manutencao'), __('logs.fields.historico_manutencao'),
            __('logs.fields.empresa_locataria'), __('logs.fields.numero_contrato'), __('logs.fields.valor_aluguel'), __('notebook.rental_period') ?: __('logs.fields.periodo_aluguel'),
            __('logs.fields.data_inicio_aluguel'), __('logs.fields.data_fim_aluguel'),
        ]);
        $writer->addRow($headerRow);

        $query = Notebook::with(['funcionario', 'grupo']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['grupo_id'])) {
            $query->where('grupo_id', $filters['grupo_id']);
        }
        if (!empty($filters['sistema_operacional'])) {
            $query->where('sistema_operacional', $filters['sistema_operacional']);
        }
        if (!empty($filters['fornecedor'])) {
            $query->where('fornecedor', $filters['fornecedor']);
        }
        if (!empty($filters['classificacao'])) {
            $query->where('classificacao', $filters['classificacao']);
        }
        if (!empty($filters['criticidade'])) {
            $query->where('criticidade', $filters['criticidade']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('marca', 'like', "%{$search}%")
                    ->orWhere('modelo', 'like', "%{$search}%")
                    ->orWhere('numero_serie', 'like', "%{$search}%")
                    ->orWhere('patrimonio', 'like', "%{$search}%")
                    ->orWhere('localizacao', 'like', "%{$search}%")
                    ->orWhere('predio', 'like', "%{$search}%")
                    ->orWhereHas('funcionario', function ($q2) use ($search) {
                        $q2->where('nome', 'like', "%{$search}%");
                    });
            });
        }

        $notebooks = $query->orderBy('marca')->get();

        foreach ($notebooks as $notebook) {
            $row = WriterEntityFactory::createRowFromArray([
                $notebook->patrimonio ?? '',
                $notebook->marca,
                $notebook->modelo,
                $notebook->numero_serie,
                $notebook->status_label,
                $notebook->grupo->nome ?? '',
                $notebook->funcionario->nome ?? '',
                $notebook->data_entrega?->format('d/m/Y') ?? '',
                $notebook->sistema_operacional ?? '',
                $notebook->processador ?? '',
                $notebook->ram_gb ?? '',
                $notebook->armazenamento ?? '',
                $notebook->fornecedor ?? '',
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
                $notebook->criptografia ? __('common.yes') ?: 'Sim' : __('common.no') ?: 'Não',
                $notebook->antivirus ? __('common.yes') ?: 'Sim' : __('common.no') ?: 'Não',
                $notebook->status_patches_label ?? '',
                $notebook->backup_configurado ? __('common.yes') ?: 'Sim' : __('common.no') ?: 'Não',
                $notebook->ultima_manutencao?->format('d/m/Y') ?? '',
                $notebook->proxima_manutencao?->format('d/m/Y') ?? '',
                $notebook->historico_manutencao ?? '',
                $notebook->empresa_locataria ?? '',
                $notebook->numero_contrato ?? '',
                $notebook->valor_aluguel ? number_format($notebook->valor_aluguel, 2, ',', '.') : '',
                $notebook->periodo_aluguel_label ?? '',
                $notebook->data_inicio_aluguel?->format('d/m/Y') ?? '',
                $notebook->data_fim_aluguel?->format('d/m/Y') ?? '',
            ]);
            $writer->addRow($row);
        }

        $writer->close();
    }
}
