@extends('layouts.master')

@section('content')

    <!-- Categories Section -->
    <div class="product-section mt-150 mb-150">

        <div class="container">

            <div class="row">

                <div class="col-lg-8 offset-lg-2 text-center">

                    <div class="section-title">

                        <h3>

                            <span class="orange-text">
                                Our
                            </span>

                            Categories

                        </h3>

                        <p>

                            Explore our store categories and discover amazing products

                        </p>

                    </div>

                </div>

            </div>

            <div class="row">

                @forelse ($categories as $item)

                    <div class="col-lg-4 col-md-6 text-center mb-4">

                        <div class="single-product-item custom-card h-100">

                            <!-- Category Image -->
                            <div class="product-image">

                                <a href="{{ route('categories.show', $item->id) }}">

                                    <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid"
                                        style="height:200px; width:100%; object-fit:cover;">

                                </a>

                            </div>

                            <!-- Category Name -->
                            <h3 class="mt-3">

                                {{ $item->name }}

                            </h3>

                            <!-- Description -->
                            <p>

                                {{ $item->description }}

                            </p>

                            <!-- Button -->
                            <a
                                href="{{ route('categories.show', $item->id) }}"
                                class="cart-btn mt-3"
                            >
                                Explore Products
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="col-12 text-center">

                        <div class="alert alert-warning">

                            No Categories Found

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

@endsection
