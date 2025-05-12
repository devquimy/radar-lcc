<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserEmpresa;

class UserEmpresaTest extends TestCase
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
        $userEmpresa = new UserEmpresa([
            'user_id' => 1,
            'empresa_id' => 2,
        ]);

        $this->assertEquals(1, $userEmpresa->user_id);
        $this->assertEquals(2, $userEmpresa->empresa_id);
    }
}
