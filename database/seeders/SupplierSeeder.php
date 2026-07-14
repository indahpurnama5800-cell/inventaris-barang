<?php
namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'PT Sumber Jaya Abadi', 'CV Mitra Sejahtera', 'PT Cahaya Logistik',
            'UD Berkah Mandiri', 'PT Nusantara Supplindo', 'CV Karya Utama',
            'PT Prima Distribusi', 'CV Sinar Terang', 'PT Global Trading Indonesia',
            'UD Maju Bersama', 'PT Anugerah Sentosa', 'CV Bintang Timur',
        ];
        foreach ($names as $name) {
            Supplier::create([
                'name' => $name,
                'contact_person' => 'Bapak/Ibu ' . fake('id_ID')->firstName(),
                'phone' => '08' . fake()->numerify('##########'),
                'email' => strtolower(str_replace(' ', '', $name)) . '@supplier.co.id',
                'address' => fake('id_ID')->address(),
            ]);
        }
    }
}
