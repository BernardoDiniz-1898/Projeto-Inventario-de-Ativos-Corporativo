<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'matricula',
        'email',
        'telefone',
        'departamento',
        'centro_custo',
        'projeto',
        'setor',
        'cargo',
        'status',
        'data_admissao',
        'observacoes',
    ];

    protected function casts(): array
    {
        return [
            'data_admissao' => 'date',
        ];
    }

    public function notebooks(): HasMany
    {
        return $this->hasMany(Notebook::class, 'funcionario_id');
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'ativo' => __('employee.status_options.ativo'),
            'afastado' => __('employee.status_options.afastado'),
            'desligado' => __('employee.status_options.desligado'),
            'ferias' => __('employee.status_options.ferias'),
            default => $this->status,
        };
    }
}
