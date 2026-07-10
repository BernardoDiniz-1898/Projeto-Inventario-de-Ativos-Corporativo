<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->string('empresa_locataria')->nullable()->after('status');
            $table->string('numero_contrato')->nullable()->after('empresa_locataria');
            $table->decimal('valor_aluguel', 10, 2)->nullable()->after('numero_contrato');
            $table->enum('periodo_aluguel', ['mensal', 'trimestral', 'semestral', 'anual'])->nullable()->after('valor_aluguel');
            $table->date('data_inicio_aluguel')->nullable()->after('periodo_aluguel');
            $table->date('data_fim_aluguel')->nullable()->after('data_inicio_aluguel');
        });
    }

    public function down(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->dropColumn([
                'empresa_locataria', 'numero_contrato', 'valor_aluguel',
                'periodo_aluguel', 'data_inicio_aluguel', 'data_fim_aluguel',
            ]);
        });
    }
};
