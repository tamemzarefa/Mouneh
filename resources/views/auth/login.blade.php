<x-guest-layout>
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold">تسجيل دخول المستخدم</h1>
        <p class="text-sm theme-muted mt-1">مرحباً بك، يرجى إدخال رقم هاتفك وكلمة المرور للمتابعة</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('رقم الهاتف')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autofocus autocomplete="username" placeholder="0912345678" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('كلمة المرور')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" id="togglePassword" class="absolute inset-y-0 left-0 pl-3 pr-3 flex items-center text-sm theme-muted" aria-label="إظهار/إخفاء">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary/50" name="remember">
                <span class="ms-2 text-sm theme-muted">تذكرني</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-primary hover:underline" href="{{ route('password.request') }}">
                    نسيت كلمة المرور؟
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-2">
            <x-primary-button class="ms-3 bg-primary text-white hover:bg-primary/90 focus:ring-primary/40">
                دخول
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 p-4 rounded-xl theme-surface theme-border text-center">
        <div class="text-sm theme-muted mb-2">مستخدم جديد؟</div>
        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-secondary/20 text-primary hover:bg-secondary/30 transition-colors">
            إنشاء حساب جديد
        </a>
    </div>

    <script>
    (function(){
        const btn = document.getElementById('togglePassword');
        const input = document.getElementById('password');
        if (btn && input) {
            btn.addEventListener('click', function(){
                const isPwd = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPwd ? 'text' : 'password');
            });
        }
    })();
    </script>
</x-guest-layout>
