@extends('layouts.master')

@section('content')
    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">المنتجات</span> المفضلة</h3>
                        <p>اختياراتك المحفوظة</p>
                    </div>
                </div>
            </div>

            <div class="row">


                @forelse ($wishlist as $item)
                    @php
                        $product = $item->product;
                    @endphp
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item position-relative">

                            {{-- ❤️ أيقونة Wishlist فوق --}}
                            <div style="position:absolute; top:10px; right:10px;">
                                <a href="{{ url('/wishlist/remove/' . $product->id) }}" style="font-size:22px; color:red;">
                                    ❤️
                                </a>
                                <a href="{{ url('/wishlist/add/' . $product->id) }}" style="font-size:22px; color:#ccc;">
                                    🤍
                                </a>
                            </div>

                            {{-- الصورة --}}
                            <div class="product-image">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ asset($product->image) }}" class="img-fluid"
                                        style="height:200px; width:100%; object-fit:cover;">
                                </a>
                            </div>

                            {{-- الاسم --}}
                            <h3>{{ $product->name }}</h3>

                            {{-- الكاتيجوري --}}
                            <p class="text-muted">
                                {{ $product->category->name ?? '' }}
                            </p>

                            {{-- السعر --}}
                            <p class="product-price">
                                {{ $product->price }} $
                            </p>

                            {{-- زر أساسي واحد بس --}}
                            <button type="button" class="cart-btn add-btn mt-2" onclick="addToCart({{ $product->id }})" 🛒
                                Add to Cart </button>

                        </div>
                    </div>
                @empty

                    <div class="col-12 text-center">
                        <div class="alert alert-warning">
                            😢 مفيش منتجات في الـ Wishlist
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
        <div class="mt-4">
            {{ $wishlist->links() }}
        </div>
    </div>
@endsection
