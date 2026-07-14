@extends('layouts.app')
@section('title', 'Audit Log')
@section('content')
<h4 class="mb-1">Riwayat Aktivitas (Audit Log)</h4>
<p class="text-muted small mb-3">Mencatat aktivitas create/update/delete/import/export untuk mencegah kecurangan.</p>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari deskripsi/pengguna...">
    </div>
    <div class="col-md-3">
        <select name="action" class="form-select">
            <option value="">Semua Aksi</option>
            @foreach (['create','update','delete','import','export'] as $a)
                <option value="{{ $a }}" @selected(request('action')==$a)>{{ ucfirst($a) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-secondary w-100">Terapkan</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped bg-white">
        <thead><tr><th>Waktu</th><th>Pengguna</th><th>Aksi</th><th>Modul</th><th>Deskripsi</th></tr></thead>
        <tbody>
        @forelse ($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $log->user_name }}</td>
                <td><span class="badge bg-dark">{{ $log->action }}</span></td>
                <td>{{ $log->subject_type }}</td>
                <td>{{ $log->description }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-3">Belum ada aktivitas tercatat.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $logs->links() }}
@endsection
