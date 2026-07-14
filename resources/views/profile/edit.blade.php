@extends('layouts.app')
@section('title', 'Ubah Data Profil')
@section('content')
<h4 class="mb-4">Ubah Data Profil</h4>
<div class="card border-0 shadow-sm" style="max-width:480px;">
    <div class="card-body p-4">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-brand">Simpan Perubahan</button>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
