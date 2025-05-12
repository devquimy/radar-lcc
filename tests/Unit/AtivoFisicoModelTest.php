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
        Model::unguard();
    }

    protected function tearDown(): void
    {
        Model::reguard();
        parent::tearDown();
    }

    public function test_fillable_attributes()
    {
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
