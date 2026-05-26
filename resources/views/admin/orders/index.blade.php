@extends('layouts.master')

@section('content')
    <div class="container mt-150 mb-150">

        <h2 class="mb-4">📦 Orders</h2>

        <form method="GET" class="mb-4">
            <select name="status" onchange="this.form.submit()" class="form-select w-25">
                <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </form>
        @if ($orders->count() == 0)
            <div class="alert alert-warning">

                No Orders Found

            </div>
        @endif
        @foreach ($orders as $order)
            <div class="card mb-3 p-3 shadow-sm d-flex justify-content-between align-items-center flex-row">

                <!-- بيانات العميل -->
                <div>
                    <h5>

                        #{{ $order->id }}

                        -

                        {{ $order->user->name ?? $order->name }}

                    </h5>
                    <small>{{ $order->phone }}</small>
                </div>

                <div>
                    <strong>{{ $order->total }} $</strong>

                    <br>

                    <small>

                        Payment:

                        <span
                            class="badge
                    {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }}
                ">

                            {{ $order->payment_status }}

                        </span>

                    </small>

                    <!-- حالة -->
                    <span
                        class="badge
                    @if ($order->status == 'pending') bg-warning
                    @elseif($order->status == 'processing') bg-primary
                    @else bg-success @endif
                ">
                        {{ $order->status }}
                    </span>
                </div>

                <!-- زر التفاصيل -->
                <div>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                        View Details
                    </a>
                    <form action="{{ route('orders.status', $order->id) }}" method="POST" class="mt-2">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">

                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                Processing
                            </option>

                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                        </select>
                    </form>
                </div>

            </div>
        @endforeach
        {{ $orders->links() }}
    </div>
@endsection
