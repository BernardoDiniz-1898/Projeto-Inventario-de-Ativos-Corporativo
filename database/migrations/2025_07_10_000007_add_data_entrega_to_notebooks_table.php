<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->date('data_entrega')->nullable()->after('funcionario_id');
        });
    }

    public function down(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->dropColumn('data_entrega');
        });
    }
};
