@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">تعديل منتج: {{ $product->title_ar }}</h2>
        <x-ui.btn variant="ghost" size="sm" :href="route('admin.products.index')">رجوع للقائمة</x-ui.btn>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="card theme-surface theme-border">
        @csrf
        @method('PUT')
        <div class="card-body space-y-4">
            @include('admin.products.partials.form')
            @php $imgs = $product->images()->orderBy('sort_order')->get(); @endphp
            @if($imgs->isNotEmpty())
            <div class="space-y-2">
                <div class="text-sm font-semibold">الصور الحالية</div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach($imgs as $img)
                        <div class="relative">
                            <img src="{{ asset($img->url) }}" class="w-full h-28 object-cover rounded border" alt="" />
                            @if($loop->first && $img->sort_order === 0)
                                <span class="badge badge-success absolute top-1 right-1">أساسية</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="text-xs text-gray-500">يمكنك رفع صورة رئيسية جديدة وصور تفاصيل إضافية، وستظهر هنا مرتبة.</div>
            </div>
            @endif
            <div class="flex justify-end gap-2">
                <x-ui.btn variant="secondary" size="sm" :href="route('admin.products.index')">إلغاء</x-ui.btn>
                <x-ui.btn variant="primary" type="submit">تحديث</x-ui.btn>
            </div>
        </div>
    </form>
</div>
@endsection
