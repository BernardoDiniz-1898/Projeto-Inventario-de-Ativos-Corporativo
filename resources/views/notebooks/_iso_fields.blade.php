@php $n = $notebook ?? null; @endphp

{{-- ═══ ISO 27001 — CLASSIFICAÇÃO (A.5.12) ═══ --}}
<div class="md:col-span-2 lg:col-span-3 mt-2">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-6 h-6 bg-red-100 rounded flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h3 class="text-sm font-bold text-slate-600 uppercase tracking-wider">Classificação — ISO 27001 A.5.12</h3>
    </div>
</div>

<div>
    <label for="classificacao" class="block text-sm font-semibold text-gray-700 mb-2">Nível de classificação</label>
    <select id="classificacao" name="classificacao"
            class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('classificacao') border-red-300 @enderror">
        <option value="">Selecione...</option>
        <option value="publica" {{ old('classificacao', $n->classificacao ?? '') === 'publica' ? 'selected' : '' }}>Pública</option>
        <option value="interna" {{ old('classificacao', $n->classificacao ?? '') === 'interna' ? 'selected' : '' }}>Interna</option>
        <option value="restrita" {{ old('classificacao', $n->classificacao ?? '') === 'restrita' ? 'selected' : '' }}>Restrita</option>
        <option value="confidencial" {{ old('classificacao', $n->classificacao ?? '') === 'confidencial' ? 'selected' : '' }}>Confidencial</option>
    </select>
    @error('classificacao') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div class="md:col-span-2 lg:col-span-3 mt-2">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-6 h-6 bg-blue-100 rounded flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <h3 class="text-sm font-bold text-slate-600 uppercase tracking-wider">Localização — ISO 27001 A.5.9</h3>
    </div>
</div>

<div>
    <label for="localizacao" class="block text-sm font-semibold text-gray-700 mb-2">Localização geral</label>
    <input type="text" id="localizacao" name="localizacao" value="{{ old('localizacao', $n->localizacao ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('localizacao') border-red-300 @enderror"
           placeholder="Ex: Matriz, Filial, Datacenter...">
    @error('localizacao') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="predio" class="block text-sm font-semibold text-gray-700 mb-2">Prédio</label>
    <input type="text" id="predio" name="predio" value="{{ old('predio', $n->predio ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('predio') border-red-300 @enderror"
           placeholder="Ex: Bloco A, Torre Norte...">
    @error('predio') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="andar" class="block text-sm font-semibold text-gray-700 mb-2">Andar</label>
    <input type="text" id="andar" name="andar" value="{{ old('andar', $n->andar ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('andar') border-red-300 @enderror"
           placeholder="Ex: 3º andar">
    @error('andar') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="sala" class="block text-sm font-semibold text-gray-700 mb-2">Sala</label>
    <input type="text" id="sala" name="sala" value="{{ old('sala', $n->sala ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('sala') border-red-300 @enderror"
           placeholder="Ex: Sala 301, Sala Servidores...">
    @error('sala') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div class="md:col-span-2 lg:col-span-3 mt-2">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-6 h-6 bg-amber-100 rounded flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="text-sm font-bold text-slate-600 uppercase tracking-wider">Ciclo de Vida — ISO 27001 A.5.9 / A.5.11 / A.7.14</h3>
    </div>
</div>

<div>
    <label for="criticidade" class="block text-sm font-semibold text-gray-700 mb-2">Criticidade</label>
    <select id="criticidade" name="criticidade"
            class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('criticidade') border-red-300 @enderror">
        <option value="">Selecione...</option>
        <option value="baixo" {{ old('criticidade', $n->criticidade ?? '') === 'baixo' ? 'selected' : '' }}>Baixo</option>
        <option value="medio" {{ old('criticidade', $n->criticidade ?? '') === 'medio' ? 'selected' : '' }}>Médio</option>
        <option value="alto" {{ old('criticidade', $n->criticidade ?? '') === 'alto' ? 'selected' : '' }}>Alto</option>
        <option value="critico" {{ old('criticidade', $n->criticidade ?? '') === 'critico' ? 'selected' : '' }}>Crítico</option>
    </select>
    @error('criticidade') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="data_vida_util" class="block text-sm font-semibold text-gray-700 mb-2">Fim da vida útil</label>
    <input type="date" id="data_vida_util" name="data_vida_util" value="{{ old('data_vida_util', $n->data_vida_util?->format('Y-m-d') ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('data_vida_util') border-red-300 @enderror">
    @error('data_vida_util') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="data_baixa" class="block text-sm font-semibold text-gray-700 mb-2">Data de baixa</label>
    <input type="date" id="data_baixa" name="data_baixa" value="{{ old('data_baixa', $n->data_baixa?->format('Y-m-d') ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('data_baixa') border-red-300 @enderror">
    @error('data_baixa') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="motivo_baixa" class="block text-sm font-semibold text-gray-700 mb-2">Motivo da baixa</label>
    <select id="motivo_baixa" name="motivo_baixa"
            class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('motivo_baixa') border-red-300 @enderror">
        <option value="">Selecione...</option>
        <option value="obsolescencia" {{ old('motivo_baixa', $n->motivo_baixa ?? '') === 'obsolescencia' ? 'selected' : '' }}>Obsolescência</option>
        <option value="avaria" {{ old('motivo_baixa', $n->motivo_baixa ?? '') === 'avaria' ? 'selected' : '' }}>Avaria</option>
        <option value="furto" {{ old('motivo_baixa', $n->motivo_baixa ?? '') === 'furto' ? 'selected' : '' }}>Furto/Extravio</option>
        <option value="descarte_seguro" {{ old('motivo_baixa', $n->motivo_baixa ?? '') === 'descarte_seguro' ? 'selected' : '' }}>Descarte Seguro</option>
        <option value="doacao" {{ old('motivo_baixa', $n->motivo_baixa ?? '') === 'doacao' ? 'selected' : '' }}>Doação</option>
        <option value="venda" {{ old('motivo_baixa', $n->motivo_baixa ?? '') === 'venda' ? 'selected' : '' }}>Venda</option>
        <option value="transferencia" {{ old('motivo_baixa', $n->motivo_baixa ?? '') === 'transferencia' ? 'selected' : '' }}>Transferência</option>
    </select>
    @error('motivo_baixa') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="metodo_descarte" class="block text-sm font-semibold text-gray-700 mb-2">Método de descarte</label>
    <select id="metodo_descarte" name="metodo_descarte"
            class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('metodo_descarte') border-red-300 @enderror">
        <option value="">Selecione...</option>
        <option value="destruicao_fisica" {{ old('metodo_descarte', $n->metodo_descarte ?? '') === 'destruicao_fisica' ? 'selected' : '' }}>Destruição Física</option>
        <option value="reciclagem" {{ old('metodo_descarte', $n->metodo_descarte ?? '') === 'reciclagem' ? 'selected' : '' }}>Reciclagem Certificada</option>
        <option value="limpeza_dados" {{ old('metodo_descarte', $n->metodo_descarte ?? '') === 'limpeza_dados' ? 'selected' : '' }}>Limpeza de Dados</option>
        <option value="doacao" {{ old('metodo_descarte', $n->metodo_descarte ?? '') === 'doacao' ? 'selected' : '' }}>Doação</option>
        <option value="venda" {{ old('metodo_descarte', $n->metodo_descarte ?? '') === 'venda' ? 'selected' : '' }}>Venda</option>
    </select>
    @error('metodo_descarte') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div class="md:col-span-2 lg:col-span-3 mt-2">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-6 h-6 bg-emerald-100 rounded flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h3 class="text-sm font-bold text-slate-600 uppercase tracking-wider">Segurança do Dispositivo — ISO 27001 A.8.1 / A.8.8 / A.8.13</h3>
    </div>
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Criptografia de disco</label>
    <div class="flex items-center gap-3 h-[46px]">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="criptografia" value="0">
            <input type="checkbox" name="criptografia" value="1"
                   {{ old('criptografia', $n->criptografia ?? '') ? 'checked' : '' }}
                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <span class="text-sm text-gray-700">Ativada</span>
        </label>
    </div>
    @error('criptografia') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Antivírus</label>
    <div class="flex items-center gap-3 h-[46px]">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="antivirus" value="0">
            <input type="checkbox" name="antivirus" value="1"
                   {{ old('antivirus', $n->antivirus ?? '') ? 'checked' : '' }}
                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <span class="text-sm text-gray-700">Ativado</span>
        </label>
    </div>
    @error('antivirus') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="status_patches" class="block text-sm font-semibold text-gray-700 mb-2">Status de patches</label>
    <select id="status_patches" name="status_patches"
            class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('status_patches') border-red-300 @enderror">
        <option value="">Selecione...</option>
        <option value="atualizado" {{ old('status_patches', $n->status_patches ?? '') === 'atualizado' ? 'selected' : '' }}>Atualizado</option>
        <option value="desatualizado" {{ old('status_patches', $n->status_patches ?? '') === 'desatualizado' ? 'selected' : '' }}>Desatualizado</option>
        <option value="critico" {{ old('status_patches', $n->status_patches ?? '') === 'critico' ? 'selected' : '' }}>Crítico (sem patches de segurança)</option>
        <option value="nao_verificado" {{ old('status_patches', $n->status_patches ?? '') === 'nao_verificado' ? 'selected' : '' }}>Não verificado</option>
    </select>
    @error('status_patches') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Backup configurado</label>
    <div class="flex items-center gap-3 h-[46px]">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="backup_configurado" value="0">
            <input type="checkbox" name="backup_configurado" value="1"
                   {{ old('backup_configurado', $n->backup_configurado ?? '') ? 'checked' : '' }}
                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <span class="text-sm text-gray-700">Sim</span>
        </label>
    </div>
    @error('backup_configurado') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div class="md:col-span-2 lg:col-span-3 mt-2">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-6 h-6 bg-purple-100 rounded flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <h3 class="text-sm font-bold text-slate-600 uppercase tracking-wider">Manutenção — ISO 27001 A.7.13</h3>
    </div>
</div>

<div>
    <label for="ultima_manutencao" class="block text-sm font-semibold text-gray-700 mb-2">Última manutenção</label>
    <input type="date" id="ultima_manutencao" name="ultima_manutencao" value="{{ old('ultima_manutencao', $n->ultima_manutencao?->format('Y-m-d') ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ultima_manutencao') border-red-300 @enderror">
    @error('ultima_manutencao') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div>
    <label for="proxima_manutencao" class="block text-sm font-semibold text-gray-700 mb-2">Próxima manutenção</label>
    <input type="date" id="proxima_manutencao" name="proxima_manutencao" value="{{ old('proxima_manutencao', $n->proxima_manutencao?->format('Y-m-d') ?? '') }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('proxima_manutencao') border-red-300 @enderror">
    @error('proxima_manutencao') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>

<div class="md:col-span-2 lg:col-span-3">
    <label for="historico_manutencao" class="block text-sm font-semibold text-gray-700 mb-2">Histórico de manutenção</label>
    <textarea id="historico_manutencao" name="historico_manutencao" rows="3"
              class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('historico_manutencao') border-red-300 @enderror"
              placeholder="Descreva manutenções anteriores, reparos, trocas de peças...">{{ old('historico_manutencao', $n->historico_manutencao ?? '') }}</textarea>
    @error('historico_manutencao') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
</div>
