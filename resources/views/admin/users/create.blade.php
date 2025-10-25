@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">إضافة مستخدم</h2>
        <x-ui.btn variant="ghost" size="sm" :href="route('admin.users.index')">رجوع للقائمة</x-ui.btn>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="card theme-surface theme-border">
        @csrf
        <div class="card-body space-y-4">
            @include('admin.users.partials.form', ['mode' => 'create'])
            <div class="flex justify-end gap-2">
                <x-ui.btn variant="secondary" size="sm" :href="route('admin.users.index')">إلغاء</x-ui.btn>
                <x-ui.btn variant="primary" type="submit">حفظ</x-ui.btn>
            </div>
        </div>
    </form>
</div>
@endsection
