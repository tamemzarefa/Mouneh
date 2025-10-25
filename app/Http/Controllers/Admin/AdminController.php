<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of admins.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'regex:/^09\d{8}$/', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.admins.index')->with('status', 'تم إنشاء المدير بنجاح');
    }

    /**
     * Display the specified admin.
     */
    public function show(User $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(User $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin.
     */
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'phone' => ['nullable', 'string', 'regex:/^09\d{8}$/', Rule::unique('users')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('admin.admins.index')->with('status', 'تم تحديث المدير بنجاح');
    }

    /**
     * Remove the specified admin.
     */
    public function destroy(User $admin)
    {
        // Prevent deleting the current admin
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admins.index')->with('error', 'لا يمكن حذف حسابك الخاص');
        }

        $admin->delete();
        return redirect()->route('admin.admins.index')->with('status', 'تم حذف المدير بنجاح');
    }
}