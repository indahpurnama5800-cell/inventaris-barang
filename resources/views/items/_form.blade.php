@php $item = $item ?? null; @endphp

<div class="mb-3">
    <label class="form-label">Kode Barang</label>
    <input type="text" name="code" class="form-control" value="{{ old('code', $item->code ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Nama Barang</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $item->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="category_id" class="form-select">
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id ?? '') == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Supplier</label>
    <select name="supplier_id" class="form-select">
        <option value="">-- Pilih Supplier --</option>
        @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}" @selected(old('supplier_id', $item->supplier_id ?? '') == $supplier->id)>
                {{ $supplier->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Stok</label>
        <input type="number" name="stock" class="form-control" value="{{ old('stock', $item->stock ?? 0) }}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Ambang Minimum (Restock)</label>
        <input type="number" name="reorder_point" class="form-control" value="{{ old('reorder_point', $item->reorder_point ?? 10) }}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Satuan</label>
        <input type="text" name="unit" class="form-control" value="{{ old('unit', $item->unit ?? '') }}" placeholder="pcs, box, kg...">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Harga</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $item->price ?? 0) }}" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $item->description ?? '') }}</textarea>
</div>
