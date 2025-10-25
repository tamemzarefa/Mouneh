<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $brands = Brand::query()
            ->when($q !== '', function ($query) use ($q) {
                $like = '%'.str_replace(['%','_'], ['\\%','\\_'], $q).'%';
                $query->where('name', 'like', $like)->orWhere('description', 'like', $like);
            })
            ->orderByRaw('verified_at IS NULL') // verified first
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.brands.index', compact('brands'))->with('searchTerm', $q);
    }

    public function show(Brand $brand, Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $categoryId = $request->integer('category');

        $products = $brand->products()
            ->with(['images','category'])
            ->approved()
            ->where('is_active', true)
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($q !== '', function ($query) use ($q) {
                $like = '%'.str_replace(['%','_'], ['\\%','\\_'], $q).'%';
                $query->where(function ($inner) use ($like) {
                    $inner->where('title_ar', 'like', $like)
                          ->orWhere('description_ar', 'like', $like);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.brands.show', compact('brand','products'))
            ->with('searchTerm', $q)
            ->with('activeCategory', $categoryId);
    }
}
