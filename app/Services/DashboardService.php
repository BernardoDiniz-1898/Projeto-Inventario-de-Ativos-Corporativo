<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Employee;
use App\Models\Grupo;
use App\Models\Notebook;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'total' => Notebook::count(),
            'disponiveis' => Notebook::where('status', 'disponivel')->count(),
            'emUso' => Notebook::where('status', 'em_uso')->count(),
            'manutencao' => Notebook::where('status', 'manutencao')->count(),
            'ociosos' => Notebook::where('status', 'ocioso')->count(),
            'totalFuncionarios' => Employee::count(),
        ];
    }

    public function getNotebooksByBrand(): Collection
    {
        return Notebook::select('marca', DB::raw('count(*) as total'))
            ->groupBy('marca')
            ->orderByDesc('total')
            ->get();
    }

    public function getEmployeesByDepartment(): Collection
    {
        return Employee::whereHas('notebooks')
            ->select('departamento', DB::raw('count(*) as total'))
            ->groupBy('departamento')
            ->orderByDesc('total')
            ->get();
    }

    public function getRecentNotebooks(int $limit = 5): Collection
    {
        return Notebook::with('funcionario')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getNotebooksByGrupo(): Collection
    {
        return Grupo::withCount(['notebooks', 'employees'])
            ->has('notebooks')
            ->orderByDesc('notebooks_count')
            ->get();
    }

    // ── Novos métodos ───────────────────────────────────

    public function getTotalValue(): float
    {
        return (float) Notebook::whereNotNull('preco')->sum('preco');
    }

    public function getNotebooksWithoutEmployee(): int
    {
        return Notebook::whereNull('funcionario_id')
            ->whereNotIn('status', ['baixa', 'extraviado'])
            ->count();
    }

    public function getWarrantyExpiring(int $days = 30): Collection
    {
        return Notebook::whereNotNull('data_garantia')
            ->whereBetween('data_garantia', [now(), now()->addDays($days)])
            ->whereNotIn('status', ['baixa', 'extraviado'])
            ->orderBy('data_garantia')
            ->get();
    }

    public function getUpcomingMaintenance(int $days = 30): Collection
    {
        return Notebook::whereNotNull('proxima_manutencao')
            ->whereBetween('proxima_manutencao', [now(), now()->addDays($days)])
            ->whereNotIn('status', ['baixa', 'extraviado'])
            ->orderBy('proxima_manutencao')
            ->get();
    }

    public function getStatusDistribution(): Collection
    {
        return Notebook::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();
    }

    public function getRecentActivity(int $limit = 8): Collection
    {
        return ActivityLog::with('user')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getSecurityCompliance(): array
    {
        $active = Notebook::whereNotIn('status', ['baixa', 'extraviado'])->count();
        if ($active === 0) {
            return ['criptografia' => 0, 'antivirus' => 0, 'backup' => 0, 'patches_atualizados' => 0, 'total' => 0];
        }

        return [
            'criptografia' => Notebook::where('criptografia', true)->count(),
            'antivirus' => Notebook::where('antivirus', true)->count(),
            'backup' => Notebook::where('backup_configurado', true)->count(),
            'patches_atualizados' => Notebook::where('status_patches', 'atualizado')->count(),
            'total' => $active,
        ];
    }

    public function getActiveRentals(): array
    {
        $rentals = Notebook::whereNotNull('empresa_locataria')
            ->whereNull('data_fim_aluguel')
            ->orWhere(function ($q) {
                $q->whereNotNull('data_fim_aluguel')
                    ->where('data_fim_aluguel', '>=', now());
            })
            ->whereNotNull('valor_aluguel')
            ->get();

        return [
            'count' => $rentals->count(),
            'total_mensal' => (float) $rentals->sum('valor_aluguel'),
        ];
    }
}
