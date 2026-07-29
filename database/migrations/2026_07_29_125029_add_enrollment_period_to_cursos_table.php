<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->date('data_inicio_inscricao')->nullable()->after('data_fim');
            $table->date('data_fim_inscricao')->nullable()->after('data_inicio_inscricao');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn(['data_inicio_inscricao', 'data_fim_inscricao']);
        });
    }
};
