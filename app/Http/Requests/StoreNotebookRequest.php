<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotebookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255|unique:notebooks,numero_serie',
            'patrimonio' => 'nullable|string|max:255|unique:notebooks,patrimonio',
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
            'fornecedor' => 'nullable|string|max:255',
            'preco' => 'nullable|numeric|min:0',
            'classificacao' => 'nullable|in:publica,interna,restrita,confidencial',
            'localizacao' => 'nullable|string|max:255',
            'predio' => 'nullable|string|max:255',
            'andar' => 'nullable|string|max:255',
            'sala' => 'nullable|string|max:255',
            'criticidade' => 'nullable|in:baixo,medio,alto,critico',
            'data_vida_util' => 'nullable|date',
            'data_baixa' => 'nullable|date',
            'motivo_baixa' => 'nullable|in:obsolescencia,avaria,furto,descarte_seguro,doacao,venda,transferencia',
            'metodo_descarte' => 'nullable|in:destruicao_fisica,reciclagem,limpeza_dados,doacao,venda',
            'criptografia' => 'nullable|boolean',
            'antivirus' => 'nullable|boolean',
            'status_patches' => 'nullable|in:atualizado,desatualizado,critico,nao_verificado',
            'backup_configurado' => 'nullable|boolean',
            'ultima_manutencao' => 'nullable|date',
            'proxima_manutencao' => 'nullable|date|after_or_equal:ultima_manutencao',
            'historico_manutencao' => 'nullable|string',
            'empresa_locataria' => 'nullable|string|max:255',
            'numero_contrato' => 'nullable|string|max:255',
            'valor_aluguel' => 'nullable|numeric|min:0',
            'periodo_aluguel' => 'nullable|in:mensal,trimestral,semestral,anual',
            'data_inicio_aluguel' => 'nullable|date',
            'data_fim_aluguel' => 'nullable|date|after_or_equal:data_inicio_aluguel',
        ];
    }
}
