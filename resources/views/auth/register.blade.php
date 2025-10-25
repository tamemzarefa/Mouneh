<x-guest-layout>
    <div class="text-center mb-4">
        <h1 class="text-xl font-bold">إنشاء حساب جديد</h1>
        <p class="text-sm theme-muted mt-1">يرجى تعبئة البيانات التالية للانضمام إلى منصة مؤونة</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('الاسم الكامل')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="الاسم الكامل" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('رقم الهاتف')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="username" placeholder="0912345678" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email Address (Optional) -->
        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني (اختياري)')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('كلمة المرور')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" id="togglePasswordReg" class="absolute inset-y-0 left-0 pl-3 pr-3 flex items-center text-sm theme-muted" aria-label="إظهار/إخفاء">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/></svg>
                </button>
            </div>
            <!-- Password Strength Indicator -->
            <div id="password-strength" class="mt-2 hidden">
                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div id="strength-bar" class="h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <span id="strength-text" class="text-sm font-medium"></span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('تأكيد كلمة المرور')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" id="togglePasswordReg2" class="absolute inset-y-0 left-0 pl-3 pr-3 flex items-center text-sm theme-muted" aria-label="إظهار/إخفاء">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-2">
            <a class="text-sm theme-muted hover:text-primary" href="{{ route('login') }}">
                لديك حساب؟ تسجيل الدخول
            </a>

            <x-primary-button class="ms-3 bg-primary text-white hover:bg-primary/90 focus:ring-primary/40">
                إنشاء حساب
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <div class="text-sm theme-muted mb-2">هل تملك براند؟</div>
        <a href="{{ route('brands.register') }}" class="btn btn-primary inline-flex items-center gap-2">
            <span>سجّل علامتك الآن</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 4.5l6 6-6 6m-9-6h15"/></svg>
        </a>
    </div>

    <script>
    (function(){
        const t1 = document.getElementById('togglePasswordReg');
        const p1 = document.getElementById('password');
        const t2 = document.getElementById('togglePasswordReg2');
        const p2 = document.getElementById('password_confirmation');
        if (t1 && p1) t1.addEventListener('click', () => {
            const isPwd = p1.getAttribute('type') === 'password';
            p1.setAttribute('type', isPwd ? 'text' : 'password');
        });
        if (t2 && p2) t2.addEventListener('click', () => {
            const isPwd = p2.getAttribute('type') === 'password';
            p2.setAttribute('type', isPwd ? 'text' : 'password');
        });

        // Password Strength Checker
        function checkPasswordStrength(password) {
            let score = 0;
            let feedback = [];

            // Length check
            if (password.length >= 8) score += 1;
            else feedback.push('يجب أن تكون كلمة المرور 8 أحرف على الأقل');

            // Lowercase check
            if (/[a-z]/.test(password)) score += 1;
            else feedback.push('يجب أن تحتوي على حروف صغيرة');

            // Uppercase check
            if (/[A-Z]/.test(password)) score += 1;
            else feedback.push('يجب أن تحتوي على حروف كبيرة');

            // Number check
            if (/\d/.test(password)) score += 1;
            else feedback.push('يجب أن تحتوي على أرقام');

            // Special character check
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score += 1;
            else feedback.push('يجب أن تحتوي على رموز خاصة');

            return { score, feedback };
        }

        function updatePasswordStrength() {
            const password = p1.value;
            const strengthDiv = document.getElementById('password-strength');
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');

            if (password.length === 0) {
                strengthDiv.classList.add('hidden');
                return;
            }

            strengthDiv.classList.remove('hidden');

            const { score, feedback } = checkPasswordStrength(password);
            const percentage = (score / 5) * 100;

            strengthBar.style.width = percentage + '%';

            if (score <= 2) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-red-500';
                strengthText.textContent = 'ضعيف';
                strengthText.className = 'text-sm font-medium text-red-500';
            } else if (score <= 3) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-yellow-500';
                strengthText.textContent = 'متوسط';
                strengthText.className = 'text-sm font-medium text-yellow-500';
            } else {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-green-500';
                strengthText.textContent = 'قوي';
                strengthText.className = 'text-sm font-medium text-green-500';
            }
        }

        if (p1) {
            p1.addEventListener('input', updatePasswordStrength);
        }
    })();
    </script>
</x-guest-layout>
