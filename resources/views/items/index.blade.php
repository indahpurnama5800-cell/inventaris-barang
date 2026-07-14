@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Barang</h3>
    <div>
        <a href="{{ route('items.create') }}" class="btn btn-brand">+ Tambah Barang</a>
        <a href="{{ route('items.export.excel') }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('items.export.csv') }}" class="btn btn-outline-success">Export CSV</a>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
    </div>
</div>

{{-- Form Search & Filter --}}
<form method="GET" action="{{ route('items.index') }}" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari kode/nama barang...">
    </div>
    <div class="col-md-3">
        <select name="category_id" class="form-select">
            <option value="">-- Semua Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="supplier_id" class="form-select">
            <option value="">-- Semua Supplier --</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected(request('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="safe" @selected(request('status')=='safe')>Aman</option>
            <option value="low" @selected(request('status')=='low')>Perlu Restock</option>
            <option value="critical" @selected(request('status')=='critical')>Habis</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary w-100">Terapkan</button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('items.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped bg-white">
        <thead>
            <tr>
                <th>Status</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td><span class="badge {{ $item->stockStatusBadgeClass() }}">{{ $item->stockStatusLabel() }}</span></td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>{{ $item->supplier->name ?? '-' }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-info">Edit</a>
                        @if (auth()->user()->isBos())
                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- {{ $items->links() }} --}}

{{-- Modal Import --}}
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('items.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Format kolom file (.xlsx/.csv): <code>code, name, category, supplier, stock, reorder_point, unit, price, description</code></p>
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-brand">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
