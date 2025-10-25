<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $activeCategory = $request->integer('category');
        $q = trim((string) $request->query('q', ''));
        $categories = Category::orderBy('id')
            ->whereNull('parent_id')
            ->limit(6)
            ->get(['id','name_ar']);

        $products = Product::with(['images','category'])
            ->approved()
            ->where('is_active', true)
            ->when($activeCategory, function ($q) use ($activeCategory) {
                $q->where('category_id', $activeCategory);
            })
            ->when($q !== '', function ($query) use ($q) {
                $like = '%'.str_replace(['%','_'], ['\%','\_'], $q).'%';
                $query->where(function ($inner) use ($like) {
                    $inner->where('title_ar', 'like', $like)
                          ->orWhere('description_ar', 'like', $like);
                });
            })
            ->latest()
            ->limit(8)
            ->get();

        return view('frontend.home', compact('categories','products','activeCategory'))
            ->with('searchTerm', $q);
    }
}
