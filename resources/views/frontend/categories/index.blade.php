@extends('layouts.frontend')

@section('title', 'الأقسام')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>الأقسام</b>
        <span>استكشف منتجاتنا</span>
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
    <section class="section">
      <div id="pwa-install-card" class="mb-3 hidden" style="border:1px solid #f0e6e5;background:#fff;border-radius:14px;padding:12px;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
          <div style="display:flex;align-items:center;gap:10px;">
            <img src="/images/logo.png" alt="Mouneh" style="width:40px;height:40px;border-radius:10px;object-fit:cover;"/>
            <div>
              <div style="font-size:13px;font-weight:600;color:#3a2a2a;">تثبيت التطبيق</div>
              <div style="font-size:12px;color:#7a6b6b;">احفظ موقعنا كتطبيق لفتح أسرع واستخدام دون إنترنت</div>
            </div>
          </div>
          <div style="display:flex;align-items:center;gap:8px;">
            <button id="pwa-install-btn" class="btn">تثبيت</button>
            <button id="pwa-dismiss-btn" class="chip">لاحقاً</button>
          </div>
        </div>
      </div>
      @if($categories->isEmpty())
        <div style="border:1px solid #f0e6e5;background:#fff;border-radius:14px;padding:24px;text-align:center;color:#7a6b6b;">لا توجد أقسام حالياً.</div>
      @else
        <div class="grid">
          @foreach($categories as $cat)
            @php
              $img = $cat->getFirstMediaUrl('image');
              if(!$img && !empty($cat->image_url)){
                $img = (\Illuminate\Support\Str::startsWith($cat->image_url, ['http://','https://','/']))
                  ? $cat->image_url
                  : asset($cat->image_url);
              }
            @endphp
            <a href="{{ route('categories.show', $cat) }}" class="card" style="text-decoration:none;color:inherit;display:block;overflow:hidden;">
              <div class="img cat-thumb" style="position:relative;width:100%;aspect-ratio:1/1;background:#f8f5f4;">
                @if($img)
                  <img src="{{ $img }}" alt="{{ $cat->name_ar }}" style="position:absolute;top:0;right:0;bottom:0;left:0;width:100%;height:100%;object-fit:cover;" loading="lazy" />
                @endif
                <div class="fallback-box" style="position:absolute;inset:0;display:{{ $img ? 'none' : 'flex' }};align-items:center;justify-content:center;background:#f0e6e5;font-weight:600;font-size:20px;color:#3a2a2a;">
                  {{ function_exists('mb_substr') ? mb_substr($cat->name_ar,0,1) : substr($cat->name_ar,0,1) }}
                </div>
              </div>
              <div class="body" style="flex:1 1 auto;padding:12px;">
                <div class="name" style="font-size:14px;font-weight:600;color:#3a2a2a;">{{ $cat->name_ar }}</div>
                <div class="row" style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                  <div class="meta" style="font-size:12px;color:#7a6b6b;">اضغط للاستكشاف</div>
                  <svg class="opacity-60 transition-transform duration-200" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      @endif
    </section>
  </main>
  @push('scripts')
  <script>
    (function(){
      document.querySelectorAll('.cat-thumb img').forEach(function(img){
        img.addEventListener('error', function(){
          var f = img.parentElement.querySelector('.fallback-box');
          if(f){ f.classList.remove('hidden'); }
          img.classList.add('hidden');
        }, { once: true });
      });

      var deferredPrompt;
      var card = document.getElementById('pwa-install-card');
      var btn = document.getElementById('pwa-install-btn');
      var dismiss = document.getElementById('pwa-dismiss-btn');

      window.addEventListener('beforeinstallprompt', function(e){
        e.preventDefault();
        deferredPrompt = e;
        if(card) card.classList.remove('hidden');
      });

      window.addEventListener('appinstalled', function(){
        deferredPrompt = null;
        if(card) card.classList.add('hidden');
      });

      if(btn){
        btn.addEventListener('click', function(){
          if(!deferredPrompt) return;
          deferredPrompt.prompt();
          deferredPrompt.userChoice.finally(function(){
            if(card) card.classList.add('hidden');
            deferredPrompt = null;
          });
        });
      }

      if(dismiss){
        dismiss.addEventListener('click', function(){
          if(card) card.classList.add('hidden');
        });
      }
    })();
  </script>
  @endpush
@endsection
