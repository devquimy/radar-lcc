<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserModelTest extends TestCase
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
    
    public function test_fillable_and_hidden()
    {
        $user = new User(['name' => 'John', 'email' => 'john@example.com']);
        $this->assertEquals('John', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertContains('password', $user->getHidden());
    }
}