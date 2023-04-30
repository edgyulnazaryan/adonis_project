<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function it_can_create_a_product()
    {

        $product = Product::create([
            'name' => 'Product Testing',
            'price' => 10.99,
            'quantity' => 20,
            'status' => 'available',
            'image' => 'product_test.jpg',
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Product Test', $product->name);
        $this->assertEquals(10.99, $product->price);
        $this->assertEquals(20, $product->quantity);
        $this->assertEquals('available', $product->status);
        $this->assertEquals('product_test.jpg', $product->image);
    }

    public function test_product_can_be_updated()
    {
        // Create a product
        $product = Product::factory()->create();

        // Set new values for the fields
        $data = [
            'name' => 'New Product Name',
            'price' => 19.99,
            'quantity' => 100,
            'status' => 'available',
        ];
        // Update the product using the new data
        $response = $this->putJson("/product/{$product}", $data);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the product was updated in the database
        $this->assertDatabaseHas('products', $data);

        // Assert that the product image was uploaded and saved correctly
        Storage::disk('public')->assertExists($product->image);

        // Clean up the uploaded file after the test
        Storage::disk('public')->delete($product->image);
    }
}
