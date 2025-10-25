@extends('layouts.frontend')

@section('title', 'عناويني')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>عناويني</b>
        <span>إدارة عناوين التوصيل</span>
      </div>
    </div>
  </header>

  <main class="content">
    <section class="section" style="display:flex;justify-content:space-between;align-items:center;gap:10px;">
      <h3 style="margin:0;">القائمة</h3>
      <a class="btn" href="{{ route('addresses.create') }}" style="text-decoration:none;">إضافة عنوان</a>
    </section>

    <section class="section">
      @forelse($addresses as $addr)
        <div class="card" style="padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;gap:10px;justify-content:space-between;">
          <div>
            <div class="name">{{ $addr->label ?? 'عنوان' }} @if($addr->is_default)<span class="badge" style="margin-inline-start:8px;">افتراضي</span>@endif</div>
            <div class="meta">{{ $addr->line1 }} {{ $addr->line2 }} - {{ $addr->city }} - {{ $addr->region }}</div>
            <div class="meta">{{ $addr->recipient_name }} • {{ $addr->phone }}</div>
          </div>
          @unless($addr->is_default)
            <form method="POST" action="{{ route('addresses.default', $addr) }}">
              @csrf
              <button class="btn" type="submit">تعيين افتراضي</button>
            </form>
          @endunless
        </div>
      @empty
        <div class="card" style="padding:14px;">لا يوجد عناوين بعد</div>
      @endforelse
    </section>
  </main>
@endsection
