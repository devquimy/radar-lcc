<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

class EmpresaModelTest extends TestCase
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

    public function test_fillable_and_defaults()
    {
        $empresa = new Empresa(['nome' => 'ACME', 'cnpj' => '123']);
        $this->assertEquals('ACME', $empresa->nome);
        $this->assertEquals('123', $empresa->cnpj);
    }

    public function test_default_values()
    {
        $empresa = new Empresa();
        $this->assertNull($empresa->cnpj);
    }
}