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

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());
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
        $validated = $request->validate($this->validationRules($notebook->id));

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

    private function validationRules(?int $ignoreId = null): array
    {
        $uniqueNumeroSerie = $ignoreId
            ? "required|string|max:255|unique:notebooks,numero_serie,{$ignoreId}"
            : 'required|string|max:255|unique:notebooks,numero_serie';
        $uniquePatrimonio = $ignoreId
            ? "nullable|string|max:255|unique:notebooks,patrimonio,{$ignoreId}"
            : 'nullable|string|max:255|unique:notebooks,patrimonio';

        return [
            // Dados básicos
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'numero_serie' => $uniqueNumeroSerie,
            'patrimonio' => $uniquePatrimonio,
            'status' => 'required|in:disponivel,em_uso,manutencao,ocioso,devolvido,obsoleto,baixa,extraviado,transferido,alugado',
            'funcionario_id' => 'nullable|exists:employees,id',
            'data_entrega' => 'nullable|date',
            'sistema_operacional' => 'nullable|string|max:255',
            'ram_gb' => 'nullable|numeric|min:1',
            'armazenamento' => 'nullable|string|max:255',
            'processador' => 'nullable|string|max:255',
            'data_aquisicao' => 'nullable|date',
            'data_garantia' => 'nullable|date|after_or_equal:data_aquisicao',
            'observacoes' => 'nullable|string',
            'forncedor' => 'nullable|string|max:255',
            'preco' => 'nullable|numeric|min:0',

            // ISO 27001 — Classificação (A.5.12)
            'classificacao' => 'nullable|in:publica,interna,restrita,confidencial',

            // ISO 27001 — Localização (A.5.9)
            'localizacao' => 'nullable|string|max:255',
            'predio' => 'nullable|string|max:255',
            'andar' => 'nullable|string|max:255',
            'sala' => 'nullable|string|max:255',

            // ISO 27001 — Ciclo de vida (A.5.9, A.5.11, A.7.14)
            'criticidade' => 'nullable|in:baixo,medio,alto,critico',
            'data_vida_util' => 'nullable|date',
            'data_baixa' => 'nullable|date',
            'motivo_baixa' => 'nullable|in:obsolescencia,avaria,furto,descarte_seguro,doacao,venda,transferencia',
            'metodo_descarte' => 'nullable|in:destruicao_fisica,reciclagem,limpeza_dados,doacao,venda',

            // ISO 27001 — Segurança do dispositivo (A.8.1, A.8.8, A.8.13)
            'criptografia' => 'nullable|boolean',
            'antivirus' => 'nullable|boolean',
            'status_patches' => 'nullable|in:atualizado,desatualizado,critico,nao_verificado',
            'backup_configurado' => 'nullable|boolean',

            // ISO 27001 — Manutenção (A.7.13)
            'ultima_manutencao' => 'nullable|date',
            'proxima_manutencao' => 'nullable|date|after_or_equal:ultima_manutencao',
            'historico_manutencao' => 'nullable|string',

            // Aluguel
            'empresa_locataria' => 'nullable|string|max:255',
            'numero_contrato' => 'nullable|string|max:255',
            'valor_aluguel' => 'nullable|numeric|min:0',
            'periodo_aluguel' => 'nullable|in:mensal,trimestral,semestral,anual',
            'data_inicio_aluguel' => 'nullable|date',
            'data_fim_aluguel' => 'nullable|date|after_or_equal:data_inicio_aluguel',
        ];
    }
}
