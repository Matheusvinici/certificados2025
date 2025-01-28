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
        Schema::create('frequencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('encontro_id'); // Chave estrangeira para encontros
            $table->unsignedBigInteger('user_id');     // Chave estrangeira para usuários
            $table->integer('avaliacao_conteudo');     // Avaliação do conteúdo (1 a 5)
            $table->integer('avaliacao_metodologia');  // Avaliação da metodologia (1 a 5)
            $table->text('comentarios')->nullable();   // Comentários sobre a formação
            
            $table->timestamps();

            $table->foreign('encontro_id')->references('id')->on('encontros')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['encontro_id', 'user_id']); // Garante que o usuário só registre presença uma vez por encontro
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequencias');
    }
};