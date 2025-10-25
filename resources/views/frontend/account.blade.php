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
    </section>

    <section class="section">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn" style="width:100%;padding:12px 10px;border-radius:12px">تسجيل الخروج</button>
      </form>
    </section>
  </main>
@endsection
