<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->foreignId('funcionario_id')->nullable()->after('patrimonio')->constrained('employees')->nullOnDelete();
            $table->dropColumn(['responsavel', 'departamento']);
        });
    }

    public function down(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->string('responsavel')->nullable();
            $table->string('departamento')->nullable();
            $table->string('centro_custo')->nullable();
            $table->string('projeto')->nullable();
            $table->dropForeign(['funcionario_id']);
            $table->dropColumn('funcionario_id');
        });
    }
};
