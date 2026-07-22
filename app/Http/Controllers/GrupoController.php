<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;
use App\Models\Grupo;
use App\Traits\LogsChanges;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    use LogsChanges;

    public function index(Request $request)
    {
        $query = Grupo::withCount(['notebooks', 'employees']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        $grupos = $query->latest()->paginate(15)->withQueryString();

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos.create');
    }

    public function store(StoreGrupoRequest $request)
    {
        $validated = $request->validated();
        $grupo = Grupo::create($validated);
        $this->logCreate($grupo, $validated);

        return redirect()->route('grupos.index')
            ->with('success', __('messages.grupo_created'));
    }

    public function show(Grupo $grupo)
    {
        $grupo->load(['notebooks' => function ($q) {
            $q->with('funcionario')->latest();
        }, 'employees' => function ($q) {
            $q->withCount('notebooks')->latest();
        }]);

        $stats = [
            'total_notebooks' => $grupo->notebooks->count(),
            'total_employees' => $grupo->employees->count(),
            'allocated' => $grupo->notebooks->whereNotNull('funcionario_id')->count(),
            'available' => $grupo->notebooks->where('status', 'disponivel')->count(),
            'maintenance' => $grupo->notebooks->where('status', 'manutencao')->count(),
        ];

        return view('grupos.show', compact('grupo', 'stats'));
    }

    public function edit(Grupo $grupo)
    {
        return view('grupos.edit', compact('grupo'));
    }

    public function update(UpdateGrupoRequest $request, Grupo $grupo)
    {
        $validated = $request->validated();
        $old = $grupo->only(array_keys($validated));
        $grupo->update($validated);
        $this->logUpdate($grupo, $old, $validated);

        return redirect()->route('grupos.index')
            ->with('success', __('messages.grupo_updated'));
    }

    public function destroy(Grupo $grupo)
    {
        $this->logDelete($grupo);
        $grupo->delete();

        return redirect()->route('grupos.index')
            ->with('success', __('messages.grupo_deleted'));
    }
}
