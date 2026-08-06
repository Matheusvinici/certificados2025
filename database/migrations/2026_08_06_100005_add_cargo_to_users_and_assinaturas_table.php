<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cargo')->nullable()->after('matricula');
        });

        Schema::table('assinaturas', function (Blueprint $table) {
            $table->string('cargo')->nullable()->after('nome');
            $table->string('secretaria')->nullable()->after('cargo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cargo');
        });

        Schema::table('assinaturas', function (Blueprint $table) {
            $table->dropColumn(['cargo', 'secretaria']);
        });
    }
};
