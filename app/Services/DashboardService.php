<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Notebook;
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
}
