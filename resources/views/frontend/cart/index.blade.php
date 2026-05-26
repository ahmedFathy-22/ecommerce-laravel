@extends('layouts.master')

@section('content')

    <div class="container mt-150 mb-150">
        <h2 class="mb-4">🛒 Your Cart</h2>

        @php $total = 0; @endphp

        @if (count($products) == 0)
            <p>Your cart is empty</p>
        @else
            @foreach ($products as $product)
                @php
                    $quantity = $cart[$product->id];
                    $total += $product->price * $quantity;
                @endphp

                <div class="single-product-item p-3 mb-3">

                    <div class="row align-items-center">

                        <!-- image -->
                        <div class="col-md-2">
                            <img src="{{ asset($product->image) }}" class="img-fluid"
                                style="height:100px; width:100%; object-fit:cover; border-radius:10px;">
                        </div>

                        <!-- info -->
                        <div class="col-md-3">
                            <h5>{{ $product->name }}</h5>
                            <p class="product-price">{{ $product->price }} $</p>
                        </div>

                        <!-- quantity -->
                        <div class="col-md-3">
                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <input type="number" name="quantity" value="{{ $quantity }}" min="1"
                                    class="form-control me-2">

                                <button class="cart-btn cart-update-btn">
                                    Update
                                </button>
                            </form>
                        </div>

                        <!-- delete -->
                        <div class="col-md-2">
                            <form action="{{ route('cart.delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="cart-btn cart-remove-btn">
                                    Remove
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            @endforeach

            <div class="text-end mt-4">
                {{-- Coupon Form --}}
                <form action="{{ route('coupon.apply') }}" method="POST" class="mb-4">

                    @csrf

                    <div class="d-flex gap-2">

                        <input type="text" name="code" class="form-control" placeholder="Coupon Code">

                        <button class="btn btn-warning">

                            Apply

                        </button>

                    </div>

                </form>

                @php

                    $discount = 0;

                    if (session()->has('coupon')) {
                        $coupon = session('coupon');

                        if ($coupon['type'] == 'percent') {
                            $discount = ($total * $coupon['discount']) / 100;
                        } else {
                            $discount = $coupon['discount'];
                        }
                    }

                    $finalTotal = $total - $discount;

                @endphp

                @if (session()->has('coupon'))
                    <div class="alert alert-success">

                        Coupon Applied:
                        <strong>

                            {{ session('coupon.code') }}

                        </strong>

                    </div>

                    <h5>

                        Discount:
                        {{ $discount }} $

                    </h5>
                @endif

                <h4>

                    Final Total:
                    <strong>

                        {{ $finalTotal }} $

                    </strong>

                </h4>
            </div>
            <a href="{{ route('checkout') }}" class="btn btn-success mt-3">
                Proceed to Checkout
            </a>
        @endif

    </div>

@endsection
