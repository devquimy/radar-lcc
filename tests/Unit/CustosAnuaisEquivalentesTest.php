<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustosAnuaisEquivalentes;

class CustosAnuaisEquivalentesTest extends TestCase
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
        $custosEquivalentes = new CustosAnuaisEquivalentes([
            'estudo_id' => 7,
            'valor' => 1200.50,
        ]);

        $this->assertEquals(7, $custosEquivalentes->estudo_id);
        $this->assertEquals(1200.50, $custosEquivalentes->valor);
    }
}
