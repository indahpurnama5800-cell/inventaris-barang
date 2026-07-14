<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;
use App\Imports\ItemsImport;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    // Menampilkan daftar barang dengan search, filter, & pagination
    public function index(Request $request)
    {
        $query = Item::with(['category', 'supplier']);

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter berdasarkan status stok (Aman / Perlu Restock / Stok Habis)
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'safe':
                    $query->whereColumn('stock', '>', 'reorder_point');
                    break;

                case 'low':
                    $query->whereColumn('stock', '<=', 'reorder_point')
                        ->where('stock', '>', 0);
                    break;

                case 'critical':
                    $query->where('stock', '<=', 0);
                    break;
            }
        }
        $items = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('items.index', compact('items', 'categories', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('items.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request, AuditLogService $audit)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:items,code',
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'stock' => 'required|integer|min:0',
            'reorder_point' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $item = Item::create($validated);
        $audit->log('create', 'Item', $item->id, "Menambahkan barang baru: {$item->name} ({$item->code})");

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('items.edit', compact('item', 'categories', 'suppliers'));
    }

    public function update(Request $request, Item $item, AuditLogService $audit)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:items,code,' . $item->id,
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'stock' => 'required|integer|min:0',
            'reorder_point' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $item->update($validated);
        $audit->log('update', 'Item', $item->id, "Memperbarui data barang: {$item->name} ({$item->code})");

        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item, AuditLogService $audit)
    {
        $audit->log('delete', 'Item', $item->id, "Menghapus barang: {$item->name} ({$item->code})");
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function import(Request $request, AuditLogService $audit)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new ItemsImport, $request->file('file'));
            $audit->log('import', 'Item', null, 'Import data barang dari file ' . $request->file('file')->getClientOriginalName());

            return redirect()->route('items.index')->with('success', 'Data barang berhasil diimport.');
        } catch (\Throwable $e) {
            return back()->withErrors(['file' => 'Import gagal: ' . $e->getMessage()]);
        }
    }

    public function exportExcel(AuditLogService $audit)
    {
        $audit->log('export', 'Item', null, 'Export data barang ke Excel');
        return Excel::download(new ItemsExport, 'data-barang-' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportCsv(AuditLogService $audit)
    {
        $audit->log('export', 'Item', null, 'Export data barang ke CSV');
        return Excel::download(new ItemsExport, 'data-barang-' . now()->format('Ymd_His') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
