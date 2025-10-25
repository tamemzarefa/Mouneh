@extends('layouts.frontend')

@section('title', 'حسابي')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>حسابي</b>
        <span>إدارة الملف الشخصي</span>
      </div>
    </div>
  </header>

  <main class="content">
    <section class="section">
      <div class="card" style="padding:14px;">
        <div class="name" style="font-size:16px;margin-bottom:8px;">{{ $user->name }}</div>
        <div class="meta">{{ $user->email }}</div>
      </div>
    </section>

    <section class="section">
      <div class="grid">
        <a class="card" href="{{ route('account.edit') }}" style="text-decoration:none;color:inherit;display:block;">
          <div class="body">
            <div class="name">تعديل المعلومات</div>
            <div class="meta">الاسم، البريد، كلمة المرور</div>
          </div>
        </a>
        <a class="card" href="{{ url('/orders') }}" style="text-decoration:none;color:inherit;display:block;">
          <div class="body">
            <div class="name">طلباتي</div>
            <div class="meta">عرض حالة الطلبات</div>
          </div>
        </a>
        <a class="card" href="{{ url('/addresses') }}" style="text-decoration:none;color:inherit;display:block;">
          <div class="body">
            <div class="name">العناوين</div>
            <div class="meta">إدارة عناوين التوصيل</div>
          </div>
        </a>
        <a class="card" href="{{ route('brand.request.create') }}" style="text-decoration:none;color:inherit;display:block;">
          <div class="body">
            <div class="name">هل لديك علامة؟</div>
            <div class="meta">قدّم طلب تسجيل علامتك الآن</div>
          </div>
        </a>
      </div>
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
    </section>

    <section class="section">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn" style="width:100%;padding:12px 10px;border-radius:12px">تسجيل الخروج</button>
      </form>
    </section>
  </main>
@endsection
