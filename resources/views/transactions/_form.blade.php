@php $transaction = $transaction ?? null; @endphp

<div class="mb-3">
    <label class="form-label">Barang</label>
    <select name="item_id" class="form-select" required>
        <option value="">-- Pilih Barang --</option>
        @foreach ($items as $item)
            <option value="{{ $item->id }}" @selected(old('item_id', $transaction->item_id ?? '') == $item->id)>
                {{ $item->code }} - {{ $item->name }} (Stok: {{ $item->stock }})
            </option>
        @endforeach
    </select>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Tipe Transaksi</label>
        <select name="type" class="form-select" required>
            <option value="in" @selected(old('type', $transaction->type ?? '') == 'in')>Barang Masuk</option>
            <option value="out" @selected(old('type', $transaction->type ?? '') == 'out')>Barang Keluar</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Jumlah</label>
        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $transaction->quantity ?? '') }}" min="1" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Tanggal Transaksi</label>
        <input type="date" name="transaction_date" class="form-control" value="{{ old('transaction_date', $transaction->transaction_date ?? date('Y-m-d')) }}" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $transaction->notes ?? '') }}</textarea>
</div>

@if ($transaction === null)
<div class="alert alert-info small">Catatan: Mengedit transaksi yang sudah ada akan otomatis menyesuaikan (mengembalikan lalu menerapkan ulang) stok barang terkait.</div>
@endif
