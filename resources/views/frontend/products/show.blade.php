@extends('layouts.master')

@section('content')

    <div class="container mt-150 mb-150">
        <div class="row">

            <div class="col-md-6">
                <img class="img-fluid" src="{{ asset($product->image) }}"
                    style="max-height:400px; width:100%; object-fit:cover;">
            </div>

            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>

                <p class="text-muted">
                    {{ $product->category->name ?? '' }}
                </p>

                <h4>{{ $product->price }} $</h4>

                <p>Quantity: {{ $product->quantity }}</p>

                    <button type="button" class="cart-btn" onclick="addToCart({{ $product->id }})">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
            </div>
        </div>
    </div>

    <!-- related products -->
    <div class="more-products mb-150">
        <div class="container">

            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">

                    <div class="section-title">
                        <h3>
                            <span class="orange-text">Related</span>
                            Products
                        </h3>

                        <p>
                            Products from same category
                        </p>
                    </div>

                </div>
            </div>

            <div class="row">

                @forelse($relatedProducts as $item)
                    <div class="col-lg-3 col-md-6 text-center">

                        <div class="single-product-item">

                            <div class="product-image">

                                <a href="{{ route('products.show', $item->id) }}">

                                    <img src="{{ asset($item->image) }}" style="height:220px;object-fit:cover">

                                </a>

                            </div>

                            <h3>{{ $item->name }}</h3>

                            <p class="product-price">
                                ${{ $item->price }}
                            </p>

                            <a href="{{ route('products.show', $item->id) }}" class="cart-btn">

                                View Product

                            </a>

                        </div>

                    </div>

                @empty

                    <div class="col-12 text-center">

                        <p>No related products</p>

                    </div>
                @endforelse

            </div>

        </div>
    </div>
    <!-- end related products -->

    <hr class="mt-5 mb-5">

    <div class="container mb-150">

        <h3 class="mb-4">⭐ Product Reviews</h3>

        {{-- فورم إضافة Review --}}
        <form action="{{ route('reviews.store') }}" method="POST" class="mb-5">

            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="mb-3">

                <input type="text" name="name" class="form-control" placeholder="Your Name" required>

            </div>

            <div class="mb-3">

                <textarea name="comment" class="form-control" rows="4" placeholder="Write your review..." required></textarea>

            </div>

            <div class="mb-3">

                <select name="rating" class="form-control" required>

                    <option value="">Choose Rating</option>

                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>

                </select>

            </div>

            <button class="btn btn-warning">

                Submit Review

            </button>

        </form>

        {{-- عرض الريفيوهات --}}
        @forelse($product->reviews as $review)
            <div class="card p-3 mb-3 shadow-sm">

                <div class="d-flex justify-content-between">

                    <strong>
                        {{ $review->name }}
                    </strong>

                    <span>

                        @for ($i = 1; $i <= $review->rating; $i++)
                            ⭐
                        @endfor

                    </span>

                </div>

                <p class="mt-2 mb-1">
                    {{ $review->comment }}
                </p>

                <small class="text-muted">
                    {{ $review->created_at->diffForHumans() }}
                </small>

            </div>

        @empty

            <div class="alert alert-warning">

                No reviews yet 😢

            </div>
        @endforelse

    </div>
@endsection
