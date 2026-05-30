@extends('layouts.master')

@section('content')

<div class="mt-150 mb-150">
    <div class="container">

        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">

                <div class="section-title">
                    <h3>
                        <span class="orange-text">About</span> Us
                    </h3>

                    <p>
                        Smart Store is an ecommerce platform built with Laravel.
                        The project allows users to browse products, manage wishlists,
                        place orders, and complete online purchases through a modern
                        and responsive interface.
                    </p>
                </div>

            </div>
        </div>

        <div class="row">

            <div class="col-md-4 text-center">
                <h4>Products</h4>
                <p>
                    Browse products across multiple categories.
                </p>
            </div>

            <div class="col-md-4 text-center">
                <h4>Wishlist</h4>
                <p>
                    Save favorite products for later.
                </p>
            </div>

            <div class="col-md-4 text-center">
                <h4>Orders</h4>
                <p>
                    Secure checkout and order tracking.
                </p>
            </div>

        </div>

    </div>
</div>

@endsection
