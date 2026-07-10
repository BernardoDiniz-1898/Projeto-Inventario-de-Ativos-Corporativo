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
            'sistema_operacional' => 'Sistema Operacional', 'ram_gb' => 'RAM',
            'armazenamento' => 'Armazenamento', 'processador' => 'Processador',
            'data_aquisicao' => 'Data de Aquisição', 'data_garantia' => 'Garantia',
            'observacoes' => 'Observações', 'forncedor' => 'Fornecedor', 'preco' => 'Preço',
            'nome' => 'Nome', 'matricula' => 'Matrícula', 'email' => 'Email',
            'telefone' => 'Telefone', 'departamento' => 'Departamento',
            'centro_custo' => 'Centro de Custo', 'projeto' => 'Projeto',
            'setor' => 'Setor', 'cargo' => 'Cargo', 'data_admissao' => 'Data de Admissão',
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
