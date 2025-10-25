@extends('layouts.admin')

@section('title', 'إدارة العلامات')

@section('content')
<div class="space-y-4">
  <div class="flex items-center justify-between">
    <div>
      <h2 class="text-xl font-bold">العلامات التجارية</h2>
      <p class="text-sm theme-muted">إدارة العلامات والتحقق والظهور في الواجهة</p>
    </div>
    <x-ui.btn variant="primary" size="sm" :href="route('admin.brands.create')">إضافة علامة</x-ui.btn>
  </div>

  <div class="flex items-center justify-between mb-2 gap-3">
    <form method="GET" action="{{ route('admin.brands.index') }}" class="flex items-center gap-2">
      <div class="relative">
        <input type="search" name="q" value="{{ $q }}" placeholder="ابحث عن علامة" class="input input-bordered w-64 pl-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <x-ui.btn type="submit" size="sm">بحث</x-ui.btn>
    </form>
  </div>

  <x-ui.table :headers="[
    ['label'=>'#'],
    ['label'=>'الشعار'],
    ['label'=>'الاسم'],
    ['label'=>'المعرّف'],
    ['label'=>'الحالة'],
    ['label'=>'موثّق؟'],
    ['label'=>'إجراءات']
  ]" zebra sticky>
    @forelse($brands as $brand)
    <tr>
      <td class="whitespace-nowrap">{{ $brand->id }}</td>
      <td class="whitespace-nowrap">
        @if($brand->logo_path)
          <img src="{{ asset($brand->logo_path) }}" alt="{{ $brand->name }}" class="w-9 h-9 rounded-lg object-cover bg-base-100 border border-base-300">
        @else
          <div class="w-9 h-9 rounded-lg bg-base-200 grid place-items-center text-xs">—</div>
        @endif
      </td>
      <td class="whitespace-nowrap font-semibold">{{ $brand->name }}</td>
      <td class="whitespace-nowrap text-base-content/70">{{ $brand->slug }}</td>
      <td class="whitespace-nowrap">
        @if($brand->status === 'approved')
          <span class="badge badge-success">معتمدة</span>
        @elseif($brand->status === 'rejected')
          <span class="badge badge-error">مرفوضة</span>
        @else
          <span class="badge badge-ghost">قيد المراجعة</span>
        @endif
      </td>
      <td class="whitespace-nowrap">
        @if($brand->verified_at)
          <span class="badge badge-secondary">نعم</span>
        @else
          <span class="badge badge-ghost">لا</span>
        @endif
      </td>
      <td class="whitespace-nowrap">
        <div class="flex items-center gap-2">
          <x-ui.btn variant="ghost" size="xs" :href="route('admin.brands.edit', $brand)">تعديل</x-ui.btn>
          <form method="POST" action="{{ route('admin.brands.approve', $brand) }}" class="inline">@csrf
            <x-ui.btn variant="ghost" size="xs" type="submit">اعتماد</x-ui.btn>
          </form>
          <form method="POST" action="{{ route('admin.brands.reject', $brand) }}" class="inline">@csrf
            <x-ui.btn variant="ghost" size="xs" type="submit">رفض</x-ui.btn>
          </form>
          <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" class="inline" onsubmit="return confirm('حذف نهائي؟');">
            @csrf @method('DELETE')
            <x-ui.btn variant="ghost" size="xs" type="submit">حذف</x-ui.btn>
          </form>
        </div>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="7" class="text-center py-8 theme-muted">لا توجد علامات حتى الآن</td>
    </tr>
    @endforelse
  </x-ui.table>

  <div>
    {{ $brands->links() }}
  </div>
</div>
@endsection
