<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with(['parent','media'])->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parents = Category::orderBy('name_ar')->get(['id','name_ar']);
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'slug' => ['required','string','max:120','unique:categories,slug'],
            'name_ar' => ['required','string','max:120'],
            'name_en' => ['nullable','string','max:120'],
            'parent_id' => ['nullable','exists:categories,id'],
            'image_url' => ['nullable','string','max:255'],
            'image_file' => ['nullable','image','mimes:png,jpg,jpeg,webp','max:5120'],
        ]);

        // do not persist upload fields
        $uploads = [
            'image_file' => $request->file('image_file'),
        ];
        unset($data['image_file']);

        $category = Category::create($data);

        if ($uploads['image_file']) {
            $category->clearMediaCollection('image');
            $category->addMedia($uploads['image_file'])->toMediaCollection('image');
        }
        return redirect()->route('admin.categories.edit', $category)->with('status', 'تم إنشاء التصنيف');
    }

    public function show(Category $category): RedirectResponse
    {
        return redirect()->route('admin.categories.edit', $category);
    }

    public function edit(Category $category): View
    {
        $parents = Category::where('id','!=',$category->id)->orderBy('name_ar')->get(['id','name_ar']);
        return view('admin.categories.edit', compact('category','parents'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'slug' => ['required','string','max:120','unique:categories,slug,'.$category->id],
            'name_ar' => ['required','string','max:120'],
            'name_en' => ['nullable','string','max:120'],
            'parent_id' => ['nullable','exists:categories,id'],
            'image_url' => ['nullable','string','max:255'],
            'image_file' => ['nullable','image','mimes:png,jpg,jpeg,webp','max:5120'],
        ]);

        $uploads = [
            'image_file' => $request->file('image_file'),
        ];
        unset($data['image_file']);

        $category->update($data);

        if ($uploads['image_file']) {
            $category->clearMediaCollection('image');
            $category->addMedia($uploads['image_file'])->toMediaCollection('image');
        }
        return redirect()->route('admin.categories.edit', $category)->with('status', 'تم تحديث التصنيف');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('status', 'تم حذف التصنيف');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required','array'],
            'ids.*' => ['integer','exists:categories,id'],
        ]);
        Category::whereIn('id', $data['ids'])->delete();
        return redirect()->route('admin.categories.index')->with('status', 'تم حذف التصنيفات المحددة');
    }
}
