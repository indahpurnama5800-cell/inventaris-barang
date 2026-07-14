@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
<h4 class="mb-4">Profil Saya</h4>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                     style="width:84px;height:84px;background:{{ $user->isBos() ? '#15803D' : '#EAB308' }};color:{{ $user->isBos() ? '#fff' : '#422006' }};font-size:28px;font-weight:700;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <div class="text-muted small mb-2">{{ $user->email }}</div>
                <span class="badge {{ $user->isBos() ? 'badge-role-bos' : 'badge-role-karyawan' }} px-3 py-2">{{ ucfirst($user->role) }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-3">Pengaturan Akun</h6>
                <div class="list-group list-group-flush">
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                        <div>
                            <div class="fw-medium">Ubah Data Profil</div>
                            <div class="text-muted small">Perbarui nama dan email akun Anda</div>
                        </div>
                        <span class="fs-5">›</span>
                    </a>
                    <a href="{{ route('profile.password') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                        <div>
                            <div class="fw-medium">Ubah Kata Sandi</div>
                            <div class="text-muted small">Ganti kata sandi login Anda secara berkala</div>
                        </div>
                        <span class="fs-5">›</span>
                    </a>
                    <a href="{{ route('profile.activity') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                        <div>
                            <div class="fw-medium">Riwayat Aktivitas Saya</div>
                            <div class="text-muted small">Lihat semua aktivitas yang pernah Anda lakukan</div>
                        </div>
                        <span class="fs-5">›</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
