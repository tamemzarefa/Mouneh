<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $addresses = Address::where('user_id', $user->id)->orderByDesc('is_default')->orderBy('id')->get();
        return view('frontend.addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('frontend.addresses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'label' => ['nullable','string','max:60'],
            'recipient_name' => ['nullable','string','max:120'],
            'phone' => ['nullable','string','max:30'],
            'line1' => ['required','string','max:190'],
            'line2' => ['nullable','string','max:190'],
            'city' => ['nullable','string','max:120'],
            'region' => ['nullable','string','max:120'],
            'postal_code' => ['nullable','string','max:20'],
            'country_code' => ['nullable','string','size:2'],
            'is_default' => ['nullable','boolean'],
        ]);

        $user = $request->user();
        $data['user_id'] = $user->id;
        $data['country_code'] = $data['country_code'] ?? 'SY';
        $data['is_default'] = (bool)($data['is_default'] ?? false);

        if ($data['is_default']) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
        }

        Address::create($data);
        return redirect()->route('addresses.index')->with('status', 'تم حفظ العنوان');
    }

    public function makeDefault(Request $request, Address $address): RedirectResponse
    {
        $user = $request->user();
        if ($address->user_id !== $user->id) {
            abort(403);
        }
        Address::where('user_id', $user->id)->update(['is_default' => false]);
        $address->update(['is_default' => true]);
        return back()->with('status', 'تم تعيين العنوان الافتراضي');
    }
}
