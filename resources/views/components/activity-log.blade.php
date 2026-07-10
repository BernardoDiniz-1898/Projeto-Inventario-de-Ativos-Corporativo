@props(['logs'])

@php
    $fieldLabels = [
        'marca' => 'Marca', 'modelo' => 'Modelo', 'numero_serie' => 'Nº Série',
        'patrimonio' => 'Patrimônio', 'status' => 'Status', 'funcionario_id' => 'Responsável',
        'sistema_operacional' => 'Sistema Operacional', 'ram_gb' => 'RAM',
        'armazenamento' => 'Armazenamento', 'processador' => 'Processador',
        'data_aquisicao' => 'Data de Aquisição', 'data_garantia' => 'Garantia até',
        'observacoes' => 'Observações', 'forncedor' => 'Fornecedor', 'preco' => 'Preço',
        'nome' => 'Nome', 'matricula' => 'Matrícula', 'email' => 'Email',
        'telefone' => 'Telefone', 'departamento' => 'Departamento',
        'centro_custo' => 'Centro de Custo', 'projeto' => 'Projeto',
        'setor' => 'Setor', 'cargo' => 'Cargo', 'data_admissao' => 'Data de Admissão',
    ];
    $statusLabels = [
        'disponivel' => 'Disponível', 'em_uso' => 'Em Uso', 'manutencao' => 'Manutenção',
        'ocioso' => 'Ocioso', 'devolvido' => 'Devolvido', 'obsoleto' => 'Obsoleto',
        'ativo' => 'Ativo', 'afastado' => 'Afastado', 'desligado' => 'Desligado', 'ferias' => 'Férias',
    ];
@endphp

<div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Histórico de Alterações</h3>
    </div>

    @if ($logs->isEmpty())
        <div class="p-8 text-center">
            <p class="text-slate-400 text-sm">Nenhum registro de alteração</p>
        </div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach ($logs as $log)
                @php
                    $actionMap = [
                        'created' => ['bg-green-100 text-green-700', 'Criado'],
                        'updated' => ['bg-amber-100 text-amber-700', 'Atualizado'],
                        'deleted' => ['bg-red-100 text-red-700', 'Excluído'],
                    ];
                    [$colorClass, $actionLabel] = $actionMap[$log->action] ?? ['bg-slate-100 text-slate-700', $log->action];
                @endphp
                <div class="px-6 py-4 hover:bg-slate-50 transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <div class="w-8 h-8 bg-slate-600 text-white rounded-md flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                                {{ $log->user ? strtoupper(substr($log->user->name, 0, 2)) : '??' }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-semibold text-slate-800 text-sm">{{ $log->user->name ?? 'Sistema' }}</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-semibold {{ $colorClass }}">{{ $actionLabel }}</span>
                                </div>

                                @if ($log->action === 'updated' && $log->old_values && $log->new_values)
                                    <div class="mt-2 space-y-1">
                                        @foreach ($log->new_values as $key => $newValue)
                                            @php
                                                $oldValue = $log->old_values[$key] ?? null;
                                                $label = $fieldLabels[$key] ?? $key;

                                                $displayOld = $oldValue;
                                                $displayNew = $newValue;

                                                if ($key === 'status' && isset($statusLabels[$oldValue])) {
                                                    $displayOld = $statusLabels[$oldValue];
                                                }
                                                if ($key === 'status' && isset($statusLabels[$newValue])) {
                                                    $displayNew = $statusLabels[$newValue];
                                                }
                                                if ($key === 'preco' && is_numeric($oldValue)) {
                                                    $displayOld = 'R$ ' . number_format((float)$oldValue, 2, ',', '.');
                                                }
                                                if ($key === 'preco' && is_numeric($newValue)) {
                                                    $displayNew = 'R$ ' . number_format((float)$newValue, 2, ',', '.');
                                                }
                                                if ($key === 'ram_gb' && $oldValue) {
                                                    $displayOld = $oldValue . ' GB';
                                                }
                                                if ($key === 'ram_gb' && $newValue) {
                                                    $displayNew = $newValue . ' GB';
                                                }
                                                if (in_array($key, ['data_aquisicao', 'data_garantia', 'data_admissao'])) {
                                                    $displayOld = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('d/m/Y') : '—';
                                                    $displayNew = $newValue ? \Carbon\Carbon::parse($newValue)->format('d/m/Y') : '—';
                                                }
                                                if ($displayOld === null || $displayOld === '') $displayOld = '—';
                                                if ($displayNew === null || $displayNew === '') $displayNew = '—';
                                            @endphp
                                            <div class="flex items-center gap-2 text-xs">
                                                <span class="font-semibold text-slate-600">{{ $label }}:</span>
                                                <span class="text-red-500 line-through">{{ $displayOld }}</span>
                                                <svg class="w-3 h-3 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                <span class="text-green-600 font-medium">{{ $displayNew }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($log->action === 'created' && $log->new_values)
                                    <p class="text-xs text-slate-500 mt-1">Registro criado no sistema</p>
                                @elseif ($log->action === 'deleted')
                                    <p class="text-xs text-slate-500 mt-1">Registro removido do sistema</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 whitespace-nowrap flex-shrink-0 mt-1">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="px-6 py-3 border-t border-slate-200 bg-slate-50">
            {{ $logs->links() }}
        </div>
    @endif
</div>
