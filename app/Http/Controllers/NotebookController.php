<?php

namespace App\Http\Controllers;

use App\Exports\NotebookExport;
use App\Http\Requests\StoreNotebookRequest;
use App\Http\Requests\UpdateNotebookRequest;
use App\Models\Employee;
use App\Models\Notebook;
use App\Traits\LogsChanges;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    use LogsChanges;

    public function index(Request $request)
    {
        $query = Notebook::with('funcionario');

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

        $notebooks = $query->latest()->paginate(15)->withQueryString();

        return view('notebooks.index', compact('notebooks'));
    }

    public function create()
    {
        $employees = Employee::where('status', '!=', 'desligado')->orderBy('nome')->get();
        $notebook = null;

        return view('notebooks.create', compact('employees', 'notebook'));
    }

    public function store(StoreNotebookRequest $request)
    {
        $validated = $request->validated();
        $notebook = Notebook::create($validated);
        $this->logCreate($notebook, $validated);

        return redirect()->route('notebooks.index')
            ->with('success', __('messages.notebook_created'));
    }

    public function show(Notebook $notebook)
    {
        $notebook->load('funcionario');
        $logs = $notebook->logs()->with('user')->latest()->paginate(10);

        return view('notebooks.show', compact('notebook', 'logs'));
    }

    public function edit(Notebook $notebook)
    {
        $employees = Employee::where('status', '!=', 'desligado')->orderBy('nome')->get();

        return view('notebooks.edit', compact('notebook', 'employees'));
    }

    public function update(UpdateNotebookRequest $request, Notebook $notebook)
    {
        $validated = $request->validated();

        $old = $notebook->only(array_keys($validated));
        $notebook->update($validated);
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
        $export->export($request->status);
    }
}
