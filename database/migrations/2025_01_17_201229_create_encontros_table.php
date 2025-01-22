<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('encontros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('curso_id');
            $table->string('conteudo');
            $table->date('data');
            $table->integer('carga_horaria_encontro');
            $table->string('hash')->unique(); // Garantir unicidade do hash
            $table->timestamps();
        
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encontros');
    }
};
