<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NiveisAcessoSeeder extends Seeder
{
    public function run(): void
    {
        $niveis = ['Master','Administrador','Usuário'];
        foreach ($niveis as $nome) {
            DB::table('niveis_acessos')->insert([
                'name' => $nome,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Cria um usuário Master
        DB::table('users')->insert([
            'name' => 'Super Master',
            'email' => 'dummy@radar.com',
            'password' => bcrypt('123456789'),
            'nivel_acesso_id' => 1,    // Master
            'empresa_id' => null,      // se quiser
            'status' => 'ativo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
