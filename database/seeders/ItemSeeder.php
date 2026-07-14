<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();
        $supplierIds = Supplier::pluck('id')->toArray();

        $productNames = [
            'Kertas HVS A4 80gr', 'Kertas HVS F4 70gr', 'Pulpen Gel Hitam', 'Pulpen Gel Biru',
            'Pensil 2B', 'Penghapus Karet', 'Spidol Whiteboard', 'Spidol Permanent',
            'Stapler Sedang', 'Isi Stapler No.10', 'Map Plastik Bening', 'Map Kertas Coklat',
            'Amplop Putih', 'Buku Tulis 58 Lembar', 'Binder Clip 25mm', 'Paper Clip',
            'Toner Printer HP 12A', 'Cartridge Canon 810', 'Kabel LAN Cat6 10m', 'Kabel HDMI 2m',
            'Flashdisk 32GB', 'Harddisk External 1TB', 'Mouse Wireless', 'Keyboard USB',
            'Monitor LED 19 inch', 'UPS 650VA', 'Router WiFi AC1200', 'Switch Hub 8 Port',
            'Kursi Kantor Standar', 'Meja Kerja 120cm', 'Lemari Arsip 2 Pintu', 'Rak Besi Serbaguna',
            'Sapu Ijuk', 'Pel Lantai', 'Cairan Pembersih Lantai', 'Tisu Gulung',
            'Sabun Cuci Tangan', 'Kantong Sampah 60x100', 'Helm Safety', 'Sarung Tangan Safety',
            'Sepatu Safety', 'Rompi Safety', 'Masker Kain', 'Kacamata Safety',
            'Baut M8x20', 'Mur M8', 'Ring Plat 8mm', 'Bearing 6205',
            'Oli Mesin 1L', 'Grease Pelumas 500g', 'Kabel Ties 20cm', 'Isolasi Listrik',
            'Kardus Packing Kecil', 'Kardus Packing Besar', 'Bubble Wrap 1m', 'Lakban Coklat',
            'Lakban Bening', 'Plastik Wrapping', 'Label Barcode 5x3cm', 'Stiker Fragile',
        ];

        $units = ['pcs', 'box', 'rim', 'lusin', 'set', 'unit', 'roll', 'liter', 'kg'];
        $target = 220;
        $count = 0;
        $codeCounter = 1;

        while ($count < $target) {
            foreach ($productNames as $baseName) {
                if ($count >= $target) break;

                $variant = fake()->randomElement(['', ' Tipe A', ' Tipe B', ' Ukuran S', ' Ukuran M', ' Ukuran L', ' Warna Merah', ' Warna Biru']);

                Item::create([
                    'code' => 'BRG-' . str_pad((string) $codeCounter, 5, '0', STR_PAD_LEFT),
                    'name' => $baseName . $variant,
                    'category_id' => fake()->randomElement($categoryIds),
                    'supplier_id' => fake()->randomElement($supplierIds),
                    'stock' => fake()->numberBetween(0, 500),
                    'reorder_point' => fake()->numberBetween(5, 50),
                    'unit' => fake()->randomElement($units),
                    'price' => fake()->numberBetween(2, 500) * 1000,
                    'description' => "Barang inventaris, kode internal BRG-{$codeCounter}.",
                ]);

                $codeCounter++;
                $count++;
            }
        }
    }
}
