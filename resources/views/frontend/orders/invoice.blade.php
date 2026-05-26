<h1>

    Invoice #{{ $order->id }}

</h1>

<hr>

<p>

    Name:
    {{ $order->name }}

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

@foreach($order->items as $item)

    <p>

        {{ $item->product->name }}

        ×

        {{ $item->quantity }}

    </p>

@endforeach
