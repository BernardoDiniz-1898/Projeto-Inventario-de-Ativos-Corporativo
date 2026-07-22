<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Grupo;
use App\Models\Notebook;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'all');
        $grupoId = $request->input('grupo_id');

        // Build unified inventory rows
        $rows = collect();

        // Get all notebooks with their employees
        $query = Notebook::with(['funcionario' => fn($q) => $q->withoutGlobalScopes([SoftDeletingScope::class]), 'grupo' => fn($q) => $q->withoutGlobalScopes([SoftDeletingScope::class])]);
        if ($grupoId) {
            $query->where('grupo_id', $grupoId);
        }
        $notebooks = $query->get();

        foreach ($notebooks as $nb) {
            $rows->push([
                'employee_id' => $nb->funcionario_id,
                'employee_nome' => $nb->funcionario->nome ?? null,
                'employee_matricula' => $nb->funcionario->matricula ?? null,
                'employee_centro_custo' => $nb->funcionario->centro_custo ?? null,
                'employee_projeto' => $nb->funcionario->projeto ?? null,
                'grupo_nome' => $nb->grupo->nome ?? null,
                'grupo_cor' => $nb->grupo->cor ?? null,
                'notebook_id' => $nb->id,
                'notebook_marca' => $nb->marca,
                'notebook_modelo' => $nb->modelo,
                'notebook_serial' => $nb->numero_serie,
                'notebook_patrimonio' => $nb->patrimonio,
                'notebook_status' => $nb->status,
                'notebook_status_label' => $nb->status_label,
                'has_employee' => $nb->funcionario_id !== null,
            ]);
        }

        // Find employees with no notebooks
        $assignedEmployeeIds = $notebooks->pluck('funcionario_id')->filter()->unique();
        $unassignedQuery = Employee::with(['grupo' => fn($q) => $q->withoutGlobalScopes([SoftDeletingScope::class])])->whereNotIn('id', $assignedEmployeeIds)
            ->where('status', '!=', 'desligado');
        if ($grupoId) {
            $unassignedQuery->where('grupo_id', $grupoId);
        }
        $unassignedEmployees = $unassignedQuery->get();

        foreach ($unassignedEmployees as $emp) {
            $rows->push([
                'employee_id' => $emp->id,
                'employee_nome' => $emp->nome,
                'employee_matricula' => $emp->matricula,
                'employee_centro_custo' => $emp->centro_custo,
                'employee_projeto' => $emp->projeto,
                'grupo_nome' => $emp->grupo->nome ?? null,
                'grupo_cor' => $emp->grupo->cor ?? null,
                'notebook_id' => null,
                'notebook_marca' => null,
                'notebook_modelo' => null,
                'notebook_serial' => null,
                'notebook_patrimonio' => null,
                'notebook_status' => null,
                'notebook_status_label' => null,
                'has_employee' => true,
            ]);
        }

        // Apply filter
        if ($filter === 'allocated') {
            $rows = $rows->filter(fn ($r) => $r['has_employee'] && $r['notebook_id'] !== null);
        } elseif ($filter === 'stock') {
            $rows = $rows->filter(fn ($r) => !$r['has_employee'] || $r['employee_id'] === null);
        } elseif ($filter === 'unassigned_employee') {
            $rows = $rows->filter(fn ($r) => $r['has_employee'] && $r['notebook_id'] === null);
        }

        // Apply search
        if ($search) {
            $searchLower = strtolower($search);
            $rows = $rows->filter(function ($r) use ($searchLower) {
                return str_contains(strtolower($r['employee_nome'] ?? ''), $searchLower)
                    || str_contains(strtolower($r['employee_matricula'] ?? ''), $searchLower)
                    || str_contains(strtolower($r['notebook_modelo'] ?? ''), $searchLower)
                    || str_contains(strtolower($r['notebook_marca'] ?? ''), $searchLower)
                    || str_contains(strtolower($r['notebook_patrimonio'] ?? ''), $searchLower)
                    || str_contains(strtolower($r['notebook_serial'] ?? ''), $searchLower)
                    || str_contains(strtolower($r['employee_centro_custo'] ?? ''), $searchLower)
                    || str_contains(strtolower($r['employee_projeto'] ?? ''), $searchLower);
            });
        }

        // Sort: allocated first, then by employee name
        $rows = $rows->sortBy(function ($r) {
            if ($r['has_employee'] && $r['notebook_id'] !== null) return 0;
            if ($r['has_employee'] && $r['notebook_id'] === null) return 1;
            return 2;
        })->values();

        // Stats
        $totalNotebooks = $notebooks->count();
        $totalEmployees = Employee::where('status', '!=', 'desligado')->count();
        $allocated = $notebooks->whereNotNull('funcionario_id')->count();
        $inStock = $notebooks->whereNull('funcionario_id')->count();
        $withoutEquipment = $unassignedEmployees->count();

        // Paginate manually
        $perPage = 20;
        $currentPage = $request->input('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $rows->forPage($currentPage, $perPage),
            $rows->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('inventory.index', compact(
            'paginated',
            'totalNotebooks',
            'totalEmployees',
            'allocated',
            'inStock',
            'withoutEquipment',
            'search',
            'filter',
            'grupoId'
        ));
    }
}
