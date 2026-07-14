@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<h3>Tambah Kategori</h3>
<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    @include('categories._form')
    <button type="submit" class="btn btn-brand">Simpan</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
