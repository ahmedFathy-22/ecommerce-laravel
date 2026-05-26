@extends('layouts.master')

@section('content')
    <div class="container mt-150 mb-150">

        <div class="text-center mb-5">

            <h1>
                💳 Stripe Payment
            </h1>

            <p>
                Secure Checkout
            </p>

        </div>

        <div class="card p-5 shadow">

            <form action="{{ route('stripe') }}" method="POST">

                @csrf

                <button class="btn btn-success w-100 py-3">

                    Pay With Card

                </button>

            </form>

        </div>

    </div>
@endsection
