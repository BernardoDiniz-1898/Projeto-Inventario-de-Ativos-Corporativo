@props(['logs'])

<div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">{{ __('activity.title') }}</h3>
    </div>

    @if ($logs->isEmpty())
        <div class="p-8 text-center text-slate-400 text-sm">{{ __('activity.empty') }}</div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach ($logs as $log)
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-slate-700 text-sm">{{ $log->user->name ?? __('activity.system') }}</span>
                            @if ($log->action === 'created')
                                <span class="px-1.5 py-0.5 rounded text-[11px] font-medium bg-emerald-50 text-emerald-700">{{ __('activity.action.created') }}</span>
                            @elseif ($log->action === 'updated')
                                <span class="px-1.5 py-0.5 rounded text-[11px] font-medium bg-amber-50 text-amber-700">{{ __('activity.action.updated') }}</span>
                                <span class="text-[11px] text-slate-400">{{ count($log->new_values) }} {{ __('activity.fields_count') }}</span>
                            @elseif ($log->action === 'deleted')
                                <span class="px-1.5 py-0.5 rounded text-[11px] font-medium bg-red-50 text-red-700">{{ __('activity.action.deleted') }}</span>
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
                                        'status' => __('activity.fields.status'),
                                        'marca' => __('activity.fields.marca'), 'modelo' => __('activity.fields.modelo'), 'numero_serie' => __('activity.fields.numero_serie'),
                                        'patrimonio' => __('activity.fields.patrimonio'), 'funcionario_id' => __('activity.fields.funcionario_id'),
                                        'sistema_operacional' => __('activity.fields.sistema_operacional'), 'ram_gb' => __('activity.fields.ram_gb'),
                                        'armazenamento' => __('activity.fields.armazenamento'), 'processador' => __('activity.fields.processador'),
                                        'data_aquisicao' => __('activity.fields.data_aquisicao'), 'data_garantia' => __('activity.fields.data_garantia'),
                                        'data_entrega' => __('activity.fields.data_entrega'),
                                        'preco' => __('activity.fields.preco'), 'fornecedor' => __('activity.fields.fornecedor'),
                                        'observacoes' => __('activity.fields.observacoes'), 'classificacao' => __('activity.fields.classificacao'),
                                        'localizacao' => __('activity.fields.localizacao'), 'predio' => __('activity.fields.predio'),
                                        'andar' => __('activity.fields.andar'), 'sala' => __('activity.fields.sala'), 'criticidade' => __('activity.fields.criticidade'),
                                        'criptografia' => __('activity.fields.criptografia'), 'antivirus' => __('activity.fields.antivirus'),
                                        'status_patches' => __('activity.fields.status_patches'), 'backup_configurado' => __('activity.fields.backup_configurado'),
                                        'ultima_manutencao' => __('activity.fields.ultima_manutencao'), 'proxima_manutencao' => __('activity.fields.proxima_manutencao'),
                                        'historico_manutencao' => __('activity.fields.historico_manutencao'), 'data_vida_util' => __('activity.fields.data_vida_util'),
                                        'data_baixa' => __('activity.fields.data_baixa'), 'motivo_baixa' => __('activity.fields.motivo_baixa'),
                                        'metodo_descarte' => __('activity.fields.metodo_descarte'),
                                        'empresa_locataria' => __('activity.fields.empresa_locataria'), 'numero_contrato' => __('activity.fields.numero_contrato'),
                                        'valor_aluguel' => __('activity.fields.valor_aluguel'), 'periodo_aluguel' => __('activity.fields.periodo_aluguel'),
                                        'data_inicio_aluguel' => __('activity.fields.data_inicio_aluguel'), 'data_fim_aluguel' => __('activity.fields.data_fim_aluguel'),
                                        'nome' => __('activity.fields.nome'), 'email' => __('activity.fields.email'), 'departamento' => __('activity.fields.departamento'),
                                        'centro_custo' => __('activity.fields.centro_custo'), 'projeto' => __('activity.fields.projeto'),
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
