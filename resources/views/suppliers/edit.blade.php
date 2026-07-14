@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<h3>Edit Supplier</h3>
<form action="{{ route('suppliers.update', $supplier) }}" method="POST">
    @csrf
    @method('PUT')
    @include('suppliers._form')
    <button type="submit" class="btn btn-brand">Update</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
