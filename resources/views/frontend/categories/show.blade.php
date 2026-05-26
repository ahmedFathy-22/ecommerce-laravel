@extends('layouts.master')

@section('content')
    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">

                        <h3>
                            منتجات قسم
                            <span class="orange-text">
                                {{ $category->name }}
                            </span>
                        </h3>

                        <p>{{ $category->description }}</p>

                    </div>
                </div>
            </div>

            <div class="row">

                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">

                            <div class="product-image">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ asset($product->image) }}"
                                        style="height:250px; width:100%; object-fit:cover;">
                                </a>
                            </div>

                            <h3>{{ $product->name }}</h3>

                            <p class="product-price">
                                {{ number_format($product->price, 2) }} جنيه
                            </p>

                        </div>
                    </div>
                @endforeach


            </div>
            <div class="d-flex justify-content-center mt-5">

                {{ $products->links() }}

            </div>
        </div>
    </div>
@endsection
