<?php

namespace App\Http\Controllers;

use App\Exports\NotebookExport;
use App\Http\Requests\StoreNotebookRequest;
use App\Http\Requests\UpdateNotebookRequest;
use App\Models\Employee;
use App\Models\Grupo;
use App\Models\Localizacao;
use App\Models\Notebook;
use App\Traits\LogsChanges;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    use LogsChanges;

    public function index(Request $request)
    {
        $query = Notebook::with(['funcionario' => fn($q) => $q->withoutGlobalScopes([SoftDeletingScope::class]), 'grupos']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('marca', 'like', "%{$search}%")
                    ->orWhere('modelo', 'like', "%{$search}%")
                    ->orWhere('numero_serie', 'like', "%{$search}%")
                    ->orWhere('patrimonio', 'like', "%{$search}%")
                    ->orWhere('localizacao', 'like', "%{$search}%")
                    ->orWhere('predio', 'like', "%{$search}%")
                    ->orWhereHas('funcionario', function ($q2) use ($search) {
                        $q2->where('nome', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('classificacao')) {
            $query->where('classificacao', $request->classificacao);
        }

        if ($request->filled('criticidade')) {
            $query->where('criticidade', $request->criticidade);
        }

        if ($request->filled('grupo_id')) {
            $query->whereHas('grupos', fn($q) => $q->where('grupos.id', $request->grupo_id));
        }

        if ($request->filled('sistema_operacional')) {
            $query->where('sistema_operacional', $request->sistema_operacional);
        }

        if ($request->filled('fornecedor')) {
            $query->where('fornecedor', $request->fornecedor);
        }

        $notebooks = $query->latest()->paginate(15)->withQueryString();
        $grupos = Grupo::withTrashed()->orderBy('nome')->get();
        $sistemasOperacionais = Notebook::whereNotNull('sistema_operacional')->where('sistema_operacional', '!=', '')->distinct()->orderBy('sistema_operacional')->pluck('sistema_operacional');
        $fornecedores = Notebook::whereNotNull('fornecedor')->where('fornecedor', '!=', '')->distinct()->orderBy('fornecedor')->pluck('fornecedor');

        return view('notebooks.index', compact('notebooks', 'grupos', 'sistemasOperacionais', 'fornecedores'));
    }

    public function create()
    {
        $employees = Employee::where('status', '!=', 'desligado')->orderBy('nome')->get();
        $grupos = Grupo::withTrashed()->orderBy('nome')->get();
        $localizacoes = Localizacao::with('grupos')->orderBy('nome')->get();
        $notebook = null;

        return view('notebooks.create', compact('employees', 'notebook', 'grupos', 'localizacoes'));
    }

    public function store(StoreNotebookRequest $request)
    {
        $validated = $request->validated();
        $grupoIds = $validated['grupo_ids'] ?? [];
        unset($validated['grupo_ids']);
        $notebook = Notebook::create($validated);
        if ($grupoIds) {
            $notebook->grupos()->sync($grupoIds);
        }
        $this->logCreate($notebook, $validated);

        return redirect()->route('notebooks.index')
            ->with('success', __('messages.notebook_created'));
    }

    public function show(Notebook $notebook)
    {
        $notebook->load(['funcionario' => fn($q) => $q->withoutGlobalScopes([SoftDeletingScope::class]), 'grupos', 'localizacao']);
        $logs = $notebook->logs()->with('user')->latest()->paginate(10);

        return view('notebooks.show', compact('notebook', 'logs'));
    }

    public function edit(Notebook $notebook)
    {
        $employees = Employee::where('status', '!=', 'desligado')->orderBy('nome')->get();
        $grupos = Grupo::withTrashed()->orderBy('nome')->get();
        $localizacoes = Localizacao::with('grupos')->orderBy('nome')->get();

        return view('notebooks.edit', compact('notebook', 'employees', 'grupos', 'localizacoes'));
    }

    public function update(UpdateNotebookRequest $request, Notebook $notebook)
    {
        $validated = $request->validated();
        $grupoIds = $validated['grupo_ids'] ?? [];
        unset($validated['grupo_ids']);

        $old = $notebook->only(array_keys($validated));
        $notebook->update($validated);
        $notebook->grupos()->sync($grupoIds);
        $this->logUpdate($notebook, $old, $validated);

        return redirect()->route('notebooks.index')
            ->with('success', __('messages.notebook_updated'));
    }

    public function destroy(Notebook $notebook)
    {
        $this->logDelete($notebook);
        $notebook->delete();

        return redirect()->route('notebooks.index')
            ->with('success', __('messages.notebook_deleted'));
    }

    public function export(Request $request)
    {
        $export = new NotebookExport();
        $export->export($request->only('status', 'grupo_id', 'sistema_operacional', 'fornecedor', 'classificacao', 'criticidade', 'search'));
    }
}
