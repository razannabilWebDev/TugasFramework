<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductStockTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'role' => 'admin',
            'password' => 'password',
        ]);
    }

    private function category(): Category
    {
        return Category::create(['name' => 'Minuman']);
    }

    public function test_admin_can_store_product_with_stock(): void
    {
        $category = $this->category();

        $response = $this->actingAs($this->admin())->post(route('products.store'), [
            'category_id' => $category->id,
            'code' => 'P-001',
            'name' => 'Teh Botol',
            'unit' => 'botol',
            'price' => 5000,
            'stock' => 25,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'code' => 'P-001',
            'unit' => 'botol',
            'stock' => 25,
        ]);
    }

    public function test_admin_can_update_product_stock(): void
    {
        $category = $this->category();
        $product = Product::create([
            'category_id' => $category->id,
            'code' => 'P-002',
            'name' => 'Kopi',
            'unit' => 'pcs',
            'price' => 4000,
            'stock' => 10,
        ]);

        $response = $this->actingAs($this->admin())->put(route('products.update', $product), [
            'category_id' => $category->id,
            'code' => 'P-002',
            'name' => 'Kopi',
            'unit' => 'sachet',
            'price' => 4500,
            'stock' => 40,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'unit' => 'sachet',
            'stock' => 40,
        ]);
    }

    public function test_store_product_requires_valid_data(): void
    {
        $response = $this->actingAs($this->admin())->post(route('products.store'), []);

        $response->assertSessionHasErrors(['category_id', 'code', 'name', 'unit', 'price', 'stock']);
    }
}
