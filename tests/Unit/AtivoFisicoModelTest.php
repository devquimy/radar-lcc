<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\AtivoFisico;

class AtivoFisicoModelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Desabilita o mass assignment guard globalmente, para podermos popular o model diretamente
        Model::unguard();
    }

    protected function tearDown(): void
    {
        // Reativa o guard
        Model::reguard();
        parent::tearDown();
    }

    public function test_fillable_attributes()
    {
        // Instancia em memória sem tocar no banco
        $ativo = new AtivoFisico([
            'nome_ativo'       => 'Máquina',
            'expectativa_vida' => 5,
        ]);

        $this->assertEquals('Máquina', $ativo->nome_ativo);
        $this->assertEquals(5, $ativo->expectativa_vida);
    }

    public function test_default_expectativa_vida_is_null()
    {
        $ativo = new AtivoFisico();
        $this->assertNull($ativo->expectativa_vida);
    }
}
