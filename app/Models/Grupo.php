<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Grupo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'slug', 'descricao', 'cor'];

    protected static function booted(): void
    {
        static::creating(function (Grupo $grupo) {
            if (empty($grupo->slug)) {
                $grupo->slug = Str::slug($grupo->nome);
            }
        });

        static::updating(function (Grupo $grupo) {
            if ($grupo->isDirty('nome') && !$grupo->isDirty('slug')) {
                $grupo->slug = Str::slug($grupo->nome);
            }
        });
    }

    public function notebooks(): HasMany
    {
        return $this->hasMany(Notebook::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
