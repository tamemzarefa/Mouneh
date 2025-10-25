@extends('layouts.admin')

@section('title', 'إضافة علامة')

@section('content')
  <div class="container mx-auto p-4">
    <div class="card theme-surface theme-border shadow-md">
      <div class="card-body">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-bold">إضافة علامة جديدة</h3>
          <a href="{{ route('admin.brands.index') }}" class="btn btn-ghost">رجوع</a>
        </div>
        <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" class="grid gap-4">
          @csrf
          <div>
            <label class="label"><span class="label-text">الاسم</span></label>
            <input class="input input-bordered w-full" type="text" name="name" value="{{ old('name') }}" required>
            @error('name')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
          </div>
          <div>
            <label class="label"><span class="label-text">المعرّف (slug)</span></label>
            <input class="input input-bordered w-full" type="text" name="slug" value="{{ old('slug') }}" placeholder="اختياري">
            @error('slug')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
          </div>
          <div>
            <label class="label"><span class="label-text">الوصف</span></label>
            <textarea class="textarea textarea-bordered w-full" name="description" rows="4">{{ old('description') }}</textarea>
            @error('description')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="label"><span class="label-text">الشعار (Logo)</span></label>
              <input class="file-input file-input-bordered w-full" type="file" name="logo" accept="image/*">
              <div class="text-xs theme-muted mt-1">PNG/JPG/WEBP حتى 4MB</div>
              @error('logo')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
              <label class="label"><span class="label-text">صورة الغلاف (Cover)</span></label>
              <input class="file-input file-input-bordered w-full" type="file" name="cover" accept="image/*">
              <div class="text-xs theme-muted mt-1">PNG/JPG/WEBP حتى 6MB</div>
              @error('cover')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
            </div>
          </div>
          <div>
            <label class="label"><span class="label-text">الحالة</span></label>
            <select class="select select-bordered w-full" name="status">
              <option value="pending" @selected(old('status')==='pending')>قيد المراجعة</option>
              <option value="approved" @selected(old('status')==='approved')>معتمدة</option>
              <option value="rejected" @selected(old('status')==='rejected')>مرفوضة</option>
            </select>
          </div>
          <div class="flex items-center gap-2 justify-end pt-2">
            <a href="{{ route('admin.brands.index') }}" class="btn btn-ghost">إلغاء</a>
            <button type="submit" class="btn btn-primary">حفظ</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
