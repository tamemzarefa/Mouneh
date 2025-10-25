@extends('layouts.frontend')

@section('title', $category->name_ar)

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>{{ $category->name_ar }}</b>
        <span>المنتجات ضمن هذا القسم</span>
      </div>
    </div>
  </header>

  <main class="content">
    <section class="section">
      <div class="grid">
        @forelse($products as $p)
          @php
            $imgUrl = null;
            if (method_exists($p, 'getFirstMediaUrl')) {
              $imgUrl = $p->getFirstMediaUrl('primary') ?: $p->getFirstMediaUrl('gallery');
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
                <form method="POST" action="{{ route('cart.store') }}">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $p->id }}">
                  <input type="hidden" name="quantity" value="1">
                  <button type="submit" class="btn">أضف للسلة</button>
                </form>
              </div>
            </div>
          </article>
        @empty
          <div class="card" style="padding:14px;">لا يوجد منتجات ضمن هذا القسم حالياً</div>
        @endforelse
      </div>
    </section>

    <section class="section">
      {{ $products->links() }}
    </section>
  </main>
@endsection
