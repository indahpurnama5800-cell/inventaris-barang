<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Str;

/**
 * Format kolom Excel/CSV yang diharapkan (header di baris pertama):
 * code | name | category | supplier | stock | reorder_point | unit | price | description
 *
 * Kolom "category" dan "supplier" berisi NAMA (bukan id), akan dicari/dibuat otomatis.
 */
class ItemsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        if (empty($row['code']) && empty($row['name'])) {
            return null;
        }

        $code = trim((string) ($row['code'] ?? ''));
        $name = trim((string) ($row['name'] ?? ''));

        if ($code === '' && $name !== '') {
            $code = Str::slug($name, '-') . '-' . time();
        }

        $categoryId = null;
        if (!empty($row['category'])) {
            $category = Category::firstOrCreate(['name' => trim((string) $row['category'])]);
            $categoryId = $category->id;
        }

        $supplierId = null;
        if (!empty($row['supplier'])) {
            $supplier = Supplier::firstOrCreate(['name' => trim((string) $row['supplier'])]);
            $supplierId = $supplier->id;
        }

        return Item::updateOrCreate(
            ['code' => $code],
            [
                'name' => $name ?: 'Barang Impor',
                'category_id' => $categoryId,
                'supplier_id' => $supplierId,
                'stock' => (int) ($row['stock'] ?? 0),
                'reorder_point' => (int) ($row['reorder_point'] ?? 10),
                'unit' => !empty($row['unit']) ? trim((string) $row['unit']) : null,
                'price' => is_numeric($row['price'] ?? null) ? (float) $row['price'] : 0,
                'description' => !empty($row['description']) ? trim((string) $row['description']) : null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'code' => 'required',
            'name' => 'required',
            'stock' => 'nullable|numeric',
            'price' => 'nullable|numeric',
        ];
    }
}
