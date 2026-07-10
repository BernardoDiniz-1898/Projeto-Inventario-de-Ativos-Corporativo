<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Models\Employee;
use App\Traits\LogsChanges;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use LogsChanges;

    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('matricula', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('departamento', 'like', "%{$search}%")
                    ->orWhere('cargo', 'like', "%{$search}%")
                    ->orWhere('centro_custo', 'like', "%{$search}%")
                    ->orWhere('projeto', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $employees = $query->latest()->paginate(15)->withQueryString();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'nullable|string|max:255|unique:employees,matricula',
            'email' => 'nullable|email|max:255|unique:employees,email',
            'telefone' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'centro_custo' => 'nullable|string|max:255',
            'projeto' => 'nullable|string|max:255',
            'setor' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'status' => 'required|in:ativo,afastado,desligado,ferias',
            'data_admissao' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);

        $employee = Employee::create($validated);
        $this->logCreate($employee, $validated);

        return redirect()->route('employees.index')
            ->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function show(Employee $employee)
    {
        $notebooks = $employee->notebooks()->latest()->get();
        $logs = $employee->logs()->with('user')->latest()->paginate(10);

        return view('employees.show', compact('employee', 'notebooks', 'logs'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'nullable|string|max:255|unique:employees,matricula,' . $employee->id,
            'email' => 'nullable|email|max:255|unique:employees,email,' . $employee->id,
            'telefone' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'centro_custo' => 'nullable|string|max:255',
            'projeto' => 'nullable|string|max:255',
            'setor' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'status' => 'required|in:ativo,afastado,desligado,ferias',
            'data_admissao' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);

        $old = $employee->only(array_keys($validated));
        $employee->update($validated);
        $this->logUpdate($employee, $old, $validated);

        return redirect()->route('employees.index')
            ->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy(Employee $employee)
    {
        $this->logDelete($employee);
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Funcionário removido com sucesso!');
    }

    public function export(Request $request)
    {
        $export = new EmployeeExport();
        $export->export($request->status);
    }
}
