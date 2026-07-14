<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Alat Tulis Kantor', 'Elektronik', 'Furniture', 'Peralatan Dapur',
            'Peralatan Kebersihan', 'Alat Keselamatan Kerja (K3)', 'Suku Cadang Mesin',
            'Bahan Baku Produksi', 'Kemasan & Packaging', 'Peralatan IT & Jaringan',
        ];
        foreach ($categories as $name) {
            Category::create(['name' => $name, 'description' => "Kategori untuk kelompok barang {$name}."]);
        }
    }
}
