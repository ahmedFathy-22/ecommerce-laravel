@extends('layouts.master')

@section('content')
    <div class="container mt-150 mb-150 text-center">

        <div class="card shadow p-5">

            <h1 class="text-success mb-4">

                ✅ Payment Successful

            </h1>

            <h4>

                Order ID:
                #{{ $order->id }}

            </h4>

            <h4>

                Total:
                {{ $order->total }} $

            </h4>

            <h4>

                Status:
                {{ $order->payment_status }}

            </h4>

            <a href="{{ route('home') }}" class="btn btn-success mt-4">

                Back Home

            </a>

        </div>

    </div>
@endsection
