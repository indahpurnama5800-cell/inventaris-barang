@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<h3>Tambah Supplier</h3>
<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf
    @include('suppliers._form')
    <button type="submit" class="btn btn-brand">Simpan</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
