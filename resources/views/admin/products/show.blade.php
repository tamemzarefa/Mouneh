@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">تفاصيل المنتج</h2>
        <div class="flex items-center gap-2">
            <x-ui.btn variant="ghost" size="sm" :href="route('admin.products.index')">الرجوع</x-ui.btn>
            <x-ui.btn variant="primary" size="sm" :href="route('admin.products.edit', $product)">تعديل</x-ui.btn>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 space-y-4">
            <div class="card bg-base-100 border theme-border">
                <div class="card-body">
                    <div class="flex items-start gap-4">
                        @php
                            $thumb = method_exists($product, 'getFirstMediaUrl')
                                ? ($product->getFirstMediaUrl('primary', 'thumb') ?: $product->getFirstMediaUrl('gallery', 'thumb'))
                                : null;
                            if (!$thumb) {
                                $primaryOld = optional($product->images)->sortBy('sort_order')->first();
                                $thumb = $primaryOld ? asset($primaryOld->url) : null;
                            }
                        @endphp
                        <div class="w-28 h-28 rounded overflow-hidden border">
                            @if($thumb)
                                <img src="{{ $thumb }}" alt="" class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center theme-muted text-sm">لا صورة</div>
                            @endif
                        </div>
                        <div class="flex-1 space-y-2">
                            <div class="text-lg font-bold">{{ $product->title_ar }}</div>
                            @if($product->title_en)
                                <div class="text-sm theme-muted">{{ $product->title_en }}</div>
                            @endif
                            <div class="flex flex-wrap items-center gap-2 text-sm">
                                <span class="badge">رقم: {{ $product->id }}</span>
                                @php($status = $product->status ?? null)
                                @if($status === 'approved')
                                    <span class="badge badge-success">مقبول</span>
                                @elseif($status === 'pending')
                                    <span class="badge">قيد المراجعة</span>
                                @elseif($status === 'rejected')
                                    <span class="badge" style="background:#fde2e2;color:#8a1c1c;">مرفوض</span>
                                @else
                                    <span class="badge">-</span>
                                @endif
                                @if(!$product->is_active)
                                    <span class="badge" title="الحالة: معطل">معطل</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 border theme-border">
                <div class="card-body space-y-3">
                    <div>
                        <div class="font-semibold mb-1">الوصف (عربي)</div>
                        <div class="prose max-w-none" dir="rtl">{!! nl2br(e($product->description_ar)) !!}</div>
                    </div>
                    @if($product->description_en)
                    <div>
                        <div class="font-semibold mb-1">الوصف (إنجليزي)</div>
                        <div class="prose max-w-none" dir="ltr">{!! nl2br(e($product->description_en)) !!}</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card bg-base-100 border theme-border">
                <div class="card-body">
                    <div class="font-semibold mb-3">المعرض</div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @php
                            $gallery = [];
                            if (method_exists($product, 'getMedia')) {
                                $gallery = $product->getMedia('gallery');
                            }
                        @endphp
                        @forelse($gallery as $media)
                            <a href="{{ $media->getUrl() }}" target="_blank" class="block border rounded overflow-hidden">
                                <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}" class="w-full h-32 object-cover" alt="" />
                            </a>
                        @empty
                            <div class="col-span-full theme-muted">لا توجد صور إضافية</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="card bg-base-100 border theme-border">
                <div class="card-body space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="theme-muted">السعر</div>
                        <div class="font-semibold tabular-nums">{{ number_format($product->price_cents/100, 2) }} {{ $product->currency }}</div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="theme-muted">المخزون</div>
                        <div class="font-semibold">{{ $product->stock ?? 0 }}</div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="theme-muted">التصنيف</div>
                        <div class="font-semibold">{{ optional($product->category)->name_ar ?: '-' }}</div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="theme-muted">البائع</div>
                        <div class="font-semibold">{{ optional($product->seller)->name ?: '-' }}</div>
                    </div>
                </div>
            </div>

            @if($product->rejection_reason)
            <div class="card bg-base-100 border theme-border">
                <div class="card-body">
                    <div class="font-semibold mb-1">سبب الرفض</div>
                    <div class="text-sm">{{ $product->rejection_reason }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
