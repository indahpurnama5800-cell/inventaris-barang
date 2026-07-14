<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Item::with(['category', 'supplier'])->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Nama Barang', 'Kategori', 'Supplier', 'Stok', 'Ambang Minimum', 'Status', 'Satuan', 'Harga', 'Deskripsi'];
    }

    public function map($item): array
    {
        return [
            $item->code,
            $item->name,
            $item->category->name ?? '-',
            $item->supplier->name ?? '-',
            $item->stock,
            $item->reorder_point,
            $item->stockStatusLabel(),
            $item->unit,
            $item->price,
            $item->description,
        ];
    }
}
