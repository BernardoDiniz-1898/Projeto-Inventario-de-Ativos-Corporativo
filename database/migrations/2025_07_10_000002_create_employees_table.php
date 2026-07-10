<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('matricula')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('telefone')->nullable();
            $table->string('departamento')->nullable();
            $table->string('centro_custo')->nullable();
            $table->string('projeto')->nullable();
            $table->string('setor')->nullable();
            $table->string('cargo')->nullable();
            $table->enum('status', ['ativo', 'afastado', 'desligado','ferias'])->default('ativo');
            $table->date('data_admissao')->nullable();
            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
