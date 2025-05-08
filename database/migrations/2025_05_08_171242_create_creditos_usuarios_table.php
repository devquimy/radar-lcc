<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creditos_usuarios', function (Blueprint $table) {
            $table->id();
            // integer signed (padrão) para coincidir com empresas.id
            $table->integer('empresa_id')->nullable();
            $table->integer('total_creditos_disponiveis')->default(0);
            $table->timestamps();

            // agora a FK é compatível: INT -> INT
            $table->foreign('empresa_id')
                  ->references('id')
                  ->on('empresas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creditos_usuarios');
    }
};
