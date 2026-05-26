@extends('layouts.master')

@section('content')
    <div class="container mt-150 mb-150">

        <h2>📦 Order #{{ $order->id }}</h2>

        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Address:</strong> {{ $order->address }}</p>

        <hr>

        @foreach ($order->items as $item)
            <div class="d-flex justify-content-between border p-3 mb-2">
                <div>{{ $item->product->name }}</div>
                <div>{{ $item->quantity }} × {{ $item->price }} $</div>
            </div>
        @endforeach

        <h4 class="mt-4">Total: {{ $order->total }} $</h4>

    </div>
@endsection
