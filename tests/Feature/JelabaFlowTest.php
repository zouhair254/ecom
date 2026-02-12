<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JelabaFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_with_products(): void
    {
        $product = Product::factory()->create([
            'name' => 'جلابة اختبار',
            'price' => 500,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('جلابة');
        $response->assertSee('جلابة اختبار');
        $response->assertSee('500');
    }

    public function test_product_page_loads_and_shows_details(): void
    {
        $product = Product::factory()->create([
            'name' => 'جلابة مفصلة',
            'description' => 'وصف دقيق للجلابة',
            'stock' => 10,
        ]);

        $response = $this->get(route('product.show', $product));

        $response->assertStatus(200);
        $response->assertSee('جلابة مفصلة');
        $response->assertSee('وصف دقيق للجلابة');
        $response->assertSee('10 قطعة متوفرة');
    }

    public function test_user_can_place_order_and_stock_decrements(): void
    {
        $product = Product::factory()->create([
            'stock' => 5,
        ]);

        Livewire::test('order-form', ['product' => $product])
            ->set('name', 'فاطمة الزهراء')
            ->set('phone', '0661234567')
            ->set('address', 'حي الهدى، أكادير')
            ->set('city', 'أكادير')
            ->set('quantity', 2)
            ->call('submitOrder')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('orders', [
            'product_id' => $product->id,
            'name' => 'فاطمة الزهراء',
            'quantity' => 2,
        ]);

        $this->assertEquals(3, $product->fresh()->stock);
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_product(): void
    {
        $admin = User::factory()->create();

        Livewire::actingAs($admin)
            ->test('admin.admin-products')
            ->call('openCreateForm')
            ->set('name', 'جلابة جديدة')
            ->set('description', 'وصف الجلابة الجديدة')
            ->set('price', 1200)
            ->set('stock', 50)
            ->set('colors', ['أحمر', 'green'])
            ->set('sizes', ['L', 'XL'])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'name' => 'جلابة جديدة',
            'slug' => 'جلابة-جديدة', // Str::slug('جلابة جديدة') preserves Arabic
            'price' => 1200,
            'stock' => 50,
        ]);

        $product = Product::where('slug', 'جلابة-جديدة')->first();
        $this->assertEquals(['أحمر', 'green'], $product->colors);
        $this->assertEquals(['L', 'XL'], $product->sizes);
    }

    public function test_user_can_place_order_with_variations(): void
    {
        $product = Product::factory()->create([
            'stock' => 5,
            'colors' => ['أحمر', 'أزرق'],
            'sizes' => ['M', 'L'],
        ]);

        Livewire::test('order-form', ['product' => $product])
            ->set('name', 'فاطمة الزهراء')
            ->set('phone', '0661234567')
            ->set('address', 'حي الهدى، أكادير')
            ->set('city', 'أكادير')
            ->set('quantity', 2)
            ->set('color', 'أحمر')
            ->set('size', 'M')
            ->call('submitOrder')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('orders', [
            'product_id' => $product->id,
            'name' => 'فاطمة الزهراء',
            'quantity' => 2,
            'color' => 'أحمر',
            'size' => 'M',
        ]);

        $this->assertEquals(3, $product->fresh()->stock);
    }
}
