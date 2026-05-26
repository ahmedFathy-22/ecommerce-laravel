@extends('layouts.master')

@section('content')
    <div class="container mt-150 mb-150">

        <h2 class="mb-5">📦 My Orders</h2>

        @forelse($orders as $order)
            <div class="card p-4 mb-4 shadow-sm">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-3">

                            Order #{{ $order->id }}

                        </h5>

                        <p class="mb-2">

                            Total:

                            <strong>
                                {{ $order->total }} $
                            </strong>

                        </p>

                        <p class="mb-2">

                            Payment:

                            <span
                                class="badge
                                {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }}
                            ">

                                {{ $order->payment_status }}

                            </span>

                        </p>

                        <p class="mb-0">

                            Status:

                            <span
                                class="badge
                                @if ($order->status == 'pending') bg-warning
                                @elseif($order->status == 'processing')
                                    bg-primary
                                @else
                                    bg-success @endif
                            ">

                                {{ $order->status }}

                            </span>

                        </p>

                    </div>

                    <div>

                        <small class="text-muted">

                            {{ $order->created_at->format('d M Y') }}

                        </small>

                    </div>

                </div>

            </div>

        @empty

            <div class="alert alert-warning">

                No orders yet

            </div>
        @endforelse

        <div class="mt-4">

            {{ $orders->links() }}

        </div>

    </div>
@endsection
