<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();

        return view('frontend.home', compact('categories'));
    }
}
