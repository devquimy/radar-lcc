<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inflacao;

class InflacaoTest extends TestCase
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
        $inf = new Inflacao([
            'ano' => 2025,
            'inflacao' => 5.3,
        ]);

        $this->assertEquals(2025, $inf->ano);
        $this->assertEquals(5.3, $inf->inflacao);
    }

    public function test_default_inflacao_is_null()
    {
        $inf = new Inflacao();
        $this->assertNull($inf->inflacao);
    }
}
