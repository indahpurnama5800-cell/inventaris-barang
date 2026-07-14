@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<h3>Tambah Transaksi</h3>
<form action="{{ route('transactions.store') }}" method="POST">
    @csrf
    @include('transactions._form')
    <button type="submit" class="btn btn-brand">Simpan</button>
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
