@extends('layouts.frontend')

@section('title', 'إضافة منتج')

@section('content')
  <style>
    /* Scoped styles for product create form */
    #product-create-form { gap: 14px; }
    #product-create-form label { color: #374151; font-weight: 600; }
    #product-create-form .form-control {
      width: 100%;
      border: 1px solid #e8dedd;
      border-radius: 12px;
      padding: 12px 14px;
      background: #fff;
      color: #111827;
      transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    }
    #product-create-form .form-control:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
      background: #ffffff;
      outline: none;
    }
    #product-create-form textarea.form-control { min-height: 120px; resize: vertical; }
    #product-create-form .hint { color:#6b7280; font-size:12px; margin-top:4px; }
  </style>
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>إضافة منتج</b>
        <span>سيتم مراجعته من قبل الإدارة</span>
      </div>
    </div>
  </header>

  <main class="content">
    <section class="section">
      <form id="product-create-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" style="background:#fff;border:1px solid #f0e6e5;border-radius:14px;padding:14px;display:grid;gap:10px;">
        @csrf
        <div>
          <label style="display:block;font-size:13px;margin-bottom:6px;">العنوان (AR)</label>
          <input class="form-control" type="text" name="title_ar" value="{{ old('title_ar') }}" required style="width:100%;border:1px solid #e8dedd;border-radius:12px;padding:10px;">
          @error('title_ar')<div style="color:#b00020;font-size:12px;">{{ $message }}</div>@enderror
        </div>
        
        <div>
          <label style="display:block;font-size:13px;margin-bottom:6px;">التصنيف</label>
          <select class="form-control" name="category_id" required style="width:100%;border:1px solid #e8dedd;border-radius:12px;padding:10px;">
            <option value="">اختر تصنيفاً</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name_ar }}</option>
            @endforeach
          </select>
          @error('category_id')<div style="color:#b00020;font-size:12px;">{{ $message }}</div>@enderror
        </div>
        <div>
          <label style="display:block;font-size:13px;margin-bottom:6px;">الوصف (AR)</label>
          <textarea class="form-control" name="description_ar" rows="4" style="width:100%;border:1px solid #e8dedd;border-radius:12px;padding:10px;">{{ old('description_ar') }}</textarea>
          @error('description_ar')<div style="color:#b00020;font-size:12px;">{{ $message }}</div>@enderror
        </div>
        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;align-items:end;">
          <div>
            <label style="display:block;font-size:13px;margin-bottom:6px;">السعر</label>
            <input class="form-control" type="number" name="price_cents" value="{{ old('price_cents') }}" min="0" required style="width:100%;border:1px solid #e8dedd;border-radius:12px;padding:10px;">
            @error('price_cents')<div style="color:#b00020;font-size:12px;">{{ $message }}</div>@enderror
          </div>
          <div>
            <label style="display:block;font-size:13px;margin-bottom:6px;">العملة</label>
            <input type="hidden" name="currency" value="{{ old('currency','SYP') }}">
            <div style="width:100%;border:1px solid #e8dedd;border-radius:12px;padding:10px;background:#f9fafb;color:#111827;display:flex;align-items:center;justify-content:space-between;">
              <span>الليرة السورية</span>
              <span style="font-size:12px;color:#6b7280;">SYP</span>
            </div>
            @error('currency')<div style="color:#b00020;font-size:12px;">{{ $message }}</div>@enderror
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr;gap:10px;">
          <div>
            <label style="display:block;font-size:13px;margin-bottom:6px;">المخزون</label>
            <input class="form-control" type="number" name="stock" value="{{ old('stock',0) }}" min="0" style="width:100%;border:1px solid #e8dedd;border-radius:12px;padding:10px;">
            @error('stock')<div style="color:#b00020;font-size:12px;">{{ $message }}</div>@enderror
          </div>
        </div>
        <div>
          <label style="display:block;font-size:13px;margin-bottom:6px;font-weight:500;">الصورة الرئيسية</label>
          <div style="position:relative;border:2px dashed #d1d5db;border-radius:12px;padding:20px;text-align:center;background:#f9fafb;transition:all 0.3s ease;" 
               onmouseover="this.style.borderColor='#3b82f6';this.style.backgroundColor='#eff6ff';" 
               onmouseout="this.style.borderColor='#d1d5db';this.style.backgroundColor='#f9fafb';">
            <input type="file" name="primary_image" accept="image/*" id="primary_image" 
                   style="position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;cursor:pointer;" 
                   onchange="previewPrimaryImage(this)">
            <div id="primary_preview" style="display:none;">
              <img id="primary_img" style="max-width:200px;max-height:150px;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
              <div style="margin-top:10px;">
                <button type="button" onclick="clearPrimaryImage()" style="background:#ef4444;color:white;border:none;padding:6px 12px;border-radius:6px;font-size:12px;cursor:pointer;">إزالة الصورة</button>
              </div>
            </div>
            <div id="primary_placeholder">
              <svg style="width:48px;height:48px;margin:0 auto 12px;color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <p style="margin:0;color:#6b7280;font-size:14px;">اضغط لرفع الصورة الرئيسية</p>
              <p style="margin:4px 0 0;color:#9ca3af;font-size:12px;">JPG, PNG, WEBP حتى 4MB</p>
            </div>
          </div>
          @error('primary_image')<div style="color:#b00020;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
        </div>
        
        <div>
          <label style="display:block;font-size:13px;margin-bottom:6px;font-weight:500;">صور المعرض</label>
          <div style="position:relative;border:2px dashed #d1d5db;border-radius:12px;padding:20px;text-align:center;background:#f9fafb;transition:all 0.3s ease;" 
               onmouseover="this.style.borderColor='#3b82f6';this.style.backgroundColor='#eff6ff';" 
               onmouseout="this.style.borderColor='#d1d5db';this.style.backgroundColor='#f9fafb';">
            <input type="file" name="gallery_images[]" accept="image/*" id="gallery_images" multiple 
                   style="position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;cursor:pointer;" 
                   onchange="previewGalleryImages(this)">
            <div id="gallery_preview" style="display:none;">
              <div id="gallery_images_container" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(120px, 1fr));gap:12px;margin-bottom:12px;"></div>
              <button type="button" onclick="clearGalleryImages()" style="background:#ef4444;color:white;border:none;padding:6px 12px;border-radius:6px;font-size:12px;cursor:pointer;">إزالة جميع الصور</button>
            </div>
            <div id="gallery_placeholder">
              <svg style="width:48px;height:48px;margin:0 auto 12px;color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <p style="margin:0;color:#6b7280;font-size:14px;">اضغط لرفع صور المعرض</p>
              <p style="margin:4px 0 0;color:#9ca3af;font-size:12px;">يمكنك رفع عدة صور معاً</p>
            </div>
          </div>
          @error('gallery_images.*')<div style="color:#b00020;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
        </div>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
          <a href="{{ route('account.index') }}" class="chip">إلغاء</a>
          <button type="submit" class="btn">حفظ وإرسال للمراجعة</button>
        </div>
      </form>
    </section>
  </main>
@endsection

@push('scripts')
<script>
function previewPrimaryImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('primary_img').src = e.target.result;
      document.getElementById('primary_preview').style.display = 'block';
      document.getElementById('primary_placeholder').style.display = 'none';
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function clearPrimaryImage() {
  document.getElementById('primary_image').value = '';
  document.getElementById('primary_preview').style.display = 'none';
  document.getElementById('primary_placeholder').style.display = 'block';
}

function previewGalleryImages(input) {
  const container = document.getElementById('gallery_images_container');
  container.innerHTML = '';
  
  if (input.files && input.files.length > 0) {
    document.getElementById('gallery_preview').style.display = 'block';
    document.getElementById('gallery_placeholder').style.display = 'none';
    
    Array.from(input.files).forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = function(e) {
        const imageDiv = document.createElement('div');
        imageDiv.style.position = 'relative';
        imageDiv.innerHTML = `
          <img src="${e.target.result}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1);">
          <button type="button" onclick="removeGalleryImage(${index})" style="position:absolute;top:4px;right:4px;background:rgba(239,68,68,0.9);color:white;border:none;border-radius:50%;width:20px;height:20px;font-size:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;">×</button>
        `;
        container.appendChild(imageDiv);
      }
      reader.readAsDataURL(file);
    });
  }
}

function removeGalleryImage(index) {
  const input = document.getElementById('gallery_images');
  const dt = new DataTransfer();
  
  Array.from(input.files).forEach((file, i) => {
    if (i !== index) {
      dt.items.add(file);
    }
  });
  
  input.files = dt.files;
  previewGalleryImages(input);
}

function clearGalleryImages() {
  document.getElementById('gallery_images').value = '';
  document.getElementById('gallery_preview').style.display = 'none';
  document.getElementById('gallery_placeholder').style.display = 'block';
}
</script>
@endpush
