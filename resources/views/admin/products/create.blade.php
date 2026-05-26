@extends('layouts.master')

@section('content')
    <div class="container mt-150">

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <input name="name" placeholder="Name" class="form-control mb-2">

            <input name="price" placeholder="Price" class="form-control mb-2">

            <input name="quantity" placeholder="Quantity" class="form-control mb-2">

            <input type="file" name="image" class="form-control mb-2">

            <select name="category_id" class="form-control mb-3">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <button class="btn btn-success">Save Product</button>

        </form>

    </div>
@endsection
