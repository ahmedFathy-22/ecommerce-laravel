@extends('layouts.master')

@section('content')
    <div class="container mt-150">

        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <input name="name" value="{{ $category->name }}" class="form-control mb-2">

            <textarea name="description" class="form-control mb-2">{{ $category->description }}</textarea>

            <input type="file" name="image" class="form-control mb-2">

            <button class="btn btn-primary">Update Category</button>

        </form>

    </div>
@endsection
