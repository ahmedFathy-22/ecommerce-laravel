<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Frontend Categories
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $categories = Category::latest()->get();

        return view(
            'frontend.categories.index',
            compact('categories')
        );
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        $products = $category->products()

            ->with('category')

            ->latest()

            ->paginate(6);

        return view(
            'frontend.categories.show',
            compact('products', 'category')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Categories
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $path = $request->file('image')
            ->store('categories', 'public');

        $data['image'] = 'storage/' . $path;

        Category::create($data);

        return redirect()

            ->route('categories.index')

            ->with(
                'success',
                'Category created successfully'
            );
    }

    public function edit(Category $category)
    {
        return view(
            'admin.categories.edit',
            compact('category')
        );
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        if ($request->hasFile('image')) {

            // حذف القديمة
            if ($category->image) {

                Storage::disk('public')->delete(

                    str_replace(
                        'storage/',
                        '',
                        $category->image
                    )
                );
            }

            $path = $request->file('image')
                ->store('categories', 'public');

            $data['image'] = 'storage/' . $path;
        }

        $category->update($data);

        return redirect()

            ->route('categories.index')

            ->with(
                'success',
                'Category updated successfully'
            );
    }

    public function destroy(Category $category)
    {
        if ($category->image) {

            Storage::disk('public')->delete(

                str_replace(
                    'storage/',
                    '',
                    $category->image
                )
            );
        }

        $category->delete();

        return redirect()

            ->route('categories.index')

            ->with(
                'success',
                'Category deleted successfully'
            );
    }
}
