
<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="{{ env('BRAND_PRIMARY', '#7e2d2b') }}">
    <title>مونة سويّدا</title>
    <link rel="manifest" href="/manifest.webmanifest">
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

      .content{flex:1;overflow:auto;padding:14px 14px 86px}
      .search{display:flex;gap:10px}
      .search input{flex:1;border:none;background:#fff;border-radius:999px;padding:12px 14px 12px 44px;outline:none;box-shadow:0 1px 0 #f0e6e5, 0 8px 24px rgba(126,45,43,.08);font-size:14px}
      .search .icon{position:relative}
      .search .icon svg{position:absolute;inset-inline-end:-36px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#9b8a8a}
      .chips{margin-top:12px;display:flex;gap:10px;overflow:auto;padding-bottom:4px}
      .chip{white-space:nowrap;padding:9px 12px;border-radius:999px;background:#fff;border:1px solid #f2e8e7;font-size:13px;color:#5a4a4a}
      .chip.active{background:var(--primary);border-color:var(--primary);color:#fff}

      .section{margin-top:18px}
      .section h3{margin:0 2px 10px;font-size:16px;color:#3a2a2a}
      .grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
      .card{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 1px 0 #f0e6e5, 0 10px 30px rgba(126,45,43,.08)}
      .card .img{aspect-ratio:1.2/1;background:#f8efee;position:relative}
      .badge{position:absolute;top:10px;inset-inline-start:10px;background:#fff;color:var(--primary);padding:6px 10px;border-radius:999px;font-size:12px;border:1px solid #f4e9e8}
      .card .body{padding:10px}
      .card .name{font-size:14px;color:#3a2a2a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
      .card .meta{margin-top:4px;font-size:12px;color:#8a7b7b}
      .card .row{margin-top:10px;display:flex;align-items:center;gap:8px}
      .price{color:var(--primary);font-weight:600}
      .btn{margin-inline-start:auto;background:var(--primary);color:#fff;border:none;border-radius:12px;padding:8px 10px;font-size:12px}

      .banner{margin-top:18px;border-radius:18px;background:linear-gradient(135deg, var(--primary), #a33e3b);color:#fff;padding:16px;display:flex;align-items:center;gap:12px}
      .banner .emoji{font-size:26px}
      .banner .text{flex:1}
      .banner .text b{display:block;font-size:16px}
      .banner .text span{font-size:12px;color:#ffefe9}
      .banner .cta{background:#fff;color:var(--primary);border:none;border-radius:12px;padding:10px 12px;font-weight:600}

      .bottom{position:fixed;inset-inline:0;bottom:0;background:#fff;border-top:1px solid #efe6e5;padding:8px 10px;padding-bottom:calc(8px + env(safe-area-inset-bottom));z-index:30}
      .tabs{max-width:480px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
      .tab{display:flex;flex-direction:column;align-items:center;gap:4px;color:#7a6b6b;text-decoration:none;padding:8px;border-radius:12px}
      .tab svg{width:22px;height:22px}
      .tab.active{color:var(--primary);background:var(--primary-200)}
      @media(min-width:700px){.content{padding-bottom:110px}}
    </style>
  </head>
  <body>
    <div class="app">
      <div class="shell">
        <header class="header">
          <div class="brand">
            <div class="logo">
              <img src="{{ asset('images/logo.png') }}" alt="مونة سويّدا">
            </div>
            <div class="title">
              <b>مونة سويّدا</b>
              <span>سوق المنتجات البيتية</span>
            </div>
          </div>
          <button class="loc">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s7-5.3 7-11a7 7 0 1 0-14 0c0 5.7 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
            السويدا
          </button>
        </header>

        <main class="content">
          <div class="search">
            <div class="icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            </div>
            <input type="search" placeholder="ابحث عن دبس رمان، مكدوس، سماق...">
          </div>

          <div class="chips" aria-label="الأقسام">
            <button class="chip active">الكل</button>
            @isset($categories)
              @foreach($categories as $cat)
                <button class="chip">{{ $cat->name_ar }}</button>
              @endforeach
            @endisset
          </div>

          <section class="section">
            <h3>الأكثر طلباً</h3>
            <div class="grid">
              @isset($products)
                @foreach($products as $p)
                  @php
                    $first = optional($p->images->sortBy('sort_order')->first());
                    $img = $first ? $first->url : null;
                    $imgUrl = $img ? (filter_var($img, FILTER_VALIDATE_URL) ? $img : asset($img)) : null;
                    $priceText = ($p->currency === 'SYP')
                      ? number_format($p->price_cents, 0, '.', ',').' ل.س'
                      : number_format($p->price_cents/100, 2).' '.$p->currency;
                  @endphp
                  <article class="card">
                    <div class="img" @if($imgUrl) style="background-image:url('{{ $imgUrl }}');background-size:cover;background-position:center;" @endif>
                      @if($p->category && $p->category->name_ar)
                        <span class="badge">{{ $p->category->name_ar }}</span>
                      @endif
                    </div>
                    <div class="body">
                      <div class="name">{{ $p->title_ar }}</div>
                      <div class="meta">{{ $p->stock > 0 ? 'متوفر' : 'غير متوفر' }} @if($p->avg_rating) • {{ number_format($p->avg_rating,1) }} ★ @endif</div>
                      <div class="row">
                        <div class="price">{{ $priceText }}</div>
                        <button class="btn">أضف للسلة</button>
                      </div>
                    </div>
                  </article>
                @endforeach
              @endisset
            </div>
          </section>

          <section class="banner">
            <div class="emoji">🧺</div>
            <div class="text">
              <b>ادعموا منتجي السويدا</b>
              <span>اطلب مباشرة من أهل البيت ووصل طلبك بسرعة</span>
            </div>
            <button class="cta">تسوق الآن</button>
          </section>
        </main>

        @include('partials.bottom-nav')
      </div>
    </div>

    <script>
      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js').catch(function(){});
      }
    </script>
  </body>
  </html>

