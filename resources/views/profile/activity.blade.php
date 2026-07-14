@extends('layouts.app')
@section('title', 'Riwayat Aktivitas Saya')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">Riwayat Aktivitas Saya</h4>
        <p class="text-muted small mb-0">Daftar aktivitas yang pernah Anda lakukan di sistem ini.</p>
    </div>
    <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Waktu</th>
                        <th>Aksi</th>
                        <th>Modul</th>
                        <th class="pe-3">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td class="ps-3">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                        <td><span class="badge bg-secondary">{{ $log->action }}</span></td>
                        <td>{{ $log->subject_type }}</td>
                        <td class="pe-3">{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada aktivitas tercatat.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $logs->links() }}
</div>
@endsection
