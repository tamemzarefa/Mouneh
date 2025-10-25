@extends('layouts.frontend')

@section('title', 'إضافة عنوان')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>إضافة عنوان</b>
        <span>املأ معلومات التوصيل</span>
      </div>
    </div>
  </header>

  <main class="content">
    <form method="POST" action="{{ route('addresses.store') }}" class="section" style="display:grid;gap:12px;">
      @csrf
      <input name="label" placeholder="اسم العنوان (اختياري)" style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
      <input name="recipient_name" placeholder="اسم المستلم" style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
      <input name="phone" placeholder="رقم الهاتف" style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
      <input name="line1" placeholder="العنوان" required style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
      <input name="line2" placeholder="تفاصيل إضافية (اختياري)" style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
      <input name="city" placeholder="المدينة" style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
      <input name="region" placeholder="المنطقة" style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
      <input name="postal_code" placeholder="الرمز البريدي (اختياري)" style="padding:12px;border-radius:12px;border:1px solid #f0e6e5;" />
      <label style="display:flex;align-items:center;gap:8px;font-size:14px;color:#3a2a2a;">
        <input type="checkbox" name="is_default" value="1" /> اجعله العنوان الافتراضي
      </label>
      <button class="btn" type="submit" style="padding:12px 10px;border-radius:12px;">حفظ</button>
    </form>
  </main>
@endsection
