<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Frontend Products
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter By Category
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Min Price
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        // Max Price
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        if ($request->sort == 'low') {

            $query->orderBy('price', 'asc');

        } elseif ($request->sort == 'high') {

            $query->orderBy('price', 'desc');

        } else {

            $query->latest();
        }

        $products = $query->paginate(6);

        $categories = Category::all();

        return view(
            'frontend.products.index',
            compact('products', 'categories')
        );
    }

    public function show($id)
    {
        $product = Product::with([
            'category',
            'reviews'
        ])->findOrFail($id);

        $relatedProducts = Product::with('category')

            ->where('category_id', $product->category_id)

            ->where('id', '!=', $product->id)

            ->take(4)

            ->get();

        return view(
            'frontend.products.show',
            compact('product', 'relatedProducts')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Products
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::all();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',

            'price' => 'required|numeric|min:0',

            'quantity' => 'required|integer|min:0',

            'image' => 'required|image|mimes:jpg,jpeg,png|max:10000',

            'category_id' => 'required|exists:categories,id'
        ]);

        $path = $request->file('image')
            ->store('products', 'public');

        $data['image'] = 'storage/' . $path;

        Product::create($data);

        return redirect()

            ->route('products.index')

            ->with(
                'success',
                'Product created successfully'
            );
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact('product', 'categories')
        );
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',

            'price' => 'required|numeric|min:0',

            'quantity' => 'required|integer|min:0',

            'category_id' => 'required|exists:categories,id',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10000'
        ]);

        if ($request->hasFile('image')) {

            // حذف القديمة
            if ($product->image) {

                Storage::disk('public')->delete(

                    str_replace(
                        'storage/',
                        '',
                        $product->image
                    )
                );
            }

            $path = $request->file('image')
                ->store('products', 'public');

            $data['image'] = 'storage/' . $path;
        }

        $product->update($data);

        return redirect()

            ->route('products.index')

            ->with(
                'success',
                'Product updated successfully'
            );
    }

    public function destroy(Product $product)
    {
        if ($product->image) {

            Storage::disk('public')->delete(

                str_replace(
                    'storage/',
                    '',
                    $product->image
                )
            );
        }

        $product->delete();

        return redirect()

            ->route('products.index')

            ->with(
                'success',
                'Product deleted successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    public function search(Request $request)
    {
        $query = $request->q;

        $products = Product::with('category')

            ->where(function ($q) use ($query) {

                $q->where('name', 'LIKE', "%{$query}%")

                    ->orWhere(
                        'description',
                        'LIKE',
                        "%{$query}%"
                    );
            })

            ->latest()

            ->paginate(6);

        return view(
            'frontend.search.index',
            compact('products', 'query')
        );
    }

    public function liveSearch(Request $request)
    {
        $query = $request->q;

        $products = Product::select(
            'id',
            'name',
            'price',
            'image'
        )

            ->where(
                'name',
                'LIKE',
                "%{$query}%"
            )

            ->take(5)

            ->get();

        return response()->json($products);
    }
}
