@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<h3>Edit Barang</h3>

<form action="{{ route('items.update', $item) }}" method="POST">
    @csrf
    @method('PUT')
    @include('items._form')
    <button type="submit" class="btn btn-brand">Update</button>
    <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
