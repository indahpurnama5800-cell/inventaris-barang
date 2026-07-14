@extends('layouts.app')
@section('title', 'Ubah Kata Sandi')
@section('content')
<h4 class="mb-4">Ubah Kata Sandi</h4>
<div class="card border-0 shadow-sm" style="max-width:480px;">
    <div class="card-body p-4">
        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kata Sandi Baru</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" class="form-control" required minlength="6">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-brand">Ubah Kata Sandi</button>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
