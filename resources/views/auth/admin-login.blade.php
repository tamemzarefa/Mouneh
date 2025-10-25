<x-guest-layout>
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold">تسجيل دخول المشرف</h1>
        <p class="text-sm theme-muted mt-1">ادخل بيانات حساب المشرف للوصول إلى لوحة التحكم</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('كلمة المرور')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary/50" name="remember">
                <span class="ms-2 text-sm theme-muted">تذكرني</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm link link-primary">دخول المستخدم</a>
            <x-primary-button>
                دخول المشرف
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
