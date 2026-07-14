<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemStatusFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_filter_shows_items_matching_their_actual_stock_status(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);
        $category = Category::create(['name' => 'Kategori Uji']);
        $supplier = Supplier::create(['name' => 'Supplier Uji']);

        Item::create([
            'code' => 'ITEM-001',
            'name' => 'Barang Aman',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'stock' => 25,
            'reorder_point' => 10,
            'unit' => 'pcs',
            'price' => 10000,
            'description' => null,
        ]);

        Item::create([
            'code' => 'ITEM-002',
            'name' => 'Barang Perlu Restock',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'stock' => 15,
            'reorder_point' => 20,
            'unit' => 'pcs',
            'price' => 12000,
            'description' => null,
        ]);

        Item::create([
            'code' => 'ITEM-003',
            'name' => 'Barang Stok Habis',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'stock' => 0,
            'reorder_point' => 5,
            'unit' => 'pcs',
            'price' => 13000,
            'description' => null,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('items.index', ['status' => 'low']));

        $response->assertOk();
        $response->assertViewHas('items', function ($items) {
            return $items->contains('name', 'Barang Perlu Restock')
                && $items->doesntContain('name', 'Barang Aman')
                && $items->doesntContain('name', 'Barang Stok Habis');
        });
    }

    public function test_restock_filter_shows_low_and_critical_items_together(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);
        $category = Category::create(['name' => 'Kategori Uji']);
        $supplier = Supplier::create(['name' => 'Supplier Uji']);

        Item::create([
            'code' => 'ITEM-101',
            'name' => 'Barang Restock 1',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'stock' => 3,
            'reorder_point' => 5,
            'unit' => 'pcs',
            'price' => 9000,
            'description' => null,
        ]);

        Item::create([
            'code' => 'ITEM-102',
            'name' => 'Barang Restock 2',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'stock' => 0,
            'reorder_point' => 5,
            'unit' => 'pcs',
            'price' => 9500,
            'description' => null,
        ]);

        Item::create([
            'code' => 'ITEM-103',
            'name' => 'Barang Aman',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'stock' => 20,
            'reorder_point' => 5,
            'unit' => 'pcs',
            'price' => 10000,
            'description' => null,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('items.index', ['status' => 'restock']));

        $response->assertOk();
        $response->assertViewHas('items', function ($items) {
            return $items->contains('name', 'Barang Restock 1')
                && $items->contains('name', 'Barang Restock 2')
                && $items->doesntContain('name', 'Barang Aman');
        });
    }
}
