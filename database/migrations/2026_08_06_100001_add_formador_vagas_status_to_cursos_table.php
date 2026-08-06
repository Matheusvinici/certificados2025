<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->unsignedBigInteger('formador_id')->nullable()->after('user_assinatura_id');
            $table->integer('vagas')->nullable()->after('formador_id');
            $table->string('status')->default('pendente')->after('vagas');

            $table->foreign('formador_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['formador_id']);
            $table->dropColumn(['formador_id', 'vagas', 'status']);
        });
    }
};
