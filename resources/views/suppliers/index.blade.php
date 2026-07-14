@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Supplier</h3>
    <a href="{{ route('suppliers.create') }}" class="btn btn-brand">+ Tambah Supplier</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama/kontak/telepon...">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary w-100">Cari</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped bg-white">
        <thead>
            <tr><th>Nama</th><th>Kontak</th><th>Telepon</th><th>Email</th><th>Alamat</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus supplier ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $suppliers->links() }}
@endsection
