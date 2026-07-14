<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ItemsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        // upsert berdasarkan code, biar bisa update kalau kode sudah ada
        return Item::updateOrCreate(
            ['code' => $row['code']],
            [
                'name'           => $row['name'],
                'category'       => $row['category'],
                'supplier'       => $row['supplier'],
                'stock'          => $row['stock'] ?? 0,
                'reorder_point'  => $row['reorder_point'] ?? 0,
                'unit'           => $row['unit'],
                'price'          => $row['price'] ?? 0,
                'description'    => $row['description'] ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'code'     => 'required|string|max:50',
            'name'     => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'supplier' => 'required|string|max:255',
            'stock'    => 'nullable|numeric|min:0',
            'reorder_point' => 'nullable|numeric|min:0',
            'unit'     => 'required|string|max:50',
            'price'    => 'nullable|numeric|min:0',
        ];
    }
}