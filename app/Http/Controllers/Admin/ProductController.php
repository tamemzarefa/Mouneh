<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with(['seller', 'category','images'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('id')->get(['id','name_ar']);
        $sellers = User::orderBy('name')->get(['id','name']);
        return view('admin.products.create', compact('categories','sellers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title_ar' => ['required','string','max:190'],
            'title_en' => ['nullable','string','max:190'],
            'description_ar' => ['nullable','string'],
            'description_en' => ['nullable','string'],
            'price_cents' => ['required','integer','min:0'],
            'currency' => ['nullable','string','size:3'],
            'stock' => ['nullable','integer','min:0'],
            'is_active' => ['nullable','boolean'],
            'category_id' => ['required','exists:categories,id'],
            'seller_id' => ['required','exists:users,id'],
            'primary_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'gallery_images.*' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $data['currency'] = $data['currency'] ?? 'SYP';
        $data['stock'] = $data['stock'] ?? 0;
        // Do not persist upload fields as columns
        unset($data['primary_image'], $data['gallery_images']);

        $product = Product::create($data);

        // images via Spatie Media Library
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
        return redirect()->route('admin.products.edit', $product)->with('status', 'تم إنشاء المنتج بنجاح');
    }

    public function show(Product $product): RedirectResponse
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('id')->get(['id','name_ar']);
        $sellers = User::orderBy('name')->get(['id','name']);
        return view('admin.products.edit', compact('product','categories','sellers'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'title_ar' => ['required','string','max:190'],
            'title_en' => ['nullable','string','max:190'],
            'description_ar' => ['nullable','string'],
            'description_en' => ['nullable','string'],
            'price_cents' => ['required','integer','min:0'],
            'currency' => ['nullable','string','size:3'],
            'stock' => ['nullable','integer','min:0'],
            'is_active' => ['nullable','boolean'],
            'category_id' => ['required','exists:categories,id'],
            'seller_id' => ['required','exists:users,id'],
            'primary_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'gallery_images.*' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? false);
        // Do not persist upload fields as columns
        unset($data['primary_image'], $data['gallery_images']);
        $product->update($data);

        // Append new images via Spatie
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
        return redirect()->route('admin.products.edit', $product)->with('status', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', 'تم حذف المنتج');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required','array'],
            'ids.*' => ['integer','exists:products,id'],
        ]);
        Product::whereIn('id', $data['ids'])->delete();
        return redirect()->route('admin.products.index')->with('status', 'تم حذف المنتجات المحددة');
    }

    public function approve(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'notes' => ['nullable', 'string', 'max:500']
        ]);

        $product->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        // Create approval notification for seller
        $this->notifySellerOfApproval($product, $data['notes'] ?? null);

        // Log the approval action
        $this->logApprovalAction($product, $request->user(), $data['notes'] ?? null);

        return back()->with('status', 'تمت الموافقة على المنتج وإرسال إشعار للبائع');
    }

    public function reject(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'reason' => ['nullable','string','max:2000']
        ]);
        $product->update([
            'status' => 'rejected',
            'approved_by' => null,
            'rejection_reason' => $data['reason'] ?? null,
        ]);
        return back()->with('status', 'تم رفض المنتج');
    }

    public function bulkApprove(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:products,id'],
            'notes' => ['nullable', 'string', 'max:500']
        ]);

        $products = Product::whereIn('id', $data['ids'])->get();
        $approvedCount = 0;

        foreach ($products as $product) {
            if ($product->status !== 'approved') {
                $product->update([
                    'status' => 'approved',
                    'approved_by' => $request->user()->id,
                    'approved_at' => now(),
                    'rejection_reason' => null,
                ]);

                $this->notifySellerOfApproval($product, $data['notes'] ?? null);
                $this->logApprovalAction($product, $request->user(), $data['notes'] ?? null);
                $approvedCount++;
            }
        }

        return back()->with('status', "تمت الموافقة على {$approvedCount} منتج");
    }

    private function notifySellerOfApproval(Product $product, ?string $notes = null): void
    {
        // Create a notification record for the seller
        // This could be expanded to send email, SMS, or push notifications
        \Log::info("Product approved notification", [
            'product_id' => $product->id,
            'product_title' => $product->title_ar,
            'seller_id' => $product->seller_id,
            'seller_name' => $product->seller->name,
            'approved_at' => now(),
            'notes' => $notes
        ]);

        // You can add database notifications here
        // $product->seller->notify(new ProductApprovedNotification($product, $notes));
    }

    private function logApprovalAction(Product $product, User $admin, ?string $notes = null): void
    {
        // Log the approval action for audit purposes
        \Log::info("Product approval action", [
            'action' => 'product_approved',
            'product_id' => $product->id,
            'product_title' => $product->title_ar,
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'seller_id' => $product->seller_id,
            'approved_at' => now(),
            'notes' => $notes
        ]);
    }
}
