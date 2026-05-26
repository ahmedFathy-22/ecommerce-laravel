<h2>
    ✅ Order Confirmed
</h2>

<p>

    Thanks {{ $order->name }}

</p>

<hr>

<h3>

    Order Details

</h3>

<p>

    Order ID:
    #{{ $order->id }}

</p>

<p>

    Total:
    {{ $order->total }} $

</p>

<p>

    Payment:
    {{ $order->payment_status }}

</p>

<hr>

<h3>

    Products

</h3>

@foreach($order->items as $item)

    <p>

        {{ $item->product->name }}

        ×

        {{ $item->quantity }}

    </p>

@endforeach
