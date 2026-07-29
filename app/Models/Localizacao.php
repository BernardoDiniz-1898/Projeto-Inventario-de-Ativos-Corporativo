<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Localizacao extends Model
{
    use HasFactory;

    protected $table = 'localizacoes';
    protected $fillable = ['nome', 'predio', 'andar', 'sala', 'grupo_id'];

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }

    public function notebooks(): HasMany
    {
        return $this->hasMany(Notebook::class);
    }

    public function getDescricaoCompletaAttribute(): string
    {
        return $this->nome . ($this->predio ? " — {$this->predio}" : '') . ($this->andar ? ", {$this->andar}" : '') . ($this->sala ? " — {$this->sala}" : '');
    }
}
