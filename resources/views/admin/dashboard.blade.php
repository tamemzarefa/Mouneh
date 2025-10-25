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
        <a href="{{ route('admin.users.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
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
        </a>

        <a href="{{ route('admin.users.index', ['pending_sellers' => 1]) }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
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
        </a>

        <a href="{{ route('admin.products.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
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
        </a>

        <a href="{{ route('admin.orders.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
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
        </a>
        <!-- Extra metrics -->
        <a href="{{ route('admin.categories.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
                <div class="card-body">
                    <div class="text-sm theme-muted">الفئات</div>
                    <div class="text-3xl font-extrabold">{{ $metrics['categories'] }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.brands.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
                <div class="card-body">
                    <div class="text-sm theme-muted">العلامات التجارية</div>
                    <div class="text-3xl font-extrabold">{{ $metrics['brands'] }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
                <div class="card-body">
                    <div class="text-sm theme-muted">طلبات قيد المعالجة</div>
                    <div class="text-3xl font-extrabold">{{ $metrics['orders_processing'] }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
                <div class="card-body">
                    <div class="text-sm theme-muted">طلبات مكتملة</div>
                    <div class="text-3xl font-extrabold">{{ $metrics['orders_completed'] }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.transactions.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
                <div class="card-body">
                    <div class="text-sm theme-muted">إجمالي المعاملات (مدفوعة)</div>
                    <div class="text-3xl font-extrabold">{{ number_format($metrics['transactions_paid_total_cents'] / 100, 2) }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.transactions.index') }}" class="block focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-2xl">
            <div class="card theme-surface theme-border transition ring-0 hover:ring-2 hover:ring-primary/20">
                <div class="card-body">
                    <div class="text-sm theme-muted">الرصيد الصافي</div>
                    <div class="text-3xl font-extrabold">{{ number_format($metrics['net_balance_cents'] / 100, 2) }}</div>
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
        <div class="card theme-surface theme-border">
            <div class="card-body">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-semibold">آخر 5 طلبات</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary">عرض الكل</a>
                </div>
                <div class="divide-y">
                    @forelse($latestOrders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between py-2 hover:bg-muted/10 rounded px-2">
                            <div class="text-sm">
                                <div class="font-medium">#{{ $order->id }} - {{ $order->status }}</div>
                                <div class="theme-muted">{{ $order->buyer->name ?? '-' }} → {{ $order->seller->name ?? '-' }}</div>
                            </div>
                            <div class="text-xs theme-muted">{{ $order->created_at->diffForHumans() }}</div>
                        </a>
                    @empty
                        <div class="text-sm theme-muted">لا توجد طلبات</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card theme-surface theme-border">
            <div class="card-body">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-semibold">آخر 5 منتجات قيد الموافقة</h3>
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-primary">عرض الكل</a>
                </div>
                <div class="divide-y">
                    @forelse($latestPendingProducts as $product)
                        <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between py-2 hover:bg-muted/10 rounded px-2">
                            <div class="text-sm">
                                <div class="font-medium">{{ $product->name ?? ('#'.$product->id) }}</div>
                                <div class="theme-muted">{{ $product->seller->name ?? '-' }} {{ $product->brand ? '• '.$product->brand->name : '' }}</div>
                            </div>
                            <div class="text-xs theme-muted">{{ $product->created_at->diffForHumans() }}</div>
                        </a>
                    @empty
                        <div class="text-sm theme-muted">لا توجد منتجات قيد الموافقة</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

