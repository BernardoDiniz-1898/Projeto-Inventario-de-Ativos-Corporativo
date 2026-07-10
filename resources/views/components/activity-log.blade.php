@props(['logs'])

<div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Histórico de Alterações</h3>
    </div>

    @if ($logs->isEmpty())
        <div class="p-8 text-center text-slate-400 text-sm">Nenhum registro</div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach ($logs as $log)
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-slate-700 text-sm">{{ $log->user->name ?? 'Sistema' }}</span>
                            @if ($log->action === 'created')
                                <span class="px-1.5 py-0.5 rounded text-[11px] font-medium bg-emerald-50 text-emerald-700">criou</span>
                            @elseif ($log->action === 'updated')
                                <span class="px-1.5 py-0.5 rounded text-[11px] font-medium bg-amber-50 text-amber-700">editou</span>
                                <span class="text-[11px] text-slate-400">{{ count($log->new_values) }} campo(s)</span>
                            @elseif ($log->action === 'deleted')
                                <span class="px-1.5 py-0.5 rounded text-[11px] font-medium bg-red-50 text-red-700">excluiu</span>
                            @endif
                        </div>
                        <span class="text-[11px] text-slate-400">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <p class="text-xs text-slate-500 mb-2">{{ $log->description }}</p>

                    @if ($log->action === 'updated' && $log->old_values && $log->new_values)
                        <div class="ml-0 mt-2 text-xs space-y-1">
                            @foreach ($log->new_values as $key => $newValue)
                                @php
                                    $oldValue = $log->old_values[$key] ?? null;
                                    $label = match($key) {
                                        'status' => 'Status',
                                        'marca' => 'Marca', 'modelo' => 'Modelo', 'numero_serie' => 'Nº Série',
                                        'patrimonio' => 'Patrimônio', 'funcionario_id' => 'Responsável',
                                        'sistema_operacional' => 'SO', 'ram_gb' => 'RAM',
                                        'armazenamento' => 'Armazenamento', 'processador' => 'Processador',
                                        'data_aquisicao' => 'Aquisição', 'data_garantia' => 'Garantia',
                                        'preco' => 'Preço', 'forncedor' => 'Fornecedor',
                                        'observacoes' => 'Obs.', 'classificacao' => 'Classificação',
                                        'localizacao' => 'Localização', 'predio' => 'Prédio',
                                        'andar' => 'Andar', 'sala' => 'Sala', 'criticidade' => 'Criticidade',
                                        'criptografia' => 'Cript.', 'antivirus' => 'Antivírus',
                                        'status_patches' => 'Patches', 'backup_configurado' => 'Backup',
                                        'nome' => 'Nome', 'email' => 'Email', 'departamento' => 'Depto.',
                                        'centro_custo' => 'Centro Custo', 'projeto' => 'Projeto',
                                        default => $key,
                                    };
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-slate-600 w-28 text-right shrink-0">{{ $label }}:</span>
                                    <span class="text-red-500 line-through">{{ $oldValue ?? '—' }}</span>
                                    <span class="text-slate-400">→</span>
                                    <span class="text-emerald-600 font-medium">{{ $newValue ?? '—' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="px-6 py-3 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
    @endif
</div>
