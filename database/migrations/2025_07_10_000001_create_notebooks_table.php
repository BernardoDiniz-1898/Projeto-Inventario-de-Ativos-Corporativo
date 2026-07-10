<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notebooks', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->string('numero_serie')->unique();
            $table->string('patrimonio')->nullable()->unique();
            $table->enum('status', ['disponivel', 'em_uso', 'manutencao', 'ocioso', 'devolvido', 'obsoleto', 'baixa', 'extraviado', 'transferido', 'alugado'])->default('em_uso');
            $table->string('responsavel')->nullable();
            $table->string('departamento')->nullable();
            $table->string('sistema_operacional')->nullable();
            $table->decimal('ram_gb', 5, 1)->nullable();
            $table->string('armazenamento')->nullable();
            $table->string('processador')->nullable();
            $table->date('data_aquisicao')->nullable();
            $table->date('data_garantia')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('forncedor')->nullable();
            $table->decimal('preco')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notebooks');
    }
};
