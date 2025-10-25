<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm text-gray-700 mb-1">الاسم</label>
        <input name="name" value="{{ old('name', $user->name ?? '') }}" class="input input-bordered w-full" required />
        @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">البريد</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="input input-bordered w-full" required />
        @error('email')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">كلمة المرور</label>
        <input type="password" name="password" class="input input-bordered w-full" @if(($mode ?? 'create')==='create') required @endif />
        @error('password')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation" class="input input-bordered w-full" @if(($mode ?? 'create')==='create') required @endif />
    </div>
</div>
