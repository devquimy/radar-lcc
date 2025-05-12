<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\CreditoUsuario;

class CreditoUsuarioTest extends TestCase
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
        $creditosUsuario = new CreditoUsuario([
            'empresa_id'               => 42,
            'total_creditos_disponiveis' => 10,
        ]);

        $this->assertEquals(42, $creditosUsuario->empresa_id);
        $this->assertEquals(10, $creditosUsuario->total_creditos_disponiveis);
    }

    public function test_default_total_creditos_is_null()
    {
        $creditosUsuario = new CreditoUsuario();
        $this->assertNull($creditosUsuario->total_creditos_disponiveis);
    }
}
