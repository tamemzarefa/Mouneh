@extends('layouts.frontend')

@section('title', $brand->name)

@section('content')
  <header class="header">
    <div class="brand">
      <div class="logo">
        @php
          $logoUrl = method_exists($brand,'getFirstMediaUrl') ? $brand->getFirstMediaUrl('logo') : null;
          if (!$logoUrl && !empty($brand->logo_path)) {
            $logoUrl = asset($brand->logo_path);
          }
        @endphp
        <img src="{{ $logoUrl ?: asset('images/logo.png') }}" alt="{{ $brand->name }}">
      </div>
      <div class="title">
        <b>{{ $brand->name }}</b>
        @if($brand->verified_at)
          <span class="badge" title="موثّق">موثّق</span>
        @endif
        @if($brand->description)
          <span style="display:block;color:#6b7280;font-weight:400;">{{ $brand->description }}</span>
        @endif
      </div>
    </div>
  </header>

  <main class="content">
    <form class="search" role="search" method="GET" action="{{ route('brands.show', $brand) }}">
      <div class="icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      </div>
      <input type="search" name="q" value="{{ $searchTerm ?? request('q') }}" placeholder="ابحث ضمن منتجات {{ $brand->name }}" class="search-input" aria-label="ابحث ضمن منتجات {{ $brand->name }}" autocomplete="off">
      <button type="submit" class="search-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><span>بحث</span></button>
    </form>

    <section class="section">
      <h3>منتجات {{ $brand->name }}</h3>
      <div class="grid">
        @forelse($products as $p)
          @php
            $imgUrl = null;
            if (method_exists($p, 'getFirstMediaUrl')) {
              $imgUrl = $p->getFirstMediaUrl('primary', 'medium') ?: $p->getFirstMediaUrl('gallery', 'medium');
            }
            if (!$imgUrl) {
              $first = optional($p->images->sortBy('sort_order')->first());
              $img = $first ? $first->url : null;
              $imgUrl = $img ? (filter_var($img, FILTER_VALIDATE_URL) ? $img : asset($img)) : null;
            }
            $priceText = ($p->currency === 'SYP')
              ? number_format($p->price_cents, 0, '.', ',').' ل.س'
              : number_format($p->price_cents/100, 2).' '.$p->currency;
          @endphp
          <article class="card product-card">
            <a href="{{ route('products.show', $p) }}" class="img" @if($imgUrl) style="display:block;background-image:url('{{ $imgUrl }}');background-size:cover;background-position:center;" @endif aria-label="{{ $p->title_ar }}">
              @if($p->stock <= 0)
                <div class="out-of-stock-overlay">
                  <span>غير متوفر</span>
                </div>
              @endif
            </a>
            @if($p->category && $p->category->name_ar)
              <span class="badge">{{ $p->category->name_ar }}</span>
            @endif
            <div class="body">
              <div class="name"><a href="{{ route('products.show', $p) }}" style="color:inherit;text-decoration:none;">{{ $p->title_ar }}</a></div>
              <div class="row">
                <div class="price">{{ $priceText }}</div>
                @if($p->stock > 0)
                  <form method="POST" action="{{ route('cart.store') }}" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn add-to-cart-btn">أضف للسلة</button>
                  </form>
                @else
                  <button class="btn disabled" disabled>غير متوفر</button>
                @endif
              </div>
            </div>
          </article>
        @empty
          <p>لا توجد منتجات.</p>
        @endforelse
      </div>
      <div style="margin-top:12px;">
        {{ $products->links() }}
      </div>
    </section>
  </main>
@endsection
