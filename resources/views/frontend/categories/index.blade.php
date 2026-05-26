@extends('layouts.master')

@section('content')
    <!-- product section -->

    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">اقسام</span> الموقع</h3>
                        <p>متعه التسوق عبر فروعنا</p>
                    </div>
                </div>
            </div>


            <div class="row">
                @foreach ($categories as $item)
                    <div class="col-lg-4 col-md-6 mb-4 text-center">

                        <div class="single-product-item h-100 d-flex flex-column p-2 shadow-sm custom-card">
                            <div class="product-image">
                                <a href="{{ route('categories.show', $item->id) }}">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid"
                                        style="height:200px; width:100%; object-fit:cover;">
                                </a>
                            </div>

                            <div class="flex-grow-1 mt-2">
                                <h3>{{ $item->name }}</h3>
                                <p>{{ $item->description }}</p>
                            </div>

                            <div class="mt-auto">
                                <hr class="my-3">

                                <a href="{{ route('categories.edit', $item->id) }}"
                                    class="btn btn-warning btn-sm mt-2 me-3">
                                    Edit
                                </a>

                                <form action="{{ route('categories.destroy', $item->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm mt-2"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>
        ```

    </div>
    <!-- end product section -->
@endsection
