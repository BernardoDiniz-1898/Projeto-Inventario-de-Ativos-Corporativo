<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsChanges
{
    protected function logCreate($model, array $attributes): void
    {
        ActivityLog::create([
            'loggable_type' => get_class($model),
            'loggable_id' => $model->id,
            'action' => 'created',
            'description' => $this->describeAction('criado', $model),
            'old_values' => null,
            'new_values' => $attributes,
            'user_id' => auth()->id(),
        ]);
    }

    protected function logUpdate($model, array $old, array $new): void
    {
        $changed = array_filter($new, fn($v, $k) => ($old[$k] ?? null) !== $v, ARRAY_FILTER_USE_BOTH);

        if (empty($changed)) {
            return;
        }

        $label = $model->getAttribute('marca')
            ?? $model->getAttribute('nome')
            ?? '#' . $model->id;

        $fieldLabels = [
            'marca' => 'Marca', 'modelo' => 'Modelo', 'numero_serie' => 'Nº Série',
            'patrimonio' => 'Patrimônio', 'status' => 'Status', 'funcionario_id' => 'Responsável',
            'data_entrega' => 'Data de Entrega',
            'sistema_operacional' => 'Sistema Operacional', 'ram_gb' => 'RAM',
            'armazenamento' => 'Armazenamento', 'processador' => 'Processador',
            'data_aquisicao' => 'Data de Aquisição', 'data_garantia' => 'Garantia',
            'observacoes' => 'Observações', 'fornecedor' => 'Fornecedor', 'preco' => 'Preço',
            'nome' => 'Nome', 'matricula' => 'Matrícula', 'email' => 'Email',
            'telefone' => 'Telefone', 'departamento' => 'Departamento',
            'centro_custo' => 'Centro de Custo', 'projeto' => 'Projeto',
            'setor' => 'Setor', 'cargo' => 'Cargo', 'data_admissao' => 'Data de Admissão',
            // ISO 27001
            'classificacao' => 'Classificação', 'localizacao' => 'Localização',
            'predio' => 'Prédio', 'andar' => 'Andar', 'sala' => 'Sala',
            'criticidade' => 'Criticidade', 'data_vida_util' => 'Fim da Vida Útil',
            'data_baixa' => 'Data de Baixa', 'motivo_baixa' => 'Motivo da Baixa',
            'metodo_descarte' => 'Método de Descarte', 'criptografia' => 'Criptografia',
            'antivirus' => 'Antivírus', 'status_patches' => 'Status de Patches',
            'backup_configurado' => 'Backup', 'ultima_manutencao' => 'Última Manutenção',
            'proxima_manutencao' => 'Próxima Manutenção', 'historico_manutencao' => 'Histórico de Manutenção',
            // Aluguel
            'empresa_locataria' => 'Empresa Locatária', 'numero_contrato' => 'Nº Contrato',
            'valor_aluguel' => 'Valor Aluguel', 'periodo_aluguel' => 'Período Aluguel',
            'data_inicio_aluguel' => 'Início Aluguel', 'data_fim_aluguel' => 'Fim Aluguel',
        ];

        $changedNames = array_map(fn($k) => $fieldLabels[$k] ?? $k, array_keys($changed));
        $description = class_basename($model) . " \"{$label}\" atualizado — alterou: " . implode(', ', $changedNames);

        ActivityLog::create([
            'loggable_type' => get_class($model),
            'loggable_id' => $model->id,
            'action' => 'updated',
            'description' => $description,
            'old_values' => array_intersect_key($old, $changed),
            'new_values' => $changed,
            'user_id' => auth()->id(),
        ]);
    }

    protected function logDelete($model): void
    {
        ActivityLog::create([
            'loggable_type' => get_class($model),
            'loggable_id' => $model->id,
            'action' => 'deleted',
            'description' => $this->describeAction('excluído', $model),
            'old_values' => $model->getAttributes(),
            'new_values' => null,
            'user_id' => auth()->id(),
        ]);
    }

    protected function describeAction(string $action, $model): string
    {
        $label = $model->getAttribute('marca')
            ?? $model->getAttribute('nome')
            ?? '#' . $model->id;

        return class_basename($model) . " \"{$label}\" {$action}";
    }
}
