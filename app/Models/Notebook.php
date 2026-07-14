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
        'data_entrega',
        'sistema_operacional',
        'ram_gb',
        'armazenamento',
        'processador',
        'data_aquisicao',
        'data_garantia',
        'observacoes',
        'fornecedor',
        'preco',
        // ISO 27001 — Classificação
        'classificacao',
        // ISO 27001 — Localização
        'localizacao',
        'predio',
        'andar',
        'sala',
        // ISO 27001 — Ciclo de vida
        'criticidade',
        'data_vida_util',
        'data_baixa',
        'motivo_baixa',
        'metodo_descarte',
        // ISO 27001 — Segurança do dispositivo
        'criptografia',
        'antivirus',
        'status_patches',
        'backup_configurado',
        // ISO 27001 — Manutenção
        'ultima_manutencao',
        'proxima_manutencao',
        'historico_manutencao',
        // Aluguel
        'empresa_locataria',
        'numero_contrato',
        'valor_aluguel',
        'periodo_aluguel',
        'data_inicio_aluguel',
        'data_fim_aluguel',
    ];

    protected function casts(): array
    {
        return [
            'ram_gb' => 'decimal:1',
            'preco' => 'decimal:2',
            'data_aquisicao' => 'date',
            'data_entrega' => 'date',
            'data_garantia' => 'date',
            'data_vida_util' => 'date',
            'data_baixa' => 'date',
            'ultima_manutencao' => 'date',
            'proxima_manutencao' => 'date',
            'criptografia' => 'boolean',
            'antivirus' => 'boolean',
            'backup_configurado' => 'boolean',
            'valor_aluguel' => 'decimal:2',
            'data_inicio_aluguel' => 'date',
            'data_fim_aluguel' => 'date',
        ];
    }

    // ── Relacionamentos ──────────────────────────────────

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    // ── Accessors de exibição ────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'disponivel' => __('notebook.status_options.disponivel'),
            'em_uso' => __('notebook.status_options.em_uso'),
            'manutencao' => __('notebook.status_options.manutencao'),
            'ocioso' => __('notebook.status_options.ocioso'),
            'devolvido' => __('notebook.status_options.devolvido'),
            'obsoleto' => __('notebook.status_options.obsoleto'),
            'baixa' => __('notebook.status_options.baixa'),
            'extraviado' => __('notebook.status_options.extraviado'),
            'transferido' => __('notebook.status_options.transferido'),
            'alugado' => __('notebook.status_options.alugado'),
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
            'baixa' => 'slate',
            'extraviado' => 'pink',
            'transferido' => 'cyan',
            'alugado' => 'violet',
            default => 'gray',
        };
    }

    public function getClassificacaoLabelAttribute(): string
    {
        return match ($this->classificacao) {
            'publica' => __('notebook.classification_options.publica'),
            'interna' => __('notebook.classification_options.interna'),
            'restrita' => __('notebook.classification_options.restrita'),
            'confidencial' => __('notebook.classification_options.confidencial'),
            default => $this->classificacao ?? '—',
        };
    }

    public function getClassificacaoColorAttribute(): string
    {
        return match ($this->classificacao) {
            'publica' => 'green',
            'interna' => 'blue',
            'restrita' => 'amber',
            'confidencial' => 'red',
            default => 'gray',
        };
    }

    public function getCriticidadeLabelAttribute(): string
    {
        return match ($this->criticidade) {
            'baixo' => __('notebook.criticity_options.baixo'),
            'medio' => __('notebook.criticity_options.medio'),
            'alto' => __('notebook.criticity_options.alto'),
            'critico' => __('notebook.criticity_options.critico'),
            default => $this->criticidade ?? '—',
        };
    }

    public function getCriticidadeColorAttribute(): string
    {
        return match ($this->criticidade) {
            'baixo' => 'slate',
            'medio' => 'blue',
            'alto' => 'amber',
            'critico' => 'red',
            default => 'gray',
        };
    }

    public function getLocalizacaoCompletaAttribute(): string
    {
        $parts = array_filter([$this->predio, $this->andar, $this->sala], fn($v) => $v !== null && $v !== '');
        return $this->localizacao ?? ($parts ? implode(', ', $parts) : '—');
    }

    public function getStatusPatchesLabelAttribute(): string
    {
        return match ($this->status_patches) {
            'atualizado' => __('notebook.patches_options.atualizado'),
            'desatualizado' => __('notebook.patches_options.desatualizado'),
            'critico' => __('notebook.patches_options.critico'),
            'nao_verificado' => __('notebook.patches_options.nao_verificado'),
            default => $this->status_patches ?? '—',
        };
    }

    public function getStatusPatchesColorAttribute(): string
    {
        return match ($this->status_patches) {
            'atualizado' => 'green',
            'desatualizado' => 'amber',
            'critico' => 'red',
            'nao_verificado' => 'slate',
            default => 'gray',
        };
    }

    public function getMotivoBaixaLabelAttribute(): string
    {
        return match ($this->motivo_baixa) {
            'obsolescencia' => __('notebook.decommission_reason_options.obsolescencia'),
            'avaria' => __('notebook.decommission_reason_options.avaria'),
            'furto' => __('notebook.decommission_reason_options.furto'),
            'descarte_seguro' => __('notebook.decommission_reason_options.descarte_seguro'),
            'doacao' => __('notebook.decommission_reason_options.doacao'),
            'venda' => __('notebook.decommission_reason_options.venda'),
            'transferencia' => __('notebook.decommission_reason_options.transferencia'),
            default => $this->motivo_baixa ?? '—',
        };
    }

    public function getMetodoDescarteLabelAttribute(): string
    {
        return match ($this->metodo_descarte) {
            'destruicao_fisica' => __('notebook.disposal_method_options.destruicao_fisica'),
            'reciclagem' => __('notebook.disposal_method_options.reciclagem'),
            'limpeza_dados' => __('notebook.disposal_method_options.limpeza_dados'),
            'doacao' => __('notebook.disposal_method_options.doacao'),
            'venda' => __('notebook.disposal_method_options.venda'),
            default => $this->metodo_descarte ?? '—',
        };
    }

    public function getPeriodoAluguelLabelAttribute(): string
    {
        return match ($this->periodo_aluguel) {
            'mensal' => __('notebook.rental_period_options.mensal'),
            'trimestral' => __('notebook.rental_period_options.trimestral'),
            'semestral' => __('notebook.rental_period_options.semestral'),
            'anual' => __('notebook.rental_period_options.anual'),
            default => $this->periodo_aluguel ?? '—',
        };
    }

    // ── Helpers de ciclo de vida ─────────────────────────

    public function isGarantiaVencida(): bool
    {
        return $this->data_garantia && $this->data_garantia->isPast();
    }

    public function isVidaUtilVencida(): bool
    {
        return $this->data_vida_util && $this->data_vida_util->isPast();
    }

    public function diasAteManutencao(): ?int
    {
        return $this->proxima_manutencao ? (int) now()->diffInDays($this->proxima_manutencao, false) : null;
    }
}
