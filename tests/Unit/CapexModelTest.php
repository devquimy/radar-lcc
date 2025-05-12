<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Capex;

class CapexModelTest extends TestCase
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
        $data = ['nome' => 'Proj A', 'valor' => 10000];
        $capex = new Capex($data);

        $this->assertEquals('Proj A', $capex->nome);
        $this->assertEquals(10000, $capex->valor);
    }

    public function test_default_valor_is_zero()
    {
        $capex = new Capex();
        $this->assertEquals(0, $capex->valor);
    }

    public function test_casts_applications()
    {
        $capex = new Capex(['valor' => 1500]);
        $this->assertIsInt($capex->valor);
        $this->assertEquals(1500, $capex->valor);
    }
}