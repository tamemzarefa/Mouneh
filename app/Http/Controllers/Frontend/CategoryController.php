<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with(['media','children.media'])
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get(['id','name_ar','image_url']);
        return view('frontend.categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $products = Product::with(['images','category'])
            ->approved()
            ->where('is_active', true)
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(20);

        return view('frontend.categories.show', compact('category','products'));
    }
}
