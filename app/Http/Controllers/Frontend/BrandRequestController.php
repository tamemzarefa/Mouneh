<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BrandRequestController extends Controller
{
    public function create(Request $request): View
    {
        return view('frontend.brands.request');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:4096',
            'cover' => 'nullable|image|max:6144',
            'legal_name' => 'nullable|string|max:255',
            'entity_type' => 'nullable|in:company,establishment,sole',
            'registration_number' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:120',
            'city' => 'nullable|string|max:120',
            'established_at' => 'nullable|date',
            'support_email' => 'nullable|email',
            'support_phone' => 'nullable|string|max:40',
            'address' => 'nullable|string|max:255',
            'shipping_policy' => 'nullable|string',
            'return_policy' => 'nullable|string',
            'warranty_policy' => 'nullable|string',
            // documents
            'registration_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:8192',
            'tax_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:8192',
            'authorization_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:8192',
            'id_front' => 'nullable|image|max:4096',
            'id_back' => 'nullable|image|max:4096',
        ]);

        $brand = Brand::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => 'pending',
            'status' => 'pending',
            'legal_name' => $data['legal_name'] ?? null,
            'entity_type' => $data['entity_type'] ?? null,
            'registration_number' => $data['registration_number'] ?? null,
            'tax_number' => $data['tax_number'] ?? null,
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'established_at' => $data['established_at'] ?? null,
            'support_email' => $data['support_email'] ?? null,
            'support_phone' => $data['support_phone'] ?? null,
            'address' => $data['address'] ?? null,
            'shipping_policy' => $data['shipping_policy'] ?? null,
            'return_policy' => $data['return_policy'] ?? null,
            'warranty_policy' => $data['warranty_policy'] ?? null,
        ]);

        if ($request->hasFile('logo')) {
            $brand->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        if ($request->hasFile('cover')) {
            $brand->addMediaFromRequest('cover')->toMediaCollection('cover');
        }
        if ($request->hasFile('registration_doc')) {
            $brand->addMediaFromRequest('registration_doc')->usingName('registration')->toMediaCollection('documents');
        }
        if ($request->hasFile('tax_doc')) {
            $brand->addMediaFromRequest('tax_doc')->usingName('tax')->toMediaCollection('documents');
        }
        if ($request->hasFile('authorization_doc')) {
            $brand->addMediaFromRequest('authorization_doc')->usingName('authorization')->toMediaCollection('documents');
        }
        if ($request->hasFile('id_front')) {
            $brand->addMediaFromRequest('id_front')->usingName('id_front')->toMediaCollection('documents');
        }
        if ($request->hasFile('id_back')) {
            $brand->addMediaFromRequest('id_back')->usingName('id_back')->toMediaCollection('documents');
        }

        return Redirect::route('brands.show', $brand)->with('status', 'تم إرسال طلب تسجيل العلامة، سيتم مراجعته قريباً');
    }
}
