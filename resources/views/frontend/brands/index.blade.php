@extends('layouts.frontend')

@section('title', 'العلامات التجارية')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>العلامات التجارية الموثّقة</b>
        <span>اكتشف المتاجر المعتمدة</span>
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
    <form class="search" role="search" method="GET" action="{{ route('brands.index') }}" style="margin-bottom:14px;">
      <div class="icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      </div>
      <input type="search" name="q" value="{{ $searchTerm ?? request('q') }}" placeholder="ابحث عن علامة..." class="search-input" aria-label="ابحث عن العلامات" autocomplete="off">
      <button type="submit" class="search-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><span>بحث</span></button>
    </form>

    <section class="section">
      <h3>العلامات</h3>
      <div class="grid">
        @forelse($brands as $brand)
          @php
            $coverUrl = method_exists($brand,'getFirstMediaUrl') ? $brand->getFirstMediaUrl('cover') : null;
            $logoUrl = method_exists($brand,'getFirstMediaUrl') ? $brand->getFirstMediaUrl('logo') : null;
            if (!$coverUrl && !empty($brand->cover_path)) { $coverUrl = asset($brand->cover_path); }
            if (!$logoUrl && !empty($brand->logo_path)) { $logoUrl = asset($brand->logo_path); }
          @endphp
          <a href="{{ route('brands.show', $brand) }}" class="card" style="text-decoration:none;color:inherit;display:block;overflow:hidden;">
            <div style="height:120px;background:#f3f4f6;display:flex;align-items:center;justify-content:center; @if($coverUrl) background-image:url('{{ $coverUrl }}');background-size:cover;background-position:center; @endif">
              @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $brand->name }}" style="max-height:80px;max-width:80%;background:#fff;border-radius:10px;padding:6px;box-shadow:0 2px 6px rgba(0,0,0,0.08);">
              @endif
            </div>
            <div class="body">
              <div class="name" style="font-weight:700;">{{ $brand->name }}</div>
              @if($brand->verified_at)
                <span class="badge" title="موثّق">موثّق</span>
              @endif
              @if($brand->description)
                <div style="color:#6b7280;font-size:13px;margin-top:4px;">{{ Str::limit($brand->description, 80) }}</div>
              @endif
            </div>
          </a>
        @empty
          <p>لا توجد نتائج.</p>
        @endforelse
      </div>
      <div style="margin-top:12px;">
        {{ $brands->links() }}
      </div>
    </section>
  </main>
@endsection
