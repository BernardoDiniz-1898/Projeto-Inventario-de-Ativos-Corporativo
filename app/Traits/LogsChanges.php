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
        $changed = array_filter($new, fn($v, $k) => $old[$k] ?? null !== $v, ARRAY_FILTER_USE_BOTH);

        if (empty($changed)) {
            return;
        }

        ActivityLog::create([
            'loggable_type' => get_class($model),
            'loggable_id' => $model->id,
            'action' => 'updated',
            'description' => $this->describeAction('atualizado', $model),
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
