@extends('layouts.frontend')

@section('title', 'طلب تسجيل علامة')

@section('content')
<style>
/* PWA Specific Fixes */
.content {
  max-width: none !important;
  width: 100% !important;
  padding: 0 !important;
  margin: 0 !important;
}

.card {
  width: 100% !important;
  max-width: none !important;
  margin: 0 !important;
  padding: 0 !important;
}

.card .body {
  padding: 1.5rem !important;
  margin: 0 !important;
}

/* Fix overlapping fields in PWA */
.grid {
  display: grid !important;
  gap: 1.5rem !important;
}

.grid > * {
  margin: 0 !important;
  padding: 0 !important;
}

.space-y-2 > * + * {
  margin-top: 0.5rem !important;
}

.space-y-4 > * + * {
  margin-top: 1rem !important;
}

.space-y-6 > * + * {
  margin-top: 1.5rem !important;
}

/* Input field fixes */
.input, .textarea, .select, .file-input {
  width: 100% !important;
  margin: 0 !important;
  padding: 0.75rem !important;
  border: 1px solid #d1d5db !important;
  border-radius: 0.5rem !important;
  background: white !important;
  box-sizing: border-box !important;
}

/* Label fixes */
.label {
  display: block !important;
  margin-bottom: 0.5rem !important;
  width: 100% !important;
}

/* Button fixes */
.btn {
  padding: 0.75rem 1.5rem !important;
  margin: 0 !important;
  border-radius: 0.5rem !important;
  display: inline-block !important;
}

/* Mobile PWA specific */
@media (max-width: 768px) {
  .grid-cols-1 {
    grid-template-columns: 1fr !important;
  }
  
  .lg\\:grid-cols-2 {
    grid-template-columns: 1fr !important;
  }
  
  .xl\\:grid-cols-3 {
    grid-template-columns: 1fr !important;
  }
  
  .card .body {
    padding: 1rem !important;
  }
  
  .grid {
    gap: 1rem !important;
  }
}

/* Prevent viewport issues */
html, body {
  overflow-x: hidden !important;
  width: 100% !important;
  max-width: 100% !important;
}

/* Fix any z-index issues */
.card {
  position: relative !important;
  z-index: 1 !important;
}

/* Banner fixes */
.banner {
  display: flex !important;
  flex-direction: column !important;
  gap: 1rem !important;
}

.banner .flex {
  display: flex !important;
  align-items: center !important;
}

.banner h3 {
  margin: 0 !important;
  line-height: 1.2 !important;
}

.banner p {
  margin: 0 !important;
  line-height: 1.4 !important;
}

/* Enhanced Date Picker Styles */
#established-date {
  cursor: pointer !important;
  transition: all 0.2s ease !important;
}

#established-date:hover {
  border-color: var(--primary) !important;
  background-color: #fef7f7 !important;
}

#established-date:focus {
  outline: none !important;
  border-color: var(--primary) !important;
  box-shadow: 0 0 0 3px rgba(126, 45, 43, 0.1) !important;
}

/* Calendar icon styling */
.date-icon {
  transition: color 0.2s ease;
}

#established-date:hover + .date-icon {
  color: var(--primary) !important;
}

/* Mobile date picker improvements */
@media (max-width: 768px) {
  #established-date {
    font-size: 16px !important; /* Prevents zoom on iOS */
  }
  
  input[type="date"]::-webkit-calendar-picker-indicator {
    opacity: 0.7;
    cursor: pointer;
  }
  
  input[type="date"]::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
  }
}

.sticky-submit-bar {
  position: fixed !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  z-index: 50 !important;
  background: #ffffff !important;
  border-top: 1px solid #e5d9d8 !important;
  padding: 0.75rem 1rem !important;
  display: flex !important;
  justify-content: center !important;
  backdrop-filter: saturate(180%) blur(10px);
}
.sticky-submit-bar .btn {
  width: 100% !important;
  max-width: 640px !important;
}
.content.has-sticky-submit {
  padding-bottom: 84px !important;
}
</style>
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>طلب تسجيل علامة</b>
        <span>املأ البيانات التالية لطلب اعتماد علامتك</span>
      </div>
    </div>
    <div class="header-actions">
      <a class="account-btn {{ request()->is('account*') ? 'active' : '' }}" href="{{ url('/account') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg">
          <circle cx="12" cy="8" r="3.2"/>
          <path d="M4.5 20c1.8-3.8 5.3-5.3 7.5-5.3S17.7 16.2 19.5 20"/>
        </svg>
        <span>حسابي</span>
      </a>
    </div>
  </header>

  <main class="content has-sticky-submit w-full max-w-none px-4">
    <div class="banner w-full mb-6">
      <div class="flex items-center gap-4 mb-4">
        <div class="flex-shrink-0">
          <svg class="w-8 h-8 text-[var(--primary)]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
          </svg>
        </div>
        <div class="flex-1">
          <h3 class="text-lg font-bold text-[#3a2a2a] mb-1">إكمال الطلب</h3>
          <p class="text-sm text-[#6b7280] m-0">أكمل الحقول عبر 3 خطوات. سنحفظ تقدمك مؤقتاً تلقائياً.</p>
        </div>
      </div>
      <div class="w-full">
        <div class="h-2 rounded-full bg-[#f1e7e6] overflow-hidden">
          <div id="progress-bar" class="h-2 w-1/3" style="background:var(--primary);transition:width .25s ease"></div>
        </div>
        <div id="progress-text" class="text-xs text-[#6b7280] mt-2">33%</div>
      </div>
    </div>
    <div class="flex justify-center mt-4 w-full">
      <div class="flex items-center gap-2 bg-white rounded-full p-1 shadow-sm border border-[#e5d9d8]">
        <button type="button" class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-200 active bg-[var(--primary)] text-white" data-tab-btn="1">
          <span class="flex items-center gap-2">
            <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs">1</span>
            بيانات العلامة
          </span>
        </button>
        <button type="button" class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-200 text-[#6b7280] hover:text-[#3a2a2a]" data-tab-btn="2">
          <span class="flex items-center gap-2">
            <span class="w-6 h-6 rounded-full bg-[#f1e7e6] flex items-center justify-center text-xs">2</span>
            المعلومات القانونية
          </span>
        </button>
        <button type="button" class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-200 text-[#6b7280] hover:text-[#3a2a2a]" data-tab-btn="3">
          <span class="flex items-center gap-2">
            <span class="w-6 h-6 rounded-full bg-[#f1e7e6] flex items-center justify-center text-xs">3</span>
            التواصل والمستندات
          </span>
        </button>
      </div>
    </div>

    <form method="POST" action="{{ route('brand.request.store') }}" enctype="multipart/form-data" class="w-full" id="brand-request-form">
      @csrf
      <!-- Tab 1: بيانات العلامة -->
      <div class="card w-full" data-tab="1">
        <div class="body p-6 w-full">
          <!-- Tab Header -->
          <div class="mb-6">
            <h4 class="m-0 font-extrabold text-[#3a2a2a] mb-2">بيانات العلامة</h4>
            <p class="m-0 text-sm text-[#6b7280]">أدخل الاسم العام الذي سيظهر للمشترين، ويمكنك تحديد معرف (slug) مخصص للرابط.</p>
          </div>
          
          <!-- Form Fields -->
          <div class="space-y-6">
            <!-- Basic Information -->
            <div class="space-y-4">
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">اسم العلامة <span class="text-error">*</span></span></label>
                <input class="input input-bordered w-full" id="brand-name" name="name" value="{{ old('name') }}" placeholder="مثال: مؤونة السويداء" required>
                @error('name')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
                <div class="text-error text-sm mt-1 hidden" id="brand-name-error">الرجاء إدخال اسم العلامة</div>
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">المعرّف (slug) - اختياري</span></label>
                <input class="input input-bordered w-full" name="slug" value="{{ old('slug') }}" placeholder="مثال: mouneh-sweida">
                @error('slug')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">الوصف</span></label>
                <textarea class="textarea textarea-bordered w-full" name="description" rows="4" placeholder="عرّف بمجموعتك ومنتجاتك وتميّزك">{{ old('description') }}</textarea>
                @error('description')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
            </div>

            <!-- Media Upload -->
            <div class="space-y-6">
              <!-- Logo Upload -->
              <div class="space-y-3">
                <label class="label"><span class="label-text font-semibold text-[#3a2a2a]">الشعار (Logo)</span></label>
                <div class="relative">
                  <div id="logo-dropzone" class="border-2 border-dashed border-[#d1d5db] rounded-xl p-8 text-center transition-all duration-200 hover:border-[var(--primary)] hover:bg-[#fef7f7] cursor-pointer group">
                    <div class="flex flex-col items-center space-y-3">
                      <div class="w-12 h-12 rounded-full bg-[#f3f4f6] flex items-center justify-center group-hover:bg-[var(--primary)]/10 transition-colors duration-200">
                        <svg class="w-6 h-6 text-[#6b7280] group-hover:text-[var(--primary)] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-[#374151] mb-1">اسحب وأفلت الصورة هنا</p>
                        <p class="text-xs text-[#6b7280]">أو <span class="text-[var(--primary)] font-medium">انقر للاختيار</span></p>
                      </div>
                    </div>
                    <input class="file-input hidden" type="file" name="logo" id="logo-input" accept="image/*">
                  </div>
                  <div id="logo-preview" class="mt-4 hidden">
                    <div class="relative inline-block">
                      <img alt="logo preview" class="w-20 h-20 rounded-xl object-cover border-2 border-[#e5d9d8] bg-white shadow-sm" />
                      <button type="button" id="logo-remove" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                        ×
                      </button>
                    </div>
                  </div>
                </div>
                <div class="text-xs text-[#6b7280]">PNG/JPG/WEBP حتى 4MB • مقترح: 200×200 بكسل</div>
                @error('logo')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>

              <!-- Cover Upload -->
              <div class="space-y-3">
                <label class="label"><span class="label-text font-semibold text-[#3a2a2a]">صورة الغلاف (Cover)</span></label>
                <div class="relative">
                  <div id="cover-dropzone" class="border-2 border-dashed border-[#d1d5db] rounded-xl p-8 text-center transition-all duration-200 hover:border-[var(--primary)] hover:bg-[#fef7f7] cursor-pointer group">
                    <div class="flex flex-col items-center space-y-3">
                      <div class="w-12 h-12 rounded-full bg-[#f3f4f6] flex items-center justify-center group-hover:bg-[var(--primary)]/10 transition-colors duration-200">
                        <svg class="w-6 h-6 text-[#6b7280] group-hover:text-[var(--primary)] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-[#374151] mb-1">اسحب وأفلت الصورة هنا</p>
                        <p class="text-xs text-[#6b7280]">أو <span class="text-[var(--primary)] font-medium">انقر للاختيار</span></p>
                      </div>
                    </div>
                    <input class="file-input hidden" type="file" name="cover" id="cover-input" accept="image/*">
                  </div>
                  <div id="cover-preview" class="mt-4 hidden">
                    <div class="relative inline-block">
                      <img alt="cover preview" class="w-full max-w-[400px] h-24 rounded-xl object-cover border-2 border-[#e5d9d8] bg-white shadow-sm" />
                      <button type="button" id="cover-remove" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                        ×
                      </button>
                    </div>
                  </div>
                </div>
                <div class="text-xs text-[#6b7280]">PNG/JPG/WEBP حتى 6MB • مقترح: 1200×400 بكسل</div>
                @error('cover')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>

          <!-- Navigation -->
          <div class="flex items-center justify-end gap-2 pt-6 mt-6 border-t border-[#e5d9d8]">
            <button type="button" class="btn btn-primary" data-next="2">التالي</button>
          </div>
        </div>
      </div>

      <!-- Tab 2: معلومات قانونية -->
      <div class="card w-full hidden" data-tab="2">
        <div class="body p-6 w-full">
          <!-- Tab Header -->
          <div class="mb-6">
            <h4 class="m-0 font-extrabold text-[#3a2a2a] mb-2">المعلومات القانونية</h4>
            <p class="m-0 text-sm text-[#6b7280]">هذه البيانات تساعدنا على التحقق من الكيان القانوني وحماية المشترين.</p>
          </div>
          
          <!-- Form Fields -->
          <div class="space-y-6">
            <!-- Entity Information -->
            <div class="space-y-4">
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">الاسم القانوني</span></label>
                <input class="input input-bordered w-full" name="legal_name" value="{{ old('legal_name') }}" placeholder="مثال: شركة مؤونة السويداء المحدودة">
                @error('legal_name')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">نوع الكيان</span></label>
                <select class="select select-bordered w-full" name="entity_type">
                  <option value="">— اختر —</option>
                  <option value="company" @selected(old('entity_type')==='company')>شركة</option>
                  <option value="establishment" @selected(old('entity_type')==='establishment')>مؤسسة</option>
                  <option value="sole" @selected(old('entity_type')==='sole')>ملكية فردية</option>
                </select>
                @error('entity_type')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">رقم السجل التجاري</span></label>
                <input class="input input-bordered w-full" name="registration_number" value="{{ old('registration_number') }}" placeholder="مثال: 1234567890">
                @error('registration_number')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">الرقم الضريبي</span></label>
                <input class="input input-bordered w-full" name="tax_number" value="{{ old('tax_number') }}" placeholder="مثال: SY-987654321">
                @error('tax_number')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
            </div>

            <!-- Location Information -->
            <div class="space-y-4">
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">الدولة</span></label>
                <input class="input input-bordered w-full" name="country" value="{{ old('country') }}" placeholder="مثال: سوريا">
                @error('country')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">المدينة</span></label>
                <input class="input input-bordered w-full" name="city" value="{{ old('city') }}" placeholder="مثال: السويداء">
                @error('city')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">تاريخ التأسيس</span></label>
                <div class="relative">
                  <input class="input input-bordered w-full pr-10" type="date" name="established_at" value="{{ old('established_at') }}" id="established-date" min="1900-01-01" max="{{ date('Y-m-d') }}">
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
                <div class="text-xs text-gray-500">اختر تاريخ تأسيس الشركة أو المؤسسة</div>
                @error('established_at')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>

          <!-- Navigation -->
          <div class="flex items-center justify-between gap-2 pt-6 mt-6 border-t border-[#e5d9d8]">
            <button type="button" class="btn btn-outline" data-prev="1">السابق</button>
            <button type="button" class="btn btn-primary" data-next="3">التالي</button>
          </div>
        </div>
      </div>

      <!-- Tab 3: تواصل وسياسات + مستندات -->
      <div class="card w-full hidden" data-tab="3">
        <div class="body p-6 w-full">
          <!-- Tab Header -->
          <div class="mb-6">
            <h4 class="m-0 font-extrabold text-[#3a2a2a] mb-2">التواصل والمستندات</h4>
            <p class="m-0 text-sm text-[#6b7280]">معلومات الاتصال المعروضة للمشترين وسياسات المتجر والمستندات المطلوبة للتحقق.</p>
          </div>
          
          <!-- Form Fields -->
          <div class="space-y-6">
            <!-- Contact Information -->
            <div class="space-y-4">
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">البريد للدعم</span></label>
                <input class="input input-bordered w-full" type="email" name="support_email" value="{{ old('support_email') }}" placeholder="example@brand.com">
                @error('support_email')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">هاتف الدعم</span></label>
                <input class="input input-bordered w-full" name="support_phone" value="{{ old('support_phone') }}" placeholder="09XXXXXXXX">
                @error('support_phone')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">العنوان</span></label>
                <input class="input input-bordered w-full" name="address" value="{{ old('address') }}" placeholder="المدينة، الحي، الشارع، رقم المبنى">
                @error('address')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
            </div>

            <!-- Policies -->
            <div class="space-y-4">
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">سياسة الشحن</span></label>
                <textarea class="textarea textarea-bordered w-full" name="shipping_policy" rows="4" placeholder="مدة التحضير، شركات الشحن، التغطية...">{{ old('shipping_policy') }}</textarea>
                @error('shipping_policy')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">سياسة الإرجاع</span></label>
                <textarea class="textarea textarea-bordered w-full" name="return_policy" rows="4" placeholder="المدة، الشروط، من يتحمل الشحن...">{{ old('return_policy') }}</textarea>
                @error('return_policy')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
              <div class="space-y-2">
                <label class="label"><span class="label-text font-medium">سياسة الضمان</span></label>
                <textarea class="textarea textarea-bordered w-full" name="warranty_policy" rows="4" placeholder="نطاق الضمان وطريقة الطلب...">{{ old('warranty_policy') }}</textarea>
                @error('warranty_policy')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
            </div>

            <!-- Documents -->
            <div class="space-y-6">
              <!-- Commercial Registration -->
              <div class="space-y-3">
                <label class="label"><span class="label-text font-semibold text-[#3a2a2a]">السجل التجاري</span></label>
                <div class="relative">
                  <div id="registration-dropzone" class="border-2 border-dashed border-[#d1d5db] rounded-xl p-6 text-center transition-all duration-200 hover:border-[var(--primary)] hover:bg-[#fef7f7] cursor-pointer group">
                    <div class="flex flex-col items-center space-y-2">
                      <div class="w-10 h-10 rounded-full bg-[#f3f4f6] flex items-center justify-center group-hover:bg-[var(--primary)]/10 transition-colors duration-200">
                        <svg class="w-5 h-5 text-[#6b7280] group-hover:text-[var(--primary)] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-[#374151]">اسحب الملف هنا</p>
                        <p class="text-xs text-[#6b7280]">أو <span class="text-[var(--primary)] font-medium">انقر للاختيار</span></p>
                      </div>
                    </div>
                    <input class="file-input hidden" type="file" name="registration_doc" id="registration-input" accept="application/pdf,image/*">
                  </div>
                  <div id="registration-preview" class="mt-3 hidden">
                    <div class="flex items-center justify-between p-3 bg-[#f9fafb] rounded-lg border border-[#e5d9d8]">
                      <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                          <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                          </svg>
                        </div>
                        <span class="text-sm font-medium text-[#374151]" id="registration-filename">ملف مرفوع</span>
                      </div>
                      <button type="button" id="registration-remove" class="w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                        ×
                      </button>
                    </div>
                  </div>
                </div>
                <div class="text-xs text-[#6b7280]">PDF/صور حتى 8MB</div>
                @error('registration_doc')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>

              <!-- Tax Document -->
              <div class="space-y-3">
                <label class="label"><span class="label-text font-semibold text-[#3a2a2a]">البطاقة الضريبية</span></label>
                <div class="relative">
                  <div id="tax-dropzone" class="border-2 border-dashed border-[#d1d5db] rounded-xl p-6 text-center transition-all duration-200 hover:border-[var(--primary)] hover:bg-[#fef7f7] cursor-pointer group">
                    <div class="flex flex-col items-center space-y-2">
                      <div class="w-10 h-10 rounded-full bg-[#f3f4f6] flex items-center justify-center group-hover:bg-[var(--primary)]/10 transition-colors duration-200">
                        <svg class="w-5 h-5 text-[#6b7280] group-hover:text-[var(--primary)] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-[#374151]">اسحب الملف هنا</p>
                        <p class="text-xs text-[#6b7280]">أو <span class="text-[var(--primary)] font-medium">انقر للاختيار</span></p>
                      </div>
                    </div>
                    <input class="file-input hidden" type="file" name="tax_doc" id="tax-input" accept="application/pdf,image/*">
                  </div>
                  <div id="tax-preview" class="mt-3 hidden">
                    <div class="flex items-center justify-between p-3 bg-[#f9fafb] rounded-lg border border-[#e5d9d8]">
                      <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                          <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                          </svg>
                        </div>
                        <span class="text-sm font-medium text-[#374151]" id="tax-filename">ملف مرفوع</span>
                      </div>
                      <button type="button" id="tax-remove" class="w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                        ×
                      </button>
                    </div>
                  </div>
                </div>
                <div class="text-xs text-[#6b7280]">PDF/صور حتى 8MB</div>
                @error('tax_doc')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>

              <!-- Authorization Document -->
              <div class="space-y-3">
                <label class="label"><span class="label-text font-semibold text-[#3a2a2a]">تفويض الممثل</span></label>
                <div class="relative">
                  <div id="authorization-dropzone" class="border-2 border-dashed border-[#d1d5db] rounded-xl p-6 text-center transition-all duration-200 hover:border-[var(--primary)] hover:bg-[#fef7f7] cursor-pointer group">
                    <div class="flex flex-col items-center space-y-2">
                      <div class="w-10 h-10 rounded-full bg-[#f3f4f6] flex items-center justify-center group-hover:bg-[var(--primary)]/10 transition-colors duration-200">
                        <svg class="w-5 h-5 text-[#6b7280] group-hover:text-[var(--primary)] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-[#374151]">اسحب الملف هنا</p>
                        <p class="text-xs text-[#6b7280]">أو <span class="text-[var(--primary)] font-medium">انقر للاختيار</span></p>
                      </div>
                    </div>
                    <input class="file-input hidden" type="file" name="authorization_doc" id="authorization-input" accept="application/pdf,image/*">
                  </div>
                  <div id="authorization-preview" class="mt-3 hidden">
                    <div class="flex items-center justify-between p-3 bg-[#f9fafb] rounded-lg border border-[#e5d9d8]">
                      <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                          <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                          </svg>
                        </div>
                        <span class="text-sm font-medium text-[#374151]" id="authorization-filename">ملف مرفوع</span>
                      </div>
                      <button type="button" id="authorization-remove" class="w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                        ×
                      </button>
                    </div>
                  </div>
                </div>
                <div class="text-xs text-[#6b7280]">PDF/صور حتى 8MB</div>
                @error('authorization_doc')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>

              <!-- ID Front -->
              <div class="space-y-3">
                <label class="label"><span class="label-text font-semibold text-[#3a2a2a]">هوية الممثل (وجه)</span></label>
                <div class="relative">
                  <div id="id-front-dropzone" class="border-2 border-dashed border-[#d1d5db] rounded-xl p-6 text-center transition-all duration-200 hover:border-[var(--primary)] hover:bg-[#fef7f7] cursor-pointer group">
                    <div class="flex flex-col items-center space-y-2">
                      <div class="w-10 h-10 rounded-full bg-[#f3f4f6] flex items-center justify-center group-hover:bg-[var(--primary)]/10 transition-colors duration-200">
                        <svg class="w-5 h-5 text-[#6b7280] group-hover:text-[var(--primary)] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-[#374151]">اسحب الصورة هنا</p>
                        <p class="text-xs text-[#6b7280]">أو <span class="text-[var(--primary)] font-medium">انقر للاختيار</span></p>
                      </div>
                    </div>
                    <input class="file-input hidden" type="file" name="id_front" id="id-front-input" accept="image/*">
                  </div>
                  <div id="id-front-preview" class="mt-3 hidden">
                    <div class="relative inline-block">
                      <img alt="ID front preview" class="w-24 h-16 rounded-lg object-cover border-2 border-[#e5d9d8] bg-white shadow-sm" />
                      <button type="button" id="id-front-remove" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                        ×
                      </button>
                    </div>
                  </div>
                </div>
                <div class="text-xs text-[#6b7280]">صور حتى 4MB</div>
                @error('id_front')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>

              <!-- ID Back -->
              <div class="space-y-3">
                <label class="label"><span class="label-text font-semibold text-[#3a2a2a]">هوية الممثل (ظهر)</span></label>
                <div class="relative">
                  <div id="id-back-dropzone" class="border-2 border-dashed border-[#d1d5db] rounded-xl p-6 text-center transition-all duration-200 hover:border-[var(--primary)] hover:bg-[#fef7f7] cursor-pointer group">
                    <div class="flex flex-col items-center space-y-2">
                      <div class="w-10 h-10 rounded-full bg-[#f3f4f6] flex items-center justify-center group-hover:bg-[var(--primary)]/10 transition-colors duration-200">
                        <svg class="w-5 h-5 text-[#6b7280] group-hover:text-[var(--primary)] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-[#374151]">اسحب الصورة هنا</p>
                        <p class="text-xs text-[#6b7280]">أو <span class="text-[var(--primary)] font-medium">انقر للاختيار</span></p>
                      </div>
                    </div>
                    <input class="file-input hidden" type="file" name="id_back" id="id-back-input" accept="image/*">
                  </div>
                  <div id="id-back-preview" class="mt-3 hidden">
                    <div class="relative inline-block">
                      <img alt="ID back preview" class="w-24 h-16 rounded-lg object-cover border-2 border-[#e5d9d8] bg-white shadow-sm" />
                      <button type="button" id="id-back-remove" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                        ×
                      </button>
                    </div>
                  </div>
                </div>
                <div class="text-xs text-[#6b7280]">صور حتى 4MB</div>
                @error('id_back')<div class="text-error text-sm mt-1">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="flex items-center justify-between gap-2 pt-6 mt-6 border-t border-[#e5d9d8]">
            <button type="button" class="btn btn-outline" data-prev="2">السابق</button>
            <button class="btn btn-primary" type="submit">إرسال الطلب</button>
          </div>
        </div>
      </div>
    </form>
  </main>
  @push('scripts')
  <script>
  (function(){
    // PWA specific fixes
    document.addEventListener('DOMContentLoaded', function() {
      // Fix viewport for PWA
      const viewport = document.querySelector('meta[name="viewport"]');
      if (viewport) {
        viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
      }
      
      // Prevent zoom on input focus (PWA issue)
      const inputs = document.querySelectorAll('input, textarea, select');
      inputs.forEach(input => {
        input.addEventListener('focus', function() {
          if (window.innerWidth < 768) {
            setTimeout(() => {
              window.scrollTo(0, 0);
            }, 300);
          }
        });
      });
    });

    const tabs = Array.from(document.querySelectorAll('[data-tab]'));
    const btns = Array.from(document.querySelectorAll('[data-tab-btn]'));
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const form = document.getElementById('brand-request-form');
    const nameInput = document.getElementById('brand-name');
    const nameError = document.getElementById('brand-name-error');
    const logoInput = document.getElementById('logo-input');
    const coverInput = document.getElementById('cover-input');
    const logoPreview = document.querySelector('#logo-preview img');
    const logoPreviewWrap = document.getElementById('logo-preview');
    const coverPreview = document.querySelector('#cover-preview img');
    const coverPreviewWrap = document.getElementById('cover-preview');

    function setProgress(idx){
      const pct = idx === '1' ? 33 : (idx === '2' ? 66 : 100);
      if (progressBar) progressBar.style.width = pct + '%';
      if (progressText) progressText.textContent = pct + '%';
    }

    function activate(idx){
      tabs.forEach(t => t.classList.toggle('hidden', t.getAttribute('data-tab') !== String(idx)));
      btns.forEach(b => {
        const isActive = b.getAttribute('data-tab-btn') === String(idx);
        if (isActive) {
          b.classList.add('active', 'bg-[var(--primary)]', 'text-white');
          b.classList.remove('text-[#6b7280]', 'hover:text-[#3a2a2a]');
          const span = b.querySelector('span span');
          if (span) {
            span.classList.add('bg-white/20');
            span.classList.remove('bg-[#f1e7e6]');
          }
        } else {
          b.classList.remove('active', 'bg-[var(--primary)]', 'text-white');
          b.classList.add('text-[#6b7280]', 'hover:text-[#3a2a2a]');
          const span = b.querySelector('span span');
          if (span) {
            span.classList.remove('bg-white/20');
            span.classList.add('bg-[#f1e7e6]');
          }
        }
      });
      window.scrollTo({top:0, behavior:'smooth'});
      setProgress(String(idx));
    }
    // Basic validation for tab 1 (requires brand name)
    function canLeaveTab1(){
      const val = (nameInput?.value || '').trim();
      const ok = val.length > 0;
      if (!ok && nameError){ nameError.classList.remove('hidden'); nameInput?.focus(); }
      else if (nameError){ nameError.classList.add('hidden'); }
      return ok;
    }

    btns.forEach(b => b.addEventListener('click', () => {
      const target = b.getAttribute('data-tab-btn');
      const current = tabs.find(t => !t.classList.contains('hidden'))?.getAttribute('data-tab') || '1';
      if (current === '1' && target !== '1' && !canLeaveTab1()) return;
      activate(target);
    }));

    document.querySelectorAll('[data-next]').forEach(n => n.addEventListener('click', () => {
      const target = n.getAttribute('data-next');
      const current = tabs.find(t => !t.classList.contains('hidden'))?.getAttribute('data-tab') || '1';
      if (current === '1' && !canLeaveTab1()) return;
      activate(target);
    }));
    document.querySelectorAll('[data-prev]').forEach(p => p.addEventListener('click', () => activate(p.getAttribute('data-prev'))));

    // Modern drag and drop functionality
    function setupDropzone(dropzoneId, inputId, previewId, removeId, filenameId = null) {
      const dropzone = document.getElementById(dropzoneId);
      const input = document.getElementById(inputId);
      const preview = document.getElementById(previewId);
      const removeBtn = document.getElementById(removeId);
      const filenameEl = filenameId ? document.getElementById(filenameId) : null;

      if (!dropzone || !input || !preview || !removeBtn) return;

      // Click to upload
      dropzone.addEventListener('click', () => input.click());

      // File change
      input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) handleFile(file, preview, filenameEl, dropzone);
      });

      // Drag and drop
      dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-[var(--primary)]', 'bg-[var(--primary)]/5');
      });

      dropzone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-[var(--primary)]', 'bg-[var(--primary)]/5');
      });

      dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-[var(--primary)]', 'bg-[var(--primary)]/5');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
          const file = files[0];
          input.files = files;
          handleFile(file, preview, filenameEl, dropzone);
        }
      });

      // Remove file
      removeBtn.addEventListener('click', () => {
        input.value = '';
        preview.classList.add('hidden');
        dropzone.classList.remove('hidden');
      });
    }

    function handleFile(file, preview, filenameEl, dropzone) {
      if (filenameEl) {
        filenameEl.textContent = file.name;
      }

      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = preview.querySelector('img');
          if (img) img.src = e.target.result;
          preview.classList.remove('hidden');
          dropzone.classList.add('hidden');
        };
        reader.readAsDataURL(file);
      } else {
        preview.classList.remove('hidden');
        dropzone.classList.add('hidden');
      }
    }

    // Setup all dropzones
    setupDropzone('logo-dropzone', 'logo-input', 'logo-preview', 'logo-remove');
    setupDropzone('cover-dropzone', 'cover-input', 'cover-preview', 'cover-remove');
    setupDropzone('registration-dropzone', 'registration-input', 'registration-preview', 'registration-remove', 'registration-filename');
    setupDropzone('tax-dropzone', 'tax-input', 'tax-preview', 'tax-remove', 'tax-filename');
    setupDropzone('authorization-dropzone', 'authorization-input', 'authorization-preview', 'authorization-remove', 'authorization-filename');
    setupDropzone('id-front-dropzone', 'id-front-input', 'id-front-preview', 'id-front-remove');
    setupDropzone('id-back-dropzone', 'id-back-input', 'id-back-preview', 'id-back-remove');

    // LocalStorage autosave/restore
    const STORAGE_KEY = 'brand_request_draft_v1';
    function saveDraft(){
      if (!form) return;
      const data = {};
      Array.from(form.elements).forEach(el => {
        if (!el.name) return;
        if (el.type === 'file') return; // skip files
        if (el.type === 'checkbox' || el.type === 'radio') {
          if (el.checked) data[el.name] = el.value;
        } else {
          data[el.name] = el.value;
        }
      });
      try { localStorage.setItem(STORAGE_KEY, JSON.stringify(data)); } catch(e) {}
    }
    function loadDraft(){
      try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) return;
        const data = JSON.parse(raw);
        Object.keys(data || {}).forEach(name => {
          const el = form.elements.namedItem(name);
          if (!el || (el.type === 'file')) return;
          if (el.type === 'checkbox' || el.type === 'radio') {
            if (el.value === data[name]) el.checked = true;
          } else if (!el.value) {
            el.value = data[name];
          }
        });
      } catch(e) {}
    }
    loadDraft();
    form?.addEventListener('input', saveDraft);
    form?.addEventListener('change', saveDraft);
    form?.addEventListener('submit', () => { try { localStorage.removeItem(STORAGE_KEY); } catch(e) {} });

    // Initialize progress
    setProgress('1');

    // Enhanced date picker functionality
    const dateInput = document.getElementById('established-date');
    if (dateInput) {
      // Set default value to 10 years ago if empty
      if (!dateInput.value) {
        const tenYearsAgo = new Date();
        tenYearsAgo.setFullYear(tenYearsAgo.getFullYear() - 10);
        dateInput.value = tenYearsAgo.toISOString().split('T')[0];
      }

      // Add click handler to open calendar
      dateInput.addEventListener('click', function() {
        this.showPicker && this.showPicker();
      });

      // Add focus handler for better UX
      dateInput.addEventListener('focus', function() {
        this.style.borderColor = 'var(--primary)';
        this.style.boxShadow = '0 0 0 3px rgba(126, 45, 43, 0.1)';
      });

      dateInput.addEventListener('blur', function() {
        this.style.borderColor = '#d1d5db';
        this.style.boxShadow = 'none';
      });

      // Validate date on change
      dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        const minDate = new Date('1900-01-01');
        
        if (selectedDate > today) {
          alert('لا يمكن اختيار تاريخ في المستقبل');
          this.value = '';
          return;
        }
        
        if (selectedDate < minDate) {
          alert('الرجاء اختيار تاريخ بعد عام 1900');
          this.value = '';
          return;
        }

        // Show success feedback
        this.style.borderColor = '#10b981';
        setTimeout(() => {
          this.style.borderColor = '#d1d5db';
        }, 1000);
      });
    }
  })();
  </script>
  @endpush
@endsection
