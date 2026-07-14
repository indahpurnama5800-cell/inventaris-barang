@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<h3>Edit Kategori</h3>
<form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')
    @include('categories._form')
    <button type="submit" class="btn btn-brand">Update</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
