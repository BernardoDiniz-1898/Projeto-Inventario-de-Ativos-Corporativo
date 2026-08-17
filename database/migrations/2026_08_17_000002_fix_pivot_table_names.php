<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create the correctly named tables (alphabetical order)
        Schema::create('notebook_grupo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('notebook_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['grupo_id', 'notebook_id']);
        });

        Schema::create('employee_grupo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['grupo_id', 'employee_id']);
        });

        // Migrate data from old tables
        if (Schema::hasTable('grupo_notebook')) {
            $rows = DB::table('grupo_notebook')->get();
            foreach ($rows as $row) {
                DB::table('notebook_grupo')->insert([
                    'grupo_id' => $row->grupo_id,
                    'notebook_id' => $row->notebook_id,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            }
            Schema::dropIfExists('grupo_notebook');
        }

        if (Schema::hasTable('grupo_employee')) {
            $rows = DB::table('grupo_employee')->get();
            foreach ($rows as $row) {
                DB::table('employee_grupo')->insert([
                    'grupo_id' => $row->grupo_id,
                    'employee_id' => $row->employee_id,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            }
            Schema::dropIfExists('grupo_employee');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_grupo');
        Schema::dropIfExists('notebook_grupo');
    }
};
