<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="{{ env('BRAND_PRIMARY', '#7e2d2b') }}">
    <title>@yield('title', 'مونة السوّيداء')</title>
    <link rel="manifest" href="/manifest.webmanifest">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
      :root{--primary:{{ env('BRAND_PRIMARY', '#7e2d2b') }};--primary-600:#6e2625;--primary-200:#f6e6e5;--accent:#f6c445;--accent-600:#e0ae2d;--bg:#fff7f2;--surface:#ffffff;--text:#2d1e1e;--muted:#7a6b6b;--success:#0e9f6e;--radius:14px}
      *{box-sizing:border-box}
      html,body{height:100%}
      body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,"Noto Naskh Arabic","Noto Kufi Arabic","Amiri",sans-serif;background:var(--bg);color:var(--text)}
      .app{min-height:100%;display:flex;justify-content:center}
      .shell{width:100%;max-width:480px;min-height:100dvh;display:flex;flex-direction:column;background:linear-gradient(180deg,#fffdfa, #fff7f2 40%, #fff1e6)}
      .header{position:sticky;top:0;z-index:20;background:var(--surface);padding:12px 16px;padding-top:calc(12px + env(safe-area-inset-top));border-bottom:1px solid #f0e6e5;display:flex;align-items:center;gap:10px}
      .brand{display:flex;align-items:center;gap:10px}
      .logo{width:36px;height:36px;border-radius:10px;overflow:hidden;background:#fff;display:grid;place-items:center;border:1px solid #f0e6e5}
      .logo img{width:100%;height:100%;object-fit:cover}
      .title{display:flex;flex-direction:column;line-height:1}
      .title b{font-size:18px;color:var(--primary)}
      .title span{font-size:12px;color:var(--muted)}
      .loc{margin-inline-start:auto;background:#fff3d1;color:#7a4f00;border:none;border-radius:999px;padding:8px 12px;font-size:12px;display:flex;align-items:center;gap:6px}
      .loc svg{width:16px;height:16px}
      .header-actions{display:flex;align-items:center;gap:8px;margin-inline-start:auto}
      .account-btn{display:flex;align-items:center;gap:6px;padding:8px 12px;background:#fff;border:1px solid #f0e6e5;border-radius:12px;color:var(--primary);text-decoration:none;font-size:12px;font-weight:500;transition:all 0.2s ease}
      .account-btn:hover{background:var(--primary-200);border-color:var(--primary);transform:translateY(-1px)}
      .account-btn.active{background:var(--primary-200);border-color:var(--primary);color:var(--primary)}
      .account-btn svg{width:16px;height:16px}

      .content{flex:1;overflow:auto;padding:14px 14px 86px}
      .search{display:flex;gap:10px}
      .search input{flex:1;border:none;background:#fff;border-radius:999px;padding:12px 14px 12px 44px;outline:none;box-shadow:0 1px 0 #f0e6e5, 0 8px 24px rgba(126,45,43,.08);font-size:14px;transition:all 0.2s ease}
      .search input:focus{box-shadow:0 1px 0 var(--primary), 0 8px 24px rgba(126,45,43,.15);transform:translateY(-1px)}
      .search .icon{position:relative}
      .search .icon svg{position:absolute;inset-inline-end:-36px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#9b8a8a}
      .chips{margin-top:12px;display:flex;gap:10px;overflow:auto;padding-bottom:4px}
      .chip{white-space:nowrap;padding:9px 12px;border-radius:999px;background:#fff;border:1px solid #f2e8e7;font-size:13px;color:#5a4a4a}
      .chip.active{background:var(--primary);border-color:var(--primary);color:#fff}

      .section{margin-top:18px}
      .section h3{margin:0 2px 10px;font-size:16px;color:#3a2a2a}
      .grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
      .card{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 1px 0 #f0e6e5, 0 10px 30px rgba(126,45,43,.08);transition:all 0.3s ease;position:relative}
      .card:hover{transform:translateY(-2px);box-shadow:0 1px 0 #f0e6e5, 0 15px 40px rgba(126,45,43,.12)}
      .card .img{aspect-ratio:1.2/1;background:#f8efee;position:relative;overflow:hidden}
      .badge{position:absolute;top:10px;inset-inline-start:10px;background:#fff;color:var(--primary);padding:6px 10px;border-radius:999px;font-size:12px;border:1px solid #f4e9e8;z-index:2}
      .out-of-stock-overlay{position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:14px;z-index:1}
      .card .body{padding:10px}
      .card .name{font-size:14px;color:#3a2a2a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.3}
      .card .meta{margin-top:4px;font-size:12px;display:flex;align-items:center;gap:4px}
      .stock-status.in-stock{color:var(--success)}
      .stock-status.out-of-stock{color:#e53e3e}
      .rating{color:#8a7b7b}
      .card .row{margin-top:10px;display:flex;align-items:center;gap:8px}
      .price{color:var(--primary);font-weight:600;font-size:14px}
      .btn{margin-inline-start:auto;background:var(--primary);color:#fff;border:none;border-radius:12px;padding:8px 12px;font-size:12px;display:flex;align-items:center;gap:4px;transition:all 0.2s ease;cursor:pointer}
      .btn:hover{background:var(--primary-600);transform:scale(1.02)}
      .btn:active{transform:scale(0.98)}
      .btn.disabled{background:#e2e8f0;color:#a0aec0;cursor:not-allowed;transform:none}
      .add-to-cart-btn{position:relative;overflow:hidden}
      .add-to-cart-btn:before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;background:rgba(255,255,255,0.3);border-radius:50%;transform:translate(-50%,-50%);transition:all 0.3s ease}
      .add-to-cart-btn:active:before{width:100%;height:100%}

      .banner{margin-top:18px;border-radius:18px;background:linear-gradient(135deg, var(--primary), #a33e3b);color:#fff;padding:16px;display:flex;align-items:center;gap:12px}
      .banner .emoji{font-size:26px}
      .banner .text{flex:1}
      .banner .text b{display:block;font-size:16px}
      .banner .text span{font-size:12px;color:#ffefe9}
      .banner .cta{background:#fff;color:var(--primary);border:none;border-radius:12px;padding:10px 12px;font-weight:600}

      .bottom{position:fixed;inset-inline:0;bottom:0;background:#fff;border-top:1px solid #efe6e5;padding:8px 10px;padding-bottom:calc(8px + env(safe-area-inset-bottom));z-index:30}
      .tabs{max-width:480px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:6px}
      .tab{display:flex;flex-direction:column;align-items:center;gap:3px;color:#7a6b6b;text-decoration:none;padding:8px;border-radius:12px}
      .tab svg{width:20px;height:20px}
      .tab.active{color:var(--primary);background:var(--primary-200)}
      @media(min-width:700px){.content{padding-bottom:110px}}
    </style>
    
    
  </head>
  <body>
    <div class="app">
      <div class="shell">
        @php
          $flashMessage = session('status');
          $hasErrors = $errors->any();
        @endphp
        @if($flashMessage || $hasErrors)
          <x-modal name="flash" :show="true" maxWidth="md">
            <div class="p-5">
              <div class="flex items-start gap-3">
                <div class="shrink-0 inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                  </svg>
                </div>
                <div class="flex-1">
                  @if($flashMessage)
                    <div class="font-semibold text-base mb-1">إشعار</div>
                    <div class="text-sm text-base-content/80">{{ $flashMessage }}</div>
                  @endif
                  @if($hasErrors)
                    <div class="font-semibold text-base mt-2 mb-1">حدثت أخطاء</div>
                    <ul class="list-disc list-inside text-sm text-error/90">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </div>
              <div class="mt-5 text-left">
                <button x-on:click="$dispatch('close-modal','flash')" type="button" class="btn btn-primary">حسناً</button>
              </div>
            </div>
          </x-modal>
        @endif
        @yield('content')
        @include('partials.bottom-nav')
      </div>
    </div>
    @stack('scripts')
  </body>
</html>
