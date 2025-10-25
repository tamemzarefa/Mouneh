@extends('layouts.frontend')

@section('title', 'تسجيل علامة جديدة')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>تسجيل علامة جديدة</b>
        <span>إن كنت شركة أو علامة تجارية، ابدأ هنا</span>
      </div>
    </div>
  </header>
  <main class="content">
    <section class="section">
      <div class="card">
        <div class="body" style="padding:14px;">
          <p style="margin:0 0 10px;color:#6b7280">للبدء، أنشئ حساباً ثم قدّم طلب اعتماد علامتك التجارية. سيقوم فريقنا بمراجعة الطلب سريعاً.</p>
          <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a class="btn" href="{{ route('register') }}">إنشاء حساب</a>
            <a class="chip" href="{{ route('brands.index') }}">استعراض العلامات</a>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection
