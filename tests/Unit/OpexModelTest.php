<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Opex;

class OpexModelTest extends TestCase
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

    public function test_fillable()
    {
        $opex = new Opex(['descricao' => 'Manutenção', 'custo' => 500]);
        $this->assertEquals('Manutenção', $opex->descricao);
        $this->assertEquals(500, $opex->custo);
    }

    public function test_default_custo_zero()
    {
        $opex = new Opex();
        $this->assertEquals(0, $opex->custo);
    }

    public function test_casts_custo_to_int()
    {
        $opex = new Opex(['custo' => 750]);
        $this->assertIsInt($opex->custo);
        $this->assertEquals(750, $opex->custo);
    }
}

