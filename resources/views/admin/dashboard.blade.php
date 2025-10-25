@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl bg-gradient-to-r from-primary to-secondary p-6 text-white shadow-lg">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">لوحة التحكم</h1>
                <p class="mt-1 text-white/80 text-sm">نظرة عامة سريعة على أهم المؤشرات</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary text-white">
                    تحديث
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card theme-surface theme-border">
            <div class="card-body">
                <div class="text-sm theme-muted">المستخدمون</div>
                <div class="text-3xl font-extrabold">{{ $metrics['users'] }}</div>
                <div class="mt-2">
                    <svg class="w-full h-12" viewBox="0 0 100 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 18 C 10 10, 20 20, 30 12 S 50 6, 60 14 80 22, 100 8" stroke="currentColor" stroke-width="2" style="color: var(--color-primary)" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card theme-surface theme-border">
            <div class="card-body">
                <div class="text-sm theme-muted">طلبات تفعيل البائعين</div>
                <div class="text-3xl font-extrabold">{{ $metrics['sellers_pending'] }}</div>
                <div class="mt-2">
                    <svg class="w-full h-12" viewBox="0 0 100 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 16 C 15 6, 30 18, 45 8 S 70 20, 100 12" stroke="currentColor" stroke-width="2" style="color: var(--color-secondary)" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card theme-surface theme-border">
            <div class="card-body">
                <div class="text-sm theme-muted">المنتجات</div>
                <div class="text-3xl font-extrabold">{{ $metrics['products'] }}</div>
                <div class="mt-2">
                    <svg class="w-full h-12" viewBox="0 0 100 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20 L 10 10 L 20 16 L 30 8 L 40 12 L 50 6 L 60 14 L 70 10 L 80 18 L 90 12 L 100 16" stroke="currentColor" stroke-width="2" style="color: var(--color-primary)" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card theme-surface theme-border">
            <div class="card-body">
                <div class="text-sm theme-muted">طلبات اليوم</div>
                <div class="text-3xl font-extrabold">{{ $metrics['orders_today'] }}</div>
                <div class="mt-2">
                    <svg class="w-full h-12" viewBox="0 0 100 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 14 C 20 18, 40 6, 60 10 S 80 20, 100 12" stroke="currentColor" stroke-width="2" style="color: var(--color-secondary)" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

