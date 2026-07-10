<?php

namespace App\Http\Controllers;

use App\Exports\NotebookExport;
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
                    ->orWhereHas('funcionario', function ($q2) use ($search) {
                        $q2->where('nome', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $notebooks = $query->latest()->paginate(15)->withQueryString();

        return view('notebooks.index', compact('notebooks'));
    }

    public function create()
    {
        $employees = Employee::where('status', '!=', 'desligado')->orderBy('nome')->get();

        return view('notebooks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255|unique:notebooks,numero_serie',
            'patrimonio' => 'nullable|string|max:255|unique:notebooks,patrimonio',
            'status' => 'required|in:disponivel,em_uso,manutencao,ocioso,devolvido,obsoleto',
            'funcionario_id' => 'nullable|exists:employees,id',
            'sistema_operacional' => 'nullable|string|max:255',
            'ram_gb' => 'nullable|numeric|min:1',
            'armazenamento' => 'nullable|string|max:255',
            'processador' => 'nullable|string|max:255',
            'data_aquisicao' => 'nullable|date',
            'data_garantia' => 'nullable|date|after_or_equal:data_aquisicao',
            'observacoes' => 'nullable|string',
            'forncedor' => 'nullable|string|max:255',
            'preco' => 'nullable|numeric|min:0',
        ]);

        $notebook = Notebook::create($validated);
        $this->logCreate($notebook, $validated);

        return redirect()->route('notebooks.index')
            ->with('success', 'Notebook cadastrado com sucesso!');
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

    public function update(Request $request, Notebook $notebook)
    {
        $validated = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255|unique:notebooks,numero_serie,' . $notebook->id,
            'patrimonio' => 'nullable|string|max:255|unique:notebooks,patrimonio,' . $notebook->id,
            'status' => 'required|in:disponivel,em_uso,manutencao,ocioso,devolvido,obsoleto',
            'funcionario_id' => 'nullable|exists:employees,id',
            'sistema_operacional' => 'nullable|string|max:255',
            'ram_gb' => 'nullable|numeric|min:1',
            'armazenamento' => 'nullable|string|max:255',
            'processador' => 'nullable|string|max:255',
            'data_aquisicao' => 'nullable|date',
            'data_garantia' => 'nullable|date|after_or_equal:data_aquisicao',
            'observacoes' => 'nullable|string',
            'forncedor' => 'nullable|string|max:255',
            'preco' => 'nullable|numeric|min:0',
        ]);

        $old = $notebook->only(array_keys($validated));
        $notebook->update($validated);
        $this->logUpdate($notebook, $old, $validated);

        return redirect()->route('notebooks.index')
            ->with('success', 'Notebook atualizado com sucesso!');
    }

    public function destroy(Notebook $notebook)
    {
        $this->logDelete($notebook);
        $notebook->delete();

        return redirect()->route('notebooks.index')
            ->with('success', 'Notebook removido com sucesso!');
    }

    public function export(Request $request)
    {
        $export = new NotebookExport();
        $export->export($request->status);
    }
}
