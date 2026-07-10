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
        'classificacao' => 'Classificação', 'localizacao' => 'Localização',
        'predio' => 'Prédio', 'andar' => 'Andar', 'sala' => 'Sala',
        'criticidade' => 'Criticidade', 'data_vida_util' => 'Vida útil',
        'data_baixa' => 'Data de baixa', 'motivo_baixa' => 'Motivo da baixa',
        'metodo_descarte' => 'Método de descarte',
        'criptografia' => 'Criptografia', 'antivirus' => 'Antivírus',
        'status_patches' => 'Patches', 'backup_configurado' => 'Backup',
        'ultima_manutencao' => 'Última manutenção', 'proxima_manutencao' => 'Próxima manutenção',
        'historico_manutencao' => 'Histórico de manutenção',
    ];
    $statusLabels = [
        'disponivel' => 'Disponível', 'em_uso' => 'Em Uso', 'manutencao' => 'Manutenção',
        'ocioso' => 'Ocioso', 'devolvido' => 'Devolvido', 'obsoleto' => 'Obsoleto',
        'baixa' => 'Baixa', 'extraviado' => 'Extraviado', 'transferido' => 'Transferido',
        'ativo' => 'Ativo', 'afastado' => 'Afastado', 'desligado' => 'Desligado', 'ferias' => 'Férias',
        'publica' => 'Pública', 'interna' => 'Interna', 'restrita' => 'Restrita', 'confidencial' => 'Confidencial',
        'baixo' => 'Baixo', 'medio' => 'Médio', 'alto' => 'Alto', 'critico' => 'Crítico',
        'atualizado' => 'Atualizado', 'desatualizado' => 'Desatualizado',
        'nao_verificado' => 'Não verificado',
        'obsolescencia' => 'Obsolescência', 'avaria' => 'Avaria', 'furto' => 'Furto/Extravio',
        'descarte_seguro' => 'Descarte Seguro', 'doacao' => 'Doação', 'venda' => 'Venda',
        'transferencia' => 'Transferência',
        'destruicao_fisica' => 'Destruição Física', 'reciclagem' => 'Reciclagem', 'limpeza_dados' => 'Limpeza de Dados',
    ];
    $actionStyles = [
        'created' => ['icon' => 'M12 4v16m8-8H4', 'bg' => 'bg-emerald-500', 'badge' => 'bg-emerald-100 text-emerald-700 border border-emerald-200', 'label' => 'Criação', 'border' => 'border-l-emerald-400'],
        'updated' => ['icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'bg' => 'bg-amber-500', 'badge' => 'bg-amber-100 text-amber-700 border border-amber-200', 'label' => 'Edição', 'border' => 'border-l-amber-400'],
        'deleted' => ['icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'bg' => 'bg-red-500', 'badge' => 'bg-red-100 text-red-700 border border-red-200', 'label' => 'Exclusão', 'border' => 'border-l-red-400'],
    ];
    $skipKeys = ['id', 'created_at', 'updated_at', 'funcionario_id', 'user_id', 'loggable_type', 'loggable_id', 'action', 'description'];
@endphp

<div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Histórico de Alterações
        </h3>
    </div>

    @if ($logs->isEmpty())
        <div class="p-8 text-center">
            <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-slate-400 text-sm">Nenhum registro de alteração</p>
        </div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach ($logs as $log)
                @php
                    $style = $actionStyles[$log->action] ?? $actionStyles['created'];
                    $isUpdate = $log->action === 'updated' && $log->old_values && $log->new_values;
                    $isCreate = $log->action === 'created' && $log->new_values;
                @endphp
                <div class="px-6 py-4 hover:bg-slate-50/50 transition border-l-4 {{ $style['border'] }}">
                    <div class="flex items-center justify-between gap-3 mb-1">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 {{ $style['bg'] }} text-white rounded-md flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-slate-700 text-sm">{{ $log->user->name ?? 'Sistema' }}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider {{ $style['badge'] }}">{{ $style['label'] }}</span>
                            @if ($isUpdate)
                                <span class="text-[11px] text-slate-400 font-medium">{{ count($log->new_values) }} campo(s) alterado(s)</span>
                            @endif
                        </div>
                        <span class="text-[11px] text-slate-400 whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <p class="text-xs text-slate-500 ml-9.5 mb-2">{{ $log->description }}</p>

                    {{-- ═══ EDIÇÃO ═══ --}}
                    @if ($isUpdate)
                        <div class="ml-9.5 mt-2 rounded-lg border border-slate-200 overflow-hidden">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th class="text-left px-3 py-1.5 font-semibold text-slate-600 uppercase tracking-wider" style="width: 28%">Campo</th>
                                        <th class="text-left px-3 py-1.5 font-semibold text-red-600 uppercase tracking-wider" style="width: 36%">Antes</th>
                                        <th class="text-center px-1 py-1.5" style="width: 2%"></th>
                                        <th class="text-left px-3 py-1.5 font-semibold text-emerald-600 uppercase tracking-wider" style="width: 36%">Depois</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($log->new_values as $key => $newValue)
                                        @php
                                            $oldValue = $log->old_values[$key] ?? null;
                                            $label = $fieldLabels[$key] ?? $key;
                                        @endphp
                                        <tr class="{{ $loop->even ? 'bg-white' : 'bg-slate-50/30' }}">
                                            <td class="px-3 py-2 font-semibold text-slate-700">{{ $label }}</td>
                                            <td class="px-3 py-2">
                                                @php
                                                    if ($key === 'status') { $dv = $statusLabels[$oldValue] ?? $oldValue; }
                                                    elseif ($key === 'preco' && is_numeric($oldValue)) { $dv = 'R$ ' . number_format((float)$oldValue, 2, ',', '.'); }
                                                    elseif ($key === 'ram_gb' && $oldValue) { $dv = $oldValue . ' GB'; }
                                                    elseif (in_array($key, ['data_aquisicao','data_garantia','data_vida_util','data_baixa','data_admissao','ultima_manutencao','proxima_manutencao'])) { $dv = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('d/m/Y') : '—'; }
                                                    elseif (in_array($key, ['criptografia','antivirus','backup_configurado'])) { $dv = $oldValue ? 'Sim' : 'Não'; }
                                                    else { $dv = $oldValue ?? '—'; }
                                                    if ($dv === null || $dv === '') $dv = '—';
                                                @endphp
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-red-50 text-red-600 border border-red-100">
                                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                                    {{ $dv }}
                                                </span>
                                            </td>
                                            <td class="px-1 py-2 text-center">
                                                <svg class="w-3.5 h-3.5 text-slate-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </td>
                                            <td class="px-3 py-2">
                                                @php
                                                    if ($key === 'status') { $dv2 = $statusLabels[$newValue] ?? $newValue; }
                                                    elseif ($key === 'preco' && is_numeric($newValue)) { $dv2 = 'R$ ' . number_format((float)$newValue, 2, ',', '.'); }
                                                    elseif ($key === 'ram_gb' && $newValue) { $dv2 = $newValue . ' GB'; }
                                                    elseif (in_array($key, ['data_aquisicao','data_garantia','data_vida_util','data_baixa','data_admissao','ultima_manutencao','proxima_manutencao'])) { $dv2 = $newValue ? \Carbon\Carbon::parse($newValue)->format('d/m/Y') : '—'; }
                                                    elseif (in_array($key, ['criptografia','antivirus','backup_configurado'])) { $dv2 = $newValue ? 'Sim' : 'Não'; }
                                                    else { $dv2 = $newValue ?? '—'; }
                                                    if ($dv2 === null || $dv2 === '') $dv2 = '—';
                                                @endphp
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                    {{ $dv2 }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    {{-- ═══ CRIAÇÃO ═══ --}}
                    @elseif ($isCreate)
                        @php
                            $filledFields = [];
                            foreach ($log->new_values as $k => $v) {
                                if ($v !== null && $v !== '' && !in_array($k, $skipKeys)) {
                                    $filledFields[$k] = $v;
                                }
                            }
                        @endphp
                        @if (count($filledFields) > 0)
                            <div class="ml-9.5 mt-2 rounded-lg border border-emerald-200 bg-emerald-50/50 p-3">
                                <div class="flex items-center gap-2 text-xs text-emerald-700 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="font-semibold">Registro criado</span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($filledFields as $key => $val)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] bg-white border border-slate-200 text-slate-600">
                                            <span class="font-semibold">{{ $fieldLabels[$key] ?? $key }}:</span>
                                            <span class="text-slate-800">{{ $val }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    {{-- ═══ EXCLUSÃO ═══ --}}
                    @elseif ($log->action === 'deleted' && $log->old_values)
                        @php
                            $oldFields = [];
                            foreach ($log->old_values as $k => $v) {
                                if ($v !== null && $v !== '' && !in_array($k, $skipKeys)) {
                                    $oldFields[$k] = $v;
                                }
                            }
                        @endphp
                        @if (count($oldFields) > 0)
                            <div class="ml-9.5 mt-2 rounded-lg border border-red-200 bg-red-50/50 p-3">
                                <div class="flex items-center gap-2 text-xs text-red-700 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span class="font-semibold">Registro removido</span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($oldFields as $key => $val)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] bg-white border border-red-100 text-slate-500 line-through">
                                            <span class="font-semibold">{{ $fieldLabels[$key] ?? $key }}:</span>
                                            <span>{{ is_string($val) ? \Illuminate\Support\Str::limit($val, 40) : $val }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>

        <div class="px-6 py-3 border-t border-slate-200 bg-slate-50">
            {{ $logs->links() }}
        </div>
    @endif
</div>
