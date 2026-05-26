<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $products = Product::with('category')
            ->whereIn('id', array_keys($cart))
            ->get();

        return view('frontend.cart.index', compact('products', 'cart'));
    }

    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->product_id;

        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'count' => array_sum($cart)
        ]);
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->product_id;
        $quantity = $request->quantity;

        if ($quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $quantity;
        }

        session()->put('cart', $cart);

        return back();
    }

    public function delete(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->product_id;

        unset($cart[$id]);

        session()->put('cart', $cart);

        return back();
    }
}
