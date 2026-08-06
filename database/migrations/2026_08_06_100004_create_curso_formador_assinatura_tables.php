<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curso_formador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('formador_id');
            $table->timestamps();

            $table->unique(['curso_id', 'formador_id']);
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('formador_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('curso_assinatura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->unique(['curso_id', 'user_id']);
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::table('cursos')->whereNotNull('formador_id')->orderBy('id')->each(function ($curso) {
            DB::table('curso_formador')->updateOrInsert(
                ['curso_id' => $curso->id, 'formador_id' => $curso->formador_id],
                ['created_at' => now(), 'updated_at' => now()]
            );
        });

        DB::table('cursos')->whereNotNull('user_assinatura_id')->orderBy('id')->each(function ($curso) {
            DB::table('curso_assinatura')->updateOrInsert(
                ['curso_id' => $curso->id, 'user_id' => $curso->user_assinatura_id],
                ['created_at' => now(), 'updated_at' => now()]
            );
        });

        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['formador_id']);
            $table->dropForeign(['user_assinatura_id']);
            $table->dropColumn(['formador_id', 'user_assinatura_id']);
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->unsignedBigInteger('formador_id')->nullable()->after('ativo');
            $table->unsignedBigInteger('user_assinatura_id')->nullable()->after('formador_id');
            $table->foreign('formador_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_assinatura_id')->references('id')->on('users')->onDelete('set null');
        });

        DB::table('curso_formador')->orderBy('id')->each(function ($pivot) {
            DB::table('cursos')->where('id', $pivot->curso_id)->whereNull('formador_id')->update(['formador_id' => $pivot->formador_id]);
        });

        DB::table('curso_assinatura')->orderBy('id')->each(function ($pivot) {
            DB::table('cursos')->where('id', $pivot->curso_id)->whereNull('user_assinatura_id')->update(['user_assinatura_id' => $pivot->user_id]);
        });

        Schema::dropIfExists('curso_assinatura');
        Schema::dropIfExists('curso_formador');
    }
};
