<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessMail;


class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $products = Product::with('category')
            ->whereIn(
                'id',
                array_keys($cart)
            )->get();

        return view('frontend.orders.checkout', compact('products', 'cart'));
    }

    public function payment()
    {
        $cart = session()->get('cart', []);

        $products = Product::with('category')
            ->whereIn(
                'id',
                array_keys($cart)
            )->get();

        return view('frontend.orders.payment', compact('products', 'cart'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        $products = Product::with('category')
            ->whereIn(
                'id',
                array_keys($cart)
            )->get();

        $total = 0;

        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }

        $order = Order::create([

            'user_id' => auth()->id(),

            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'total' => $total,
            'payment' => 'stripe',
            'status' => 'pending'

        ]);

        foreach ($products as $product) {

            OrderItem::create([

                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cart[$product->id],
                'price' => $product->price

            ]);
        }

        session()->put('last_order_id', $order->id);

        return redirect()->route('payment');
    }

    public function stripe(Request $request)
    {
        $cart = session()->get('cart', []);

        $products = Product::whereIn(
            'id',
            array_keys($cart)
        )->get();

        $total = 0;

        foreach ($products as $product) {

            $total += $product->price
                * $cart[$product->id];
        }

        // إنشاء الأوردر أولًا

        $order = Order::create([

            'user_id' => auth()->id(),

            'name' => auth()->user()->name,

            'address' => 'Waiting Address',

            'phone' => '000000000',

            'total' => $total,

            'payment' => 'stripe',

            'payment_status' => 'pending',

            'status' => 'pending',

        ]);

        // حفظ المنتجات

        foreach ($products as $product) {

            OrderItem::create([

                'order_id' => $order->id,

                'product_id' => $product->id,

                'quantity' => $cart[$product->id],

                'price' => $product->price

            ]);
        }

        $lineItems = [];

        foreach ($products as $product) {

            $lineItems[] = [

                'price_data' => [

                    'currency' => 'usd',

                    'product_data' => [

                        'name' => $product->name,

                    ],

                    'unit_amount' => $product->price * 100,

                ],

                'quantity' => $cart[$product->id],

            ];
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([

            'payment_method_types' => ['card'],

            'line_items' => $lineItems,

            'mode' => 'payment',

            'success_url' => route(
                'payment.success',
                $order->id
            ),

            'cancel_url' => route('cart'),

        ]);

        return redirect($session->url);
    }
    public function success(Order $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing'
        ]);
        session()->forget('cart');
        Mail::to(auth()->user()->email)

            ->send(new OrderSuccessMail($order));
        return view('frontend.orders.payment-success', compact('order'));
    }

}
