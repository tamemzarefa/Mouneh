@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">تعديل مستخدم: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-primary">رجوع للقائمة</a>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        @method('PUT')
        @include('admin.users.partials.form', ['mode' => 'edit'])
        <div class="flex justify-end">
            <button class="px-4 py-2 rounded-lg bg-primary text-white">تحديث</button>
        </div>
    </form>
</div>
@endsection
