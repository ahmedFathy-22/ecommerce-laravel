@extends('layouts.master')

@section('content')

    <div class="container mt-150 mb-150">

        <h2 class="mb-4">🔍 Results for: "{{ $query }}"</h2>

        @if ($products->count() > 0)
            <div class="row">

                @foreach ($products as $item)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">

                            <div class="product-image">
                                <img src="{{ asset($item->image) }}" style="height:200px; width:100%; object-fit:cover;">
                            </div>

                            <h3>{{ $item->name }}</h3>
                            <p>{{ $item->price }} $</p>

                        </div>
                    </div>
                @endforeach

            </div>
        @else
            <p>No products found 😢</p>
        @endif

    </div>

@endsection
