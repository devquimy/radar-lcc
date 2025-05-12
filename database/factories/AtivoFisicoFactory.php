<?php

namespace Database\Factories;

use App\Models\AtivoFisico;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtivoFisicoFactory extends Factory
{
    protected $model = AtivoFisico::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'tipo' => $this->faker->randomElement(['Máquina', 'Equipamento', 'Veículo']),
            'descricao' => $this->faker->sentence,
        ];
    }
}
