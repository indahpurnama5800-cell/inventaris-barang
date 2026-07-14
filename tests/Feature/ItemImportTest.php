<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ItemImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_import_items_from_csv_file(): void
    {
        $user = User::create([
            'name' => 'Import User',
            'email' => 'import@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);

        $csv = "code,name,category,supplier,stock,reorder_point,unit,price,description\n";
        $csv .= "BRG-001,Barang Impor 1,Kategori Uji,Supplier Uji,10,5,pcs,15000,Lorem\n";

        $file = UploadedFile::fake()->createWithContent('items.csv', $csv);

        $this->actingAs($user);

        $response = $this->post(route('items.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('items.index'));
        $this->assertDatabaseHas('items', ['code' => 'BRG-001', 'name' => 'Barang Impor 1']);
    }
}
