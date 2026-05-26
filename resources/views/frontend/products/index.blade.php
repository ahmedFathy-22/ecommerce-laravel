@extends('layouts.master')

@section('content')
    <form method="GET" action="{{ route('products.index') }}" class="mb-5">

        <div class="row">

            <!-- Category -->
            <div class="col-md-3">
                <select name="category" class="form-control">

                    <option value="">All Categories</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>

                            {{ $category->name }}

                        </option>
                    @endforeach

                </select>
            </div>

            <!-- Min Price -->
            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control" placeholder="Min"
                    value="{{ request('min_price') }}">
            </div>

            <!-- Max Price -->
            <div class="col-md-2">
                <input type="number" name="max_price" class="form-control" placeholder="Max"
                    value="{{ request('max_price') }}">
            </div>

            <!-- Sort -->
            <div class="col-md-3">
                <select name="sort" class="form-control">

                    <option value="">Newest</option>

                    <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>
                        Price: Low to High
                    </option>

                    <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>
                        Price: High to Low
                    </option>

                </select>
            </div>

            <!-- Button -->
            <div class="col-md-2">
                <button class="btn btn-warning w-100">
                    Filter
                </button>
            </div>

        </div>

    </form>
    <!-- product section -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">اقسام</span> الموقع</h3>
                        <p>متعه التسوق عبىر فروعنا </p>
                    </div>
                </div>
            </div>

            <div class="row">

                @php
                    $wishlist = session()->get('wishlist', []);
                @endphp
                @foreach ($products as $item)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('products.show', $item->id) }}">

                                    <img src="{{ asset($item->image) }}" class="img-fluid"
                                        style="height:200px; width:100%; object-fit:cover;"></a>
                            </div>
                            <h3>{{ $item->name }}</h3>
                            <p class="text-muted">
                                {{ $item->category->name ?? '' }}
                            </p>
                            <p class="product-price"><span>{{ $item->quantity }}</span> {{ $item->price }} $ </p>

                            <button type="button" class="cart-btn add-btn" onclick="addToCart({{ $item->id }})">
                                🛒 Add to Cart
                            </button>
                            {{-- ❤️ Wishlist --}}
                            @if (in_array($item->id, $wishlist))
                                <a href="{{ url('/wishlist/remove/' . $item->id) }}" class="btn btn-danger mt-2">
                                    ❤️ Added
                                </a>
                            @else
                                <a href="{{ url('/wishlist/add/' . $item->id) }}" class="btn btn-outline-danger mt-2">
                                    🤍 Add to Wishlist
                                </a>
                            @endif

                            <div class="mt-3"></div>

                            <a href="{{ route('products.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $item->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- end product section -->
@endsection
