@extends('layouts.master')

@section('content')
    <div class="container mt-150 mb-150 text-center">

        <h2 class="text-success mb-4">✅ Order Placed Successfully</h2>

        <p>Thank you <strong>{{ $order->name }}</strong> 🙏</p>
        <p>Your order ID: <strong>#{{ $order->id }}</strong></p>

        <hr>

        <h4 class="mt-4">🛒 Order Details</h4>

        @foreach ($order->items as $item)
            <div class="d-flex justify-content-between border p-3 mb-2">
                <div>
                    <strong>{{ $item->product->name }}</strong>
                </div>

                <div>
                    {{ $item->quantity }} × {{ $item->price }} $
                </div>
            </div>
        @endforeach

        <h3 class="mt-4">Total: {{ $order->total }} $</h3>

        <a href="/" class="btn btn-primary mt-4">Back to Home</a>

    </div>
@endsection
