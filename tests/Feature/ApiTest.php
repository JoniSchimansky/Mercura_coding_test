<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ApiTest extends TestCase
{
    // Migrate DB before every test
    use RefreshDatabase;

    public function test_index_products()
    {
        // GET for all the products
        $response = $this->getJson('/v1/products');

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'base_price',
            ],
        ]);
    }

    public function test_show_product()
    {
        $productId = 1;
    
        //  GET for information about de selected product
        $response = $this->getJson("/v1/product/{$productId}");
    
        $response->assertJson([
            'id' => $productId,
        ]);
    }
    
    public function test_store_quote()
    {
        // POST to create new quote
        $response = $this->postJson('/v1/quotes', [
            'user_name' => 'John Doe',
            'user_email' => 'john@example.com',
            'product_id' => 1,
            'selected_options' => [1, 2, 3],
        ]);

        $response->assertJson([
            'message' => 'Quote created successfully',
            'quote' => [
                'user_name' => 'John Doe',
                'user_email' => 'john@example.com',
                'total_price' => true,
            ],
        ]);
    }

}
