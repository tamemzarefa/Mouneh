<x-guest-layout>
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold">نسيت كلمة المرور؟</h1>
        <p class="text-sm theme-muted mt-1">لا مشكلة، أدخل رقم هاتفك وسنرسل لك رابط إعادة تعيين كلمة المرور</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('رقم الهاتف')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autofocus placeholder="0912345678" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('إرسال رابط إعادة تعيين كلمة المرور') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 p-4 rounded-xl theme-surface theme-border text-center">
        <div class="text-sm theme-muted mb-2">تذكرت كلمة المرور؟</div>
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-secondary/20 text-primary hover:bg-secondary/30 transition-colors">
            تسجيل الدخول
        </a>
    </div>
</x-guest-layout>
