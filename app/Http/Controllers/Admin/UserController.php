<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $user = User::create($data);
        return redirect()->route('admin.users.edit', $user)->with('status', 'تم إنشاء المستخدم');
    }

    public function show(User $user): RedirectResponse
    {
        return redirect()->route('admin.users.edit', $user);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email,'.$user->id],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('admin.users.edit', $user)->with('status', 'تم تحديث المستخدم');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return back()->withErrors(['message' => 'لا يمكن حذف الحساب الخاص بك.']);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'تم حذف المستخدم');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required','array'],
            'ids.*' => ['integer','exists:users,id'],
        ]);
        // Prevent deleting the currently authenticated user and admin users
        $ids = array_filter($data['ids'], fn($id) => (int)$id !== (int)Auth::id());
        if (!empty($ids)) {
            User::whereIn('id', $ids)->where('role', '!=', 'admin')->delete();
        }
        return redirect()->route('admin.users.index')->with('status', 'تم حذف المستخدمين المحددين');
    }
}
