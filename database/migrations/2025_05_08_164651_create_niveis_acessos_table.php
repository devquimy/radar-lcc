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
        Schema::create('niveis_acessos', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // ex: Master, Administrador, Usuário
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('niveis_acessos');
    }
};
