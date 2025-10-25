@extends('layouts.frontend')

@section('title', 'تعديل الحساب')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>تعديل الحساب</b>
        <span>تحديث الاسم والبريد الإلكتروني</span>
      </div>
    </div>
  </header>

  <main class="content">
    <section class="section">
      <form method="POST" action="{{ route('profile.update') }}" style="display:grid;gap:12px;">
        @csrf
        @method('patch')
        <input name="name" value="{{ old('name', $user->name) }}" placeholder="الاسم" required style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="البريد الإلكتروني" required style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />

        @if ($errors->any())
          <div class="card" style="padding:10px;border-radius:12px;border:1px solid #f0e6e5;background:#fff;">
            <ul style="margin:0;padding-inline-start:18px;">
              @foreach ($errors->all() as $error)
                <li style="font-size:13px;color:#7a2e2e;">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <button class="btn" type="submit" style="padding:12px 10px;border-radius:12px;">حفظ التغييرات</button>
      </form>
    </section>

    <section class="section">
      <a class="tab" href="{{ route('account.index') }}" style="display:inline-flex;gap:8px;text-decoration:none;">
        ← رجوع إلى حسابي
      </a>
    </section>
  </main>
@endsection
