@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">تعديل تصنيف: {{ $category->name_ar }}</h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-sm">رجوع للقائمة</a>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="card bg-base-100 shadow">
        @csrf
        @method('PUT')
        <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Slug</label>
                <input name="slug" value="{{ old('slug', $category->slug) }}" class="input input-bordered w-full" required />
                @error('slug')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">الاسم (AR)</label>
                <input name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" class="input input-bordered w-full" required />
                @error('name_ar')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">الاسم (EN)</label>
                <input name="name_en" value="{{ old('name_en', $category->name_en) }}" class="input input-bordered w-full" />
                @error('name_en')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">الأب</label>
                <select name="parent_id" class="select select-bordered w-full">
                    <option value="">— بدون —</option>
                    @foreach($parents as $p)
                    <option value="{{ $p->id }}" @selected(old('parent_id', $category->parent_id)==$p->id)>{{ $p->name_ar }}</option>
                    @endforeach
                </select>
                @error('parent_id')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm text-gray-700 mb-1">رابط الصورة</label>
                <input name="image_url" value="{{ old('image_url', $category->image_url) }}" class="input input-bordered w-full" />
                <div class="text-xs text-gray-500 mt-1">رابط مباشر للصورة (URL) أو مسار داخل public/.</div>
                @error('image_url')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="px-6 pb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm text-gray-700 mb-2">صورة القسم (اختياري)</label>
                <label for="image_file" class="w-full border border-dashed rounded-lg p-4 text-center cursor-pointer hover:bg-base-200 transition">
                    <div class="text-sm">اسحب وأفلت أو انقر لاختيار صورة</div>
                </label>
                <input id="image_file" type="file" name="image_file" accept="image/*" class="hidden" />
                <div class="mt-3">
                    @php $imgUrl = method_exists($category,'getFirstMediaUrl') ? $category->getFirstMediaUrl('image') : null; @endphp
                    <img id="image_preview" src="{{ $imgUrl }}" alt="" class="{{ $imgUrl ? '' : 'hidden' }} w-24 h-24 object-cover rounded border" />
                </div>
                @error('image_file')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-actions justify-end p-6 pt-0">
            <button class="btn btn-primary">تحديث</button>
        </div>
    </form>
    <script>
      (function(){
        function bindDrop(forId){
          var lbl = document.querySelector('label[for="'+forId+'"]');
          var input = document.getElementById(forId);
          if(!lbl||!input) return;
          ['dragenter','dragover','dragleave','drop'].forEach(function(ev){
            lbl.addEventListener(ev, function(e){ e.preventDefault(); e.stopPropagation(); });
          });
          lbl.addEventListener('drop', function(e){
            var dt = new DataTransfer();
            Array.from(e.dataTransfer.files||[]).forEach(function(f){ dt.items.add(f); });
            input.files = dt.files; input.dispatchEvent(new Event('change'));
          });
        }
        var imgFile = document.getElementById('image_file');
        var imgPreview = document.getElementById('image_preview');
        imgFile && imgFile.addEventListener('change', function(){
          var f = this.files && this.files[0];
          if(!f) return;
          imgPreview.src = URL.createObjectURL(f);
          imgPreview.classList.remove('hidden');
        });
        bindDrop('image_file');
      })();
    </script>
</div>
@endsection
