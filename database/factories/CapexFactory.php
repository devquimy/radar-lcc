<?php

namespace Database\Factories;

use App\Models\Capex;
use App\Models\AtivoFisico;
use Illuminate\Database\Eloquent\Factories\Factory;

class CapexFactory extends Factory
{
    protected $model = Capex::class;

    public function definition()
    {
        return [
            'motivo_escolha_ativo_fisico' => $this->faker->sentence,
            'atualizacao_patrimonial' => json_encode(['ano' => 2025, 'valor' => 10000]),
            'melhorias_reformas' => json_encode(['descricao' => 'Reforma elétrica']),
            'ativo_fisico_id' => AtivoFisico::factory(),
        ];
    }
}
