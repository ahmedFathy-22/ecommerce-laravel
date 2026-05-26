@extends('layouts.master')

@section('content')
    <div class="container mt-150 mb-150">
        <h2>Checkout</h2>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <select name="payment" class="form-control mb-3">
                <option value="cash">Cash</option>
                <option value="visa">Visa</option>
            </select>
            <button class="btn btn-success">Place Order</button>
        </form>

    </div>
@endsection
