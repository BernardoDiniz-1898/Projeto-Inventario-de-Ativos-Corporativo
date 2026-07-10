<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            // A.5.12 — Classificação da informação
            $table->string('classificacao')->nullable()->after('status');

            // A.5.9 — Localização do ativo
            $table->string('localizacao')->nullable()->after('classificacao');
            $table->string('predio')->nullable()->after('localizacao');
            $table->string('andar')->nullable()->after('predio');
            $table->string('sala')->nullable()->after('andar');

            // A.5.9 — Ciclo de vida do ativo
            $table->string('criticidade')->nullable()->after('sala');
            $table->date('data_vida_util')->nullable()->after('criticidade');
            $table->date('data_baixa')->nullable()->after('data_vida_util');
            $table->string('motivo_baixa')->nullable()->after('data_baixa');
            $table->string('metodo_descarte')->nullable()->after('motivo_baixa');

            // A.8.1 — Controles de segurança do dispositivo
            $table->boolean('criptografia')->default(false)->after('metodo_descarte');
            $table->boolean('antivirus')->default(false)->after('criptografia');
            $table->string('status_patches')->nullable()->after('antivirus');
            $table->boolean('backup_configurado')->default(false)->after('status_patches');

            // A.7.13 — Manutenção
            $table->date('ultima_manutencao')->nullable()->after('backup_configurado');
            $table->date('proxima_manutencao')->nullable()->after('ultima_manutencao');
            $table->text('historico_manutencao')->nullable()->after('proxima_manutencao');
        });
    }

    public function down(): void
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->dropColumn([
                'classificacao', 'localizacao', 'predio', 'andar', 'sala',
                'criticidade', 'data_vida_util', 'data_baixa', 'motivo_baixa', 'metodo_descarte',
                'criptografia', 'antivirus', 'status_patches', 'backup_configurado',
                'ultima_manutencao', 'proxima_manutencao', 'historico_manutencao',
            ]);
        });
    }
};
