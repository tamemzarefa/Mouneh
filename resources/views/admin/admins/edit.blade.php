@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold">تعديل المدير</h2>
                <p class="text-sm theme-muted">تحديث بيانات المدير</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.admins.update', $admin) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('الاسم الكامل')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $admin->name)" required autofocus autocomplete="name" placeholder="الاسم الكامل" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('البريد الإلكتروني')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $admin->email)" required autocomplete="username" placeholder="admin@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('رقم الهاتف (اختياري)')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone', $admin->phone)" autocomplete="username" placeholder="0912345678" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('كلمة المرور الجديدة (اتركها فارغة للاحتفاظ بالكلمة الحالية)')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('تأكيد كلمة المرور الجديدة')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-ghost">إلغاء</a>
                <x-primary-button>تحديث المدير</x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
