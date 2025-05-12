<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustosAnuais;

class CustosAnuaisTest extends TestCase
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
        $custosAnuais = new CustosAnuais([
            'id' => 11,
            'estudo_id' => 1,
        ]);

        $this->assertEquals(11, $custosAnuais->id);
        $this->assertEquals(1, $custosAnuais->estudo_id);
    }

    public function test_default_estudo_id_is_null()
    {
        $custosAnuais = new CustosAnuais();
        $this->assertNull($custosAnuais->estudo_id);
    }
}
