@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Transaksi Barang</h3>
    <a href="{{ route('transactions.create') }}" class="btn btn-brand">+ Tambah Transaksi</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari kode/nama barang...">
    </div>
    <div class="col-md-2">
        <select name="type" class="form-select">
            <option value="">-- Semua Tipe --</option>
            <option value="in" @selected(request('type') == 'in')>Barang Masuk</option>
            <option value="out" @selected(request('type') == 'out')>Barang Keluar</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
    </div>
    <div class="col-md-2">
        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary w-100">Terapkan</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped bg-white">
        <thead>
            <tr>
                <th>Tanggal</th><th>Barang</th><th>Tipe</th><th>Jumlah</th><th>Catatan</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d-m-Y') }}</td>
                    <td>{{ $trx->item->name ?? '-' }}</td>
                    <td>
                        @if ($trx->type === 'in')
                            <span class="badge bg-success">Masuk</span>
                        @else
                            <span class="badge bg-danger">Keluar</span>
                        @endif
                    </td>
                    <td>{{ $trx->quantity }}</td>
                    <td>{{ $trx->notes }}</td>
                    <td>
                        <a href="{{ route('transactions.edit', $trx) }}" class="btn btn-sm btn-info">Edit</a>
                        @if (auth()->user()->isBos())
                            <form action="{{ route('transactions.destroy', $trx) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- {{ $transactions->links() }} --}}
@endsection
