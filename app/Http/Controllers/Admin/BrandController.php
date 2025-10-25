<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.brands.index', compact('brands', 'q'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:4096',
            'cover' => 'nullable|image|max:6144',
            'seller_profile_id' => 'nullable|exists:seller_profiles,id',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        $brand = Brand::create(collect($data)->except(['logo','cover'])->all());

        if ($request->hasFile('logo')) {
            $brand->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        if ($request->hasFile('cover')) {
            $brand->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return Redirect::route('admin.brands.edit', $brand)->with('status', 'تم إنشاء العلامة');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug,'.$brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:4096',
            'cover' => 'nullable|image|max:6144',
            'seller_profile_id' => 'nullable|exists:seller_profiles,id',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        $brand->update(collect($data)->except(['logo','cover'])->all());

        if ($request->hasFile('logo')) {
            $brand->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        if ($request->hasFile('cover')) {
            $brand->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return Redirect::back()->with('status', 'تم حفظ التغييرات');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return Redirect::route('admin.brands.index')->with('status', 'تم حذف العلامة');
    }

    public function approve(Brand $brand)
    {
        $brand->forceFill([
            'status' => 'approved',
            'verified_at' => now(),
        ])->save();
        return Redirect::back()->with('status', 'تم اعتماد العلامة ووسمها كموثّقة');
    }

    public function reject(Brand $brand)
    {
        $brand->forceFill([
            'status' => 'rejected',
            'verified_at' => null,
        ])->save();
        return Redirect::back()->with('status', 'تم رفض العلامة');
    }
}
