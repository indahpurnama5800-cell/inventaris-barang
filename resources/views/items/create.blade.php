@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<h3>Tambah Barang</h3>

<form action="{{ route('items.store') }}" method="POST">
    @csrf
    @include('items._form')
    <button type="submit" class="btn btn-brand">Simpan</button>
    <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
