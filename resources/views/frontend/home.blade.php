@extends('layouts.frontend')

@section('title', 'مونة السوّيداء')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="مونة سويّدا">
      </div>
      <div class="title">
        <b>مونة السوّيداء</b>
        <span>سوق المنتجات البيتية</span>
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
    <form class="search" role="search" method="GET" action="{{ route('home') }}">
      <div class="icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      </div>
      <input type="search" name="q" value="{{ $searchTerm ?? request('q') }}" placeholder="ابحث عن دبس رمان، مكدوس، سماق..." class="search-input" aria-label="ابحث عن المنتجات" autocomplete="off">
      @if(!empty($activeCategory))
        <input type="hidden" name="category" value="{{ $activeCategory }}">
      @endif
      <button type="button" class="clear-btn" aria-label="مسح البحث" style="display:none;">×</button>
      <button type="submit" class="search-btn" aria-label="بحث">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <span>بحث</span>
      </button>
    </form>

    <div class="chips" aria-label="الأقسام">
      <a class="chip {{ empty($activeCategory) ? 'active' : '' }}" href="{{ route('home', ['q' => request('q')]) }}">الكل</a>
      @isset($categories)
        @foreach($categories as $cat)
          <a class="chip {{ (isset($activeCategory) && (int)$activeCategory === (int)$cat->id) ? 'active' : '' }}" href="{{ route('home', ['category' => $cat->id, 'q' => request('q')]) }}">{{ $cat->name_ar }}</a>
        @endforeach
      @endisset
    </div>

    <section class="section">
      <h3>الأكثر طلباً</h3>
      <div class="grid">
        @isset($products)
          @foreach($products as $p)
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
                <div class="meta">
                  <span class="stock-status {{ $p->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                    {{ $p->stock > 0 ? 'متوفر' : 'غير متوفر' }}
                  </span>
                  @if($p->avg_rating)
                    <span class="rating">• {{ number_format($p->avg_rating,1) }} ★</span>
                  @endif
                </div>
                <div class="row">
                  <div class="price">{{ $priceText }}</div>
                  @if($p->stock > 0)
                    <form method="POST" action="{{ route('cart.store') }}" class="add-to-cart-form">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $p->id }}">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" class="btn add-to-cart-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <circle cx="9" cy="21" r="1"></circle>
                          <circle cx="20" cy="21" r="1"></circle>
                          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        أضف للسلة
                      </button>
                    </form>
                  @else
                    <button class="btn disabled" disabled>غير متوفر</button>
                  @endif
                </div>
              </div>
            </article>
          @endforeach
        @endisset
      </div>
    </section>

    <section class="banner">
      <div class="emoji" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-7 w-7">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 7a5 5 0 0 1 10 0c0 .34-.03.67-.1.99A3.5 3.5 0 0 1 14.5 10h-5A3.5 3.5 0 0 1 7.1 7.99 5.7 5.7 0 0 1 7 7z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 13h8l-.6 5.1A2 2 0 0 1 13.42 20H10.6a2 2 0 0 1-1.98-1.9L8 13z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 10.5v2m5-2v2"/>
        </svg>
      </div>
      <div class="text">
        <b>بيع منتجاتك البيتية</b>
        <span>أنشئ إعلانك الآن وسيتم مراجعته من الإدارة</span>
      </div>
      @auth
        <a class="cta" href="{{ route('products.create') }}">بيع منتجك الآن</a>
      @else
        <a class="cta" href="{{ route('login') }}">سجّل لتبيع الآن</a>
      @endauth
    </section>
  </main>

  @push('scripts')
  <script>
    // Enhanced cart functionality with user feedback
    document.addEventListener('DOMContentLoaded', function() {
      // Add to cart form handling
      const addToCartForms = document.querySelectorAll('.add-to-cart-form');
      
      addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
          const button = form.querySelector('.add-to-cart-btn');
          const originalText = button.innerHTML;
          
          // Show loading state
          button.innerHTML = `
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="animate-spin">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 6v6l4 2"/>
            </svg>
            جاري الإضافة...
          `;
          button.disabled = true;
          
          // Add ripple effect
          button.style.position = 'relative';
          button.style.overflow = 'hidden';
          
          // Reset button after 2 seconds
          setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
          }, 2000);
        });
      });

      // Search functionality (client-side filter with debounce + clear + animations)
      const searchInput = document.querySelector('.search-input');
      const clearBtn = document.querySelector('.clear-btn');
      const productCards = () => document.querySelectorAll('.product-card');
      let searchTimer;

      function normalize(text) {
        return (text || '').toString().toLowerCase();
      }

      function showCard(card) {
        card.style.display = 'block';
        card.classList.add('filter-anim');
        requestAnimationFrame(() => {
          card.classList.remove('filter-hidden');
        });
      }

      function hideCard(card) {
        card.classList.add('filter-hidden');
        setTimeout(() => {
          card.style.display = 'none';
          card.classList.remove('filter-anim');
        }, 180);
      }

      function applyFilter(query) {
        const q = normalize(query);
        productCards().forEach(card => {
          const nameEl = card.querySelector('.name');
          const badgeEl = card.querySelector('.badge');
          const productName = normalize(nameEl ? nameEl.textContent : '');
          const category = normalize(badgeEl ? badgeEl.textContent : '');
          const match = !q || productName.includes(q) || category.includes(q);
          if (match) {
            showCard(card);
          } else {
            hideCard(card);
          }
        });
      }

      if (searchInput) {
        searchInput.addEventListener('input', function() {
          const val = this.value;
          if (clearBtn) clearBtn.style.display = val ? 'inline-flex' : 'none';
          clearTimeout(searchTimer);
          searchTimer = setTimeout(() => applyFilter(val), 150);
        });
        // Initialize from existing value (server-side q)
        const initialVal = searchInput.value || '';
        if (clearBtn) clearBtn.style.display = initialVal ? 'inline-flex' : 'none';
        if (initialVal) applyFilter(initialVal);
      }

      if (clearBtn && searchInput) {
        clearBtn.addEventListener('click', function() {
          searchInput.value = '';
          this.style.display = 'none';
          applyFilter('');
          searchInput.focus();
        });
      }

      // Add smooth scroll for category chips
      const chips = document.querySelectorAll('.chip');
      chips.forEach(chip => {
        chip.addEventListener('click', function(e) {
          // Add active state animation
          this.style.transform = 'scale(0.95)';
          setTimeout(() => {
            this.style.transform = 'scale(1)';
          }, 150);
        });
      });
    });
  </script>
  
  <style>
    /* Search UI */
    .search {
      position: relative;
      display: flex;
      align-items: center;
      gap: 8px;
      background: #fff;
      border: 1px solid #e8dedd;
      border-radius: 12px;
      padding: 10px 12px;
      box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .search:focus-within {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }
    .search .icon {
      color: #6b7280;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 24px;
      height: 24px;
      flex: 0 0 auto;
    }
    .search-input {
      flex: 1 1 auto;
      border: none;
      outline: none;
      background: transparent;
      color: #111827;
      font-size: 14px;
    }
    .clear-btn {
      border: none;
      background: #f3f4f6;
      color: #6b7280;
      border-radius: 999px;
      padding: 2px 8px;
      cursor: pointer;
      transition: background-color .15s ease, color .15s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      line-height: 1;
      font-size: 16px;
    }
    .clear-btn:hover { background: #e5e7eb; color: #374151; }
    .search-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 10px 14px;
      border-radius: 999px;
      border: none;
      background: #7e2d2b;
      color: #fff;
      cursor: pointer;
      font-weight: 600;
      transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease, outline-color .15s ease;
    }
    .search-btn:hover { box-shadow: 0 2px 6px rgba(0,0,0,0.12); background:#6f2826; }
    .search-btn:active { transform: translateY(1px); }
    .search-btn:focus-visible { outline: 3px solid rgba(126,45,43,0.35); outline-offset: 2px; }

    /* Product card filter animations */
    .product-card { will-change: opacity, transform; }
    .filter-anim { transition: opacity .18s ease, transform .18s ease; }
    .filter-hidden { opacity: 0 !important; transform: translateY(4px) scale(0.98); }
    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .animate-spin {
      animation: spin 1s linear infinite;
    }
    
    .product-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .product-card:hover {
      transform: translateY(-4px);
    }
    
    .add-to-cart-btn svg {
      transition: transform 0.2s ease;
    }
    
    .add-to-cart-btn:hover svg {
      transform: scale(1.1);
    }
  </style>
  @endpush
@endsection
