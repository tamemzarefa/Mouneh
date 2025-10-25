@extends('layouts.frontend')

@section('title', 'سلة المشتريات')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>سلة المشتريات</b>
        <span>مراجعة المنتجات</span>
      </div>
    </div>
    @auth
      <a href="{{ route('account.index') }}" class="loc">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        الحساب
      </a>
    @else
      <a href="{{ route('login') }}" class="loc">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        تسجيل الدخول
      </a>
    @endauth
  </header>

  <main class="content">
    

    @if($items->isEmpty())
      <div class="section">
        <div class="card bg-base-200">
          <div class="card-body text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/30 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8V7a6 6 0 1112 0v1"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14l-1 11a2 2 0 01-2 2H8a2 2 0 01-2-2L5 8z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 11a3 3 0 006 0"/>
            </svg>
            <h3 class="text-xl font-semibold text-base-content/70 mb-2">السلة فارغة حالياً</h3>
            <p class="text-base-content/50 mb-4">أضف بعض المنتجات لتبدأ التسوق</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z" />
              </svg>
              تصفح المنتجات
            </a>
          </div>
        </div>
      </div>
    @else
      <section class="section">
        <h3>منتجاتك</h3>
        <div class="space-y-4">
          @foreach($items as $it)
            <div class="card bg-base-100 shadow-sm border border-base-300">
              <div class="card-body p-4">
                <!-- Product Header -->
                <div class="flex items-start justify-between mb-3">
                  <div class="flex-1">
                    <h4 class="font-semibold text-lg text-base-content">{{ $it['title'] }}</h4>
                    <p class="text-sm text-base-content/70">{{ number_format($it['unit_price_cents'], 0, '.', ',') }} ل.س لكل قطعة</p>
                  </div>
                  <form method="POST" action="{{ route('cart.remove', $it['id']) }}" class="ml-2" id="delete-form-{{ $it['id'] }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-error btn-sm btn-circle" 
                            onclick="window.__deleteFormId='delete-form-{{ $it['id'] }}'; window.dispatchEvent(new CustomEvent('open-modal',{ detail: 'delete-item' }))"
                            title="حذف المنتج">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </form>
                </div>
                
                <!-- Quantity and Price -->
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-base-content/80">الكمية:</label>
                    <form method="POST" action="{{ route('cart.update', $it['id']) }}" class="flex items-center gap-2">
                      @csrf
                      @method('PATCH')
                      <input type="number" name="quantity" value="{{ $it['quantity'] }}" min="1" max="99" 
                             class="input input-bordered input-sm w-16 text-center">
                      <button type="submit" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        تحديث
                      </button>
                    </form>
                  </div>
                  <div class="text-right">
                    <div class="text-lg font-bold text-primary">
                      {{ number_format($it['subtotal_cents'], 0, '.', ',') }} ل.س
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </section>

      <section class="section">
        <div class="card bg-primary text-primary-content">
          <div class="card-body p-4">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold">الإجمالي</h3>
              <div class="text-2xl font-bold">
                {{ number_format($totalCents, 0, '.', ',') }} ل.س
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="section">
        <form method="POST" action="{{ route('cart.checkout') }}">
          @csrf
          <div class="card bg-base-100 shadow-sm border border-base-300 mb-4">
            <div class="card-body p-4">
              <h3 class="text-lg font-semibold mb-3">اختر طريقة الدفع</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- COD -->
                <label class="group cursor-pointer">
                  <input type="radio" name="payment_provider" value="cod" class="peer sr-only" required>
                  <div class="card border border-base-300 transition group-hover:border-primary/60 peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/30">
                    <div class="card-body p-4 flex items-center gap-3">
                      <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M5 7l1.5 10.5A2 2 0 008.48 19h7.04a2 2 0 001.98-1.5L19 7M8 11h8m-8 4h5"/></svg>
                      </span>
                      <div class="flex-1">
                        <div class="font-semibold">الدفع عند الاستلام</div>
                        <div class="text-sm text-base-content/60">ادفع للمندوب عند التسليم</div>
                      </div>
                      <span class="hidden peer-checked:inline text-primary">✓</span>
                    </div>
                  </div>
                </label>

                <!-- Bank transfer -->
                <label class="group cursor-pointer">
                  <input type="radio" name="payment_provider" value="bank_transfer" class="peer sr-only" required>
                  <div class="card border border-base-300 transition group-hover:border-primary/60 peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/30">
                    <div class="card-body p-4 flex items-center gap-3">
                      <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10l9-6 9 6v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8z"/></svg>
                      </span>
                      <div class="flex-1">
                        <div class="font-semibold">حوالة بنكية</div>
                        <div class="text-sm text-base-content/60">تحويل المبلغ على الحساب البنكي</div>
                      </div>
                      <span class="hidden peer-checked:inline text-primary">✓</span>
                    </div>
                  </div>
                </label>

                <!-- Wallet -->
                <label class="group cursor-pointer">
                  <input type="radio" name="payment_provider" value="wallet" class="peer sr-only" required>
                  <div class="card border border-base-300 transition group-hover:border-primary/60 peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/30">
                    <div class="card-body p-4 flex items-center gap-3">
                      <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 12V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2v-5m0 0h-6a2 2 0 100 4h6v-4z"/></svg>
                      </span>
                      <div class="flex-1">
                        <div class="font-semibold">محفظة إلكترونية</div>
                        <div class="text-sm text-base-content/60">الدفع عبر المحفظة الرقمية</div>
                      </div>
                      <span class="hidden peer-checked:inline text-primary">✓</span>
                    </div>
                  </div>
                </label>

                <!-- Manual -->
                <label class="group cursor-pointer">
                  <input type="radio" name="payment_provider" value="manual" class="peer sr-only" required>
                  <div class="card border border-base-300 transition group-hover:border-primary/60 peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/30">
                    <div class="card-body p-4 flex items-center gap-3">
                      <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v8m-4-4h8M4 12a8 8 0 1116 0 8 8 0 01-16 0z"/></svg>
                      </span>
                      <div class="flex-1">
                        <div class="font-semibold">اتفاق يدوي</div>
                        <div class="text-sm text-base-content/60">التنسيق مباشرة مع البائع</div>
                      </div>
                      <span class="hidden peer-checked:inline text-primary">✓</span>
                    </div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-success btn-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
            </svg>
            تأكيد وإرسال الطلب للإدارة
          </button>
        </form>
      </section>
    @endif
  </main>
  
  <!-- Global Delete Confirmation Modal -->
  <x-modal name="delete-item" :show="false" maxWidth="sm">
    <div class="p-5">
      <div class="flex items-start gap-3">
        <div class="shrink-0 inline-flex h-10 w-10 items-center justify-center rounded-full bg-error/10 text-error">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M5.64 5.64a9 9 0 1112.72 12.72A9 9 0 015.64 5.64z"/></svg>
        </div>
        <div class="flex-1">
          <div class="font-semibold text-base mb-1">حذف المنتج من السلة</div>
          <div class="text-sm text-base-content/80">هل أنت متأكد من حذف هذا المنتج من السلة؟ لا يمكن التراجع عن هذا الإجراء.</div>
        </div>
      </div>
      <div class="mt-5 flex gap-3 justify-start">
        <button type="button" class="btn" onclick="window.dispatchEvent(new CustomEvent('close-modal',{ detail: 'delete-item' }))">إلغاء</button>
        <button type="button" class="btn btn-error" onclick="(function(){var id=window.__deleteFormId; if(!id){window.dispatchEvent(new CustomEvent('close-modal',{ detail: 'delete-item' })); return;} var f=document.getElementById(id); if(f){f.submit();}})()">حذف</button>
      </div>
    </div>
  </x-modal>
@endsection
