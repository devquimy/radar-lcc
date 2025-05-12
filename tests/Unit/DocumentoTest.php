<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;

class DocumentoTest extends TestCase
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
        $doc = new Documento([
            'nome' => 'Relatório Final',
            'usuario_ultima_edicao_id' => 3,
        ]);

        $this->assertEquals('Relatório Final', $doc->nome);
        $this->assertEquals(3, $doc->usuario_ultima_edicao_id);
    }
}
