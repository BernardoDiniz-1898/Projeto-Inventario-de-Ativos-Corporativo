<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupo_notebook', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('notebook_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['grupo_id', 'notebook_id']);
        });

        Schema::create('grupo_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['grupo_id', 'employee_id']);
        });

        // Migrate existing grupo_id data into pivot tables
        $notebookRows = DB::table('notebooks')
            ->whereNotNull('grupo_id')
            ->select('grupo_id', 'id')
            ->get();

        foreach ($notebookRows as $row) {
            DB::table('grupo_notebook')->insert([
                'grupo_id' => $row->grupo_id,
                'notebook_id' => $row->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $employeeRows = DB::table('employees')
            ->whereNotNull('grupo_id')
            ->select('grupo_id', 'id')
            ->get();

        foreach ($employeeRows as $row) {
            DB::table('grupo_employee')->insert([
                'grupo_id' => $row->grupo_id,
                'employee_id' => $row->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('notebooks', function (Blueprint $table) {
            $table->dropForeign(['grupo_id']);
            $table->dropColumn('grupo_id');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['grupo_id']);
            $table->dropColumn('grupo_id');
        });
    }

    public function down(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->foreignId('grupo_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('grupo_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::dropIfExists('grupo_employee');
        Schema::dropIfExists('grupo_notebook');
    }
};
