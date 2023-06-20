<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBuscarTodosProdutosStatusCode()
    {
        $response = $this->get('/api/produtos');

        $response->assertStatus(200);
    }
}
