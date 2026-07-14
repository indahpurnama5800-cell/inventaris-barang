@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<h3>Edit Transaksi</h3>
<form action="{{ route('transactions.update', $transaction) }}" method="POST">
    @csrf
    @method('PUT')
    @include('transactions._form')
    <button type="submit" class="btn btn-brand">Update</button>
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
