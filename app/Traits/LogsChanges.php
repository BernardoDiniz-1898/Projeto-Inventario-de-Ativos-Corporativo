<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

trait LogsChanges
{
    protected function logCreate($model, array $attributes): void
    {
        try {
            ActivityLog::create([
                'loggable_type' => get_class($model),
                'loggable_id' => $model->getKey(),
                'action' => 'created',
                'description' => $this->describeAction(__('logs.created'), $model),
                'old_values' => null,
                'new_values' => $attributes,
                'user_id' => auth()->id(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to log create: ' . $e->getMessage());
        }
    }

    protected function logUpdate($model, array $old, array $new): void
    {
        $changed = array_filter($new, fn($v, $k) => ($old[$k] ?? null) !== $v, ARRAY_FILTER_USE_BOTH);

        if (empty($changed)) {
            return;
        }

        try {
            $label = $model->getAttribute('marca')
                ?? $model->getAttribute('nome')
                ?? '#' . ($model->getKey() ?? '?');

            $fieldLabels = collect([
                'marca', 'modelo', 'numero_serie', 'patrimonio', 'status', 'funcionario_id',
                'data_entrega', 'sistema_operacional', 'ram_gb', 'armazenamento', 'processador',
                'data_aquisicao', 'data_garantia', 'observacoes', 'fornecedor', 'preco',
                'nome', 'matricula', 'email', 'telefone', 'departamento',
                'centro_custo', 'projeto', 'setor', 'cargo', 'data_admissao',
                'classificacao', 'localizacao', 'predio', 'andar', 'sala',
                'criticidade', 'data_vida_util', 'data_baixa', 'motivo_baixa',
                'metodo_descarte', 'criptografia', 'antivirus', 'status_patches',
                'backup_configurado', 'ultima_manutencao', 'proxima_manutencao', 'historico_manutencao',
                'empresa_locataria', 'numero_contrato', 'valor_aluguel', 'periodo_aluguel',
                'data_inicio_aluguel', 'data_fim_aluguel', 'grupo_id', 'role',
            ])->mapWithKeys(fn($field) => [$field => __('logs.fields.' . $field)])->toArray();

            $changedNames = array_map(fn($k) => $fieldLabels[$k] ?? $k, array_keys($changed));
            $description = __('logs.description_update_pattern', [
                'model' => class_basename($model),
                'label' => $label,
                'fields' => implode(', ', $changedNames),
            ]);

            ActivityLog::create([
                'loggable_type' => get_class($model),
                'loggable_id' => $model->getKey(),
                'action' => 'updated',
                'description' => $description,
                'old_values' => array_intersect_key($old, $changed),
                'new_values' => $changed,
                'user_id' => auth()->id(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to log update: ' . $e->getMessage());
        }
    }

    protected function logDelete($model): void
    {
        try {
            $id = $model->getKey();
            $attributes = $model->getAttributes();

            ActivityLog::create([
                'loggable_type' => get_class($model),
                'loggable_id' => $id,
                'action' => 'deleted',
                'description' => $this->describeAction(__('logs.deleted'), $model),
                'old_values' => $attributes ?: null,
                'new_values' => null,
                'user_id' => auth()->id(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to log delete: ' . $e->getMessage());
        }
    }

    protected function describeAction(string $action, $model): string
    {
        $label = $model->getAttribute('marca')
            ?? $model->getAttribute('nome')
            ?? '#' . ($model->getKey() ?? '?');

        return __('logs.description_pattern', [
            'model' => class_basename($model),
            'label' => $label,
            'action' => $action,
        ]);
    }
}
