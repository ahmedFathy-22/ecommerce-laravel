<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    // ✅ عرض الـ wishlist
    public function index()
    {
        $wishlist = Wishlist::with('product.category')

            ->where('user_id', auth()->id())

            ->latest()

            ->paginate(6);

        return view('frontend.wishlist.index', compact('wishlist'));
    }

    // ✅ إضافة منتج
    public function add($id)
    {
        if (!Product::find($id)) {

            return back()->with(
                'error',
                'Product not found'
            );
        }

        Wishlist::firstOrCreate([

            'user_id' => auth()->id(),

            'product_id' => $id

        ]);

        return back()->with(
            'success',
            'Added to wishlist ❤️'
        );
    }

    // ✅ حذف منتج
    public function remove($id)
    {
        Wishlist::where('user_id', auth()->id())

            ->where('product_id', $id)

            ->delete();

        return back()->with(
            'success',
            'Removed from wishlist 🗑️'
        );
    }
}
