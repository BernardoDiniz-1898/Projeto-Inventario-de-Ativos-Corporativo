<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocalizacaoRequest;
use App\Http\Requests\UpdateLocalizacaoRequest;
use App\Models\Grupo;
use App\Models\Localizacao;
use App\Traits\LogsChanges;
use Illuminate\Http\Request;

class LocalizacaoController extends Controller
{
    use LogsChanges;

    public function index(Request $request)
    {
        $query = Localizacao::with('grupo')->withCount('notebooks');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('predio', 'like', "%{$search}%")
                    ->orWhere('andar', 'like', "%{$search}%")
                    ->orWhere('sala', 'like', "%{$search}%")
                    ->orWhereHas('grupo', function ($q2) use ($search) {
                        $q2->where('nome', 'like', "%{$search}%");
                    });
            });
        }

        $localizacoes = $query->latest()->paginate(15)->withQueryString();

        return view('localizacoes.index', compact('localizacoes'));
    }

    public function create()
    {
        $grupos = Grupo::orderBy('nome')->get();

        return view('localizacoes.create', compact('grupos'));
    }

    public function store(StoreLocalizacaoRequest $request)
    {
        $validated = $request->validated();
        $localizacao = Localizacao::create($validated);
        $this->logCreate($localizacao, $validated);

        return redirect()->route('localizacoes.index')
            ->with('success', __('messages.localizacao_created'));
    }

    public function show(Localizacao $localizacao)
    {
        $localizacao->load(['grupo', 'notebooks' => function ($q) {
            $q->with('funcionario')->latest();
        }]);

        $stats = [
            'total_notebooks' => $localizacao->notebooks->count(),
            'allocated' => $localizacao->notebooks->whereNotNull('funcionario_id')->count(),
            'available' => $localizacao->notebooks->where('status', 'disponivel')->count(),
        ];

        return view('localizacoes.show', compact('localizacao', 'stats'));
    }

    public function edit(Localizacao $localizacao)
    {
        $grupos = Grupo::orderBy('nome')->get();

        return view('localizacoes.edit', compact('localizacao', 'grupos'));
    }

    public function update(UpdateLocalizacaoRequest $request, Localizacao $localizacao)
    {
        $validated = $request->validated();
        $old = $localizacao->only(array_keys($validated));
        $localizacao->update($validated);
        $this->logUpdate($localizacao, $old, $validated);

        return redirect()->route('localizacoes.index')
            ->with('success', __('messages.localizacao_updated'));
    }

    public function destroy(Localizacao $localizacao)
    {
        $this->logDelete($localizacao);
        $localizacao->delete();

        return redirect()->route('localizacoes.index')
            ->with('success', __('messages.localizacao_deleted'));
    }
}
