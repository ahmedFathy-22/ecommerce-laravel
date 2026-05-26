@extends('layouts.master')

@section('content')

    <div class="container mt-150">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf

            <input name="name" placeholder="Category Name" class="form-control mb-2">

            <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>

            <input type="file" name="image" class="form-control mb-2">

            <button class="btn btn-success">Add Category</button>

        </form>

    </div>

@endsection
