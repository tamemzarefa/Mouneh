@extends('layouts.frontend')

@section('title', $product->title_ar)

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>{{ $product->title_ar }}</b>
        <span>{{ optional($product->category)->name_ar }}</span>
      </div>
    </div>
  </header>

  <main class="content">
    <section class="section">
      @php
        $imgUrl = null;
        $gallery = [];
        if (method_exists($product, 'getFirstMediaUrl')) {
          $primary = $product->getFirstMediaUrl('primary') ?: $product->getFirstMediaUrl('gallery');
          $galleryMedia = method_exists($product, 'getMedia') ? $product->getMedia('gallery') : collect();
          $gallery = collect([$primary])->filter()->merge(
            $galleryMedia->map(fn($m) => $m->getUrl())
          )->unique()->values()->all();
          $imgUrl = $gallery[0] ?? null;
        }
        if (!$imgUrl) {
          $sorted = $product->images?->sortBy('sort_order') ?? collect();
          $gallery = $sorted->pluck('url')->map(function($u){ return $u ? (filter_var($u, FILTER_VALIDATE_URL) ? $u : asset($u)) : null; })->filter()->values()->all();
          $imgUrl = $gallery[0] ?? null;
        }
        $priceText = ($product->currency === 'SYP')
          ? number_format($product->price_cents, 0, '.', ',').' ل.س'
          : number_format($product->price_cents/100, 2).' '.$product->currency;
      @endphp

      <article class="card" style="overflow:hidden;">
        <div class="img" style="aspect-ratio:4/3;background:#f8f5f4;display:grid;place-items:center;position:relative;">
          @if($imgUrl)
            <img id="main-image" src="{{ $imgUrl }}" alt="{{ $product->title_ar }}" style="width:100%;height:100%;object-fit:cover;">
          @else
            <span style="color:#7a6b6b;">لا توجد صورة</span>
          @endif
          @if(count($gallery) > 1)
            <div class="thumbs" style="position:absolute;inset-inline:8px;bottom:8px;display:flex;gap:8px;overflow:auto;padding:6px;background:rgba(255,255,255,0.75);backdrop-filter:blur(6px);border-radius:12px;border:1px solid #eee;">
              @foreach($gallery as $idx => $u)
                <button type="button" class="thumb" data-src="{{ $u }}" aria-label="صورة {{ $idx+1 }}" style="border:none;background:transparent;padding:0;cursor:pointer;outline:none;">
                  <img src="{{ $u }}" alt="thumb" style="width:64px;height:64px;object-fit:cover;border-radius:10px;border:2px solid {{ $idx===0 ? 'var(--primary)' : '#eee' }};">
                </button>
              @endforeach
            </div>
          @endif
        </div>
        <div class="body">
          <div class="name" style="font-weight:700;font-size:16px;">{{ $product->title_ar }}</div>
          @if($product->description_ar)
            <div class="meta" style="white-space:pre-wrap;margin-top:6px;">{{ $product->description_ar }}</div>
          @endif
          <div class="row" style="margin-top:10px;display:flex;align-items:center;justify-content:space-between;gap:10px;">
            <div class="price" style="font-weight:700;color:var(--primary);">{{ $priceText }}</div>
            <div class="theme-muted">المتوفر: {{ (int)$product->stock }}</div>
          </div>

          <div class="row" style="margin-top:12px;display:flex;align-items:center;gap:10px;">
            <form method="POST" action="{{ route('cart.store') }}" style="display:flex;align-items:center;gap:10px;">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <label for="qty" class="theme-muted" style="font-size:13px;">الكمية</label>
              <input id="qty" name="quantity" type="number" min="1" max="{{ max(1,(int)$product->stock) }}" value="1" style="width:90px;border:1px solid #e8dedd;border-radius:12px;padding:8px 10px;text-align:center;">
              <button type="submit" class="btn" @if($product->stock <= 0) disabled @endif>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-inline-start:4px;">
                  <circle cx="9" cy="21" r="1"></circle>
                  <circle cx="20" cy="21" r="1"></circle>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                أضف للسلة
              </button>
            </form>
          </div>
        </div>
      </article>
    </section>
  </main>
  <script>
    (function(){
      const main = document.getElementById('main-image');
      if (!main) return;
      const container = main.closest('.img');
      const buttons = container ? container.querySelectorAll('.thumb') : [];
      buttons.forEach(btn => {
        btn.addEventListener('click', function(){
          const src = this.getAttribute('data-src');
          if (!src) return;
          // swap main image
          main.src = src;
          // update borders
          container.querySelectorAll('.thumb img').forEach(img => img.style.borderColor = '#eee');
          const img = this.querySelector('img');
          if (img) img.style.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--primary') || '#7e2d2b';
        });
      });
    })();
  </script>
@endsection
