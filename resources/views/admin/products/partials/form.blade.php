<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm text-gray-700 mb-1">العنوان (AR)</label>
        <input name="title_ar" value="{{ old('title_ar', $product->title_ar ?? '') }}" class="input input-bordered w-full" required />
        @error('title_ar')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">العنوان (EN)</label>
        <input name="title_en" value="{{ old('title_en', $product->title_en ?? '') }}" class="input input-bordered w-full" />
        @error('title_en')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm text-gray-700 mb-1">الوصف (AR)</label>
        <textarea name="description_ar" class="textarea textarea-bordered w-full" rows="3">{{ old('description_ar', $product->description_ar ?? '') }}</textarea>
        @error('description_ar')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm text-gray-700 mb-1">الوصف (EN)</label>
        <textarea name="description_en" class="textarea textarea-bordered w-full" rows="3">{{ old('description_en', $product->description_en ?? '') }}</textarea>
        @error('description_en')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">السعر (بالسنت)</label>
        <input type="number" name="price_cents" value="{{ old('price_cents', $product->price_cents ?? '') }}" class="input input-bordered w-full" min="0" required />
        @error('price_cents')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">العملة</label>
        <input name="currency" value="{{ old('currency', $product->currency ?? 'SYP') }}" class="input input-bordered w-full" maxlength="3" />
        @error('currency')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">المخزون</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" class="input input-bordered w-full" min="0" />
        @error('stock')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">الحالة</label>
        <select name="is_active" class="select select-bordered w-full">
            <option value="1" @selected(old('is_active', ($product->is_active ?? true)) == true)>نشط</option>
            <option value="0" @selected(old('is_active', ($product->is_active ?? true)) == false)>معطل</option>
        </select>
        @error('is_active')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">التصنيف</label>
        <select name="category_id" class="select select-bordered w-full" required>
            <option value="">— اختر —</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '')==$cat->id)>{{ $cat->name_ar }}</option>
            @endforeach
        </select>
        @error('category_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-700 mb-1">البائع</label>
        <select name="seller_id" class="select select-bordered w-full" required>
            <option value="">— اختر —</option>
            @foreach($sellers as $seller)
            <option value="{{ $seller->id }}" @selected(old('seller_id', $product->seller_id ?? '')==$seller->id)>{{ $seller->name }}</option>
            @endforeach
        </select>
        @error('seller_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-gray-700 mb-1">الصورة الرئيسية</label>
            <label for="primary_image" class="w-full border-dashed border rounded-lg p-4 text-center cursor-pointer hover:bg-gray-50 transition">
                <div class="text-sm text-gray-600">اسحب وأفلت أو انقر للاختيار</div>
                <div class="text-xs text-gray-500">(jpg, jpeg, png, webp • حتى 4MB)</div>
            </label>
            <input id="primary_image" type="file" name="primary_image" accept="image/*" class="hidden" />
            <div class="mt-3">
                <img id="primary_preview" src="" alt="" class="hidden w-28 h-28 object-cover rounded border" />
            </div>
            <div class="text-xs text-gray-500 mt-1">ستكون الصورة الأساسية للمنتج.</div>
            @error('primary_image')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm text-gray-700 mb-1">صور التفاصيل (متعددة)</label>
            <label for="gallery_images" class="w-full border-dashed border rounded-lg p-4 text-center cursor-pointer hover:bg-gray-50 transition">
                <div class="text-sm text-gray-600">اسحب وأفلت أو انقر لاختيار عدة صور</div>
            </label>
            <input id="gallery_images" type="file" name="gallery_images[]" accept="image/*" multiple class="hidden" />
            <div id="gallery_preview" class="mt-3 grid grid-cols-3 md:grid-cols-4 gap-2"></div>
            <div class="text-xs text-gray-500 mt-1">أضف صوراً إضافية للتفاصيل. سيتم ترتيبها بعد الرئيسية.</div>
            @error('gallery_images.*')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<script>
  (function(){
    function previewPrimary(file){
      var img = document.getElementById('primary_preview');
      if (!img) return;
      if (file) {
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
      }
    }
    function previewGallery(files){
      var wrap = document.getElementById('gallery_preview');
      if (!wrap) return;
      wrap.innerHTML = '';
      Array.from(files || []).forEach(function(f){
        var url = URL.createObjectURL(f);
        var el = document.createElement('img');
        el.src = url;
        el.className = 'w-20 h-20 object-cover rounded border';
        wrap.appendChild(el);
      });
    }
    function bindInput(id, onChange){
      var input = document.getElementById(id);
      if (!input) return;
      input.addEventListener('change', function(e){ onChange(e.target.files); });
    }
    function bindDrop(labelForId, multiple){
      var lbl = document.querySelector('label[for="'+labelForId+'"]');
      var input = document.getElementById(labelForId);
      if (!lbl || !input) return;
      ['dragenter','dragover','dragleave','drop'].forEach(function(ev){
        lbl.addEventListener(ev, function(e){ e.preventDefault(); e.stopPropagation(); });
      });
      lbl.addEventListener('drop', function(e){
        var dt = new DataTransfer();
        var files = e.dataTransfer.files;
        Array.from(files).forEach(function(f){ dt.items.add(f); });
        input.files = dt.files;
        input.dispatchEvent(new Event('change'));
      });
    }
    bindInput('primary_image', function(files){ previewPrimary(files && files[0]); });
    bindInput('gallery_images', function(files){ previewGallery(files); });
    bindDrop('primary_image', false);
    bindDrop('gallery_images', true);
  })();
</script>
