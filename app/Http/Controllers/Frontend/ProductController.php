<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function create(Request $request): View
    {
        $this->authorize('create', Product::class);
        $categories = Category::orderBy('id')->get(['id','name_ar']);
        return view('frontend.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user, 403);
        $this->authorize('create', Product::class);

        $data = $request->validate([
            'title_ar' => ['required','string','max:190'],
            'title_en' => ['nullable','string','max:190'],
            'description_ar' => ['nullable','string'],
            'description_en' => ['nullable','string'],
            'price_cents' => ['required','integer','min:0'],
            'currency' => ['nullable','string','size:3'],
            'stock' => ['nullable','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'primary_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'gallery_images.*' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        // Force ownership and pending status
        $payload = [
            'seller_id' => $user->id,
            'status' => 'pending',
            'is_active' => true,
            'currency' => $data['currency'] ?? 'SYP',
            'stock' => $data['stock'] ?? 0,
        ];

        // Do not persist upload fields
        unset($data['primary_image'], $data['gallery_images']);

        $product = Product::create(array_merge($data, $payload));

        // Spatie media uploads
        if ($request->hasFile('primary_image')) {
            $product->clearMediaCollection('primary');
            $product->addMediaFromRequest('primary_image')->toMediaCollection('primary');
        }
        if ($request->hasFile('gallery_images')) {
            foreach ((array)$request->file('gallery_images') as $file) {
                if (!$file) { continue; }
                $product->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('account.index')->with('status', 'تم إرسال المنتج للمراجعة');
    }

    public function show(Product $product): View
    {
        abort_unless(($product->status ?? null) === 'approved' && $product->is_active, 404);
        $product->load(['images','category','seller']);
        return view('frontend.products.show', compact('product'));
    }
}
