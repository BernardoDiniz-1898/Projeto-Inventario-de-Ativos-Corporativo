<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Notebook extends Model
{
    /** @use HasFactory<\Database\Factories\NotebookFactory> */
    use HasFactory;

    protected $fillable = [
        'marca',
        'modelo',
        'numero_serie',
        'patrimonio',
        'status',
        'funcionario_id',
        'sistema_operacional',
        'ram_gb',
        'armazenamento',
        'processador',
        'data_aquisicao',
        'data_garantia',
        'observacoes',
        'forncedor',
        'preco',
    ];

    protected function casts(): array
    {
        return [
            'ram_gb' => 'decimal:1',
            'preco' => 'decimal:2',
            'data_aquisicao' => 'date',
            'data_garantia' => 'date',
        ];
    }

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'disponivel' => 'Disponível',
            'em_uso' => 'Em Uso',
            'manutencao' => 'Manutenção',
            'ocioso' => 'Ocioso',
            'devolvido' => 'Devolvido',
            'obsoleto' => 'Obsoleto',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'disponivel' => 'green',
            'em_uso' => 'blue',
            'manutencao' => 'yellow',
            'ocioso' => 'orange',
            'devolvido' => 'purple',
            'obsoleto' => 'red',
            default => 'gray',
        };
    }
}
