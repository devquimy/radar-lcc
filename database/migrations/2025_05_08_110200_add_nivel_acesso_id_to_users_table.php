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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('nivel_acesso_id')->nullable()->after('email');
            // Adicione a foreign key, se quiser garantir integridade referencial
            // $table->foreign('nivel_acesso_id')->references('id')->on('niveis_acesso');
        });
    }
    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nivel_acesso_id');
        });
    }
    
};
