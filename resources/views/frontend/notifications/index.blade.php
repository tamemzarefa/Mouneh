@extends('layouts.frontend')

@section('title', 'الإشعارات')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>الإشعارات</b>
        <span>آخر التحديثات</span>
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
    <section class="section">
      <div class="flex items-center justify-between mb-3">
        <h3>الكل</h3>
        <form method="POST" action="{{ route('notifications.read-all') }}">
          @csrf
          <button class="btn btn-primary btn-sm" type="submit">تحديد الكل كمقروء</button>
        </form>
      </div>

      @if($notifications->isEmpty())
        <div class="card bg-base-200">
          <div class="card-body text-center py-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 mx-auto text-base-content/30 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.172V11a6 6 0 10-12 0v3.172a2 2 0 01-.6 1.428L4 17h5"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v1a3 3 0 006 0v-1"/>
            </svg>
            <div class="text-base-content/70">لا توجد إشعارات حالياً</div>
          </div>
        </div>
      @else
        <div class="space-y-3">
          @foreach($notifications as $n)
            @php $data = $n->data; @endphp
            <div class="card border {{ $n->read_at ? 'border-base-300' : 'border-primary/40' }}">
              <div class="card-body p-4 flex items-start gap-3">
                <div class="shrink-0 inline-flex h-9 w-9 items-center justify-center rounded-full {{ $n->read_at ? 'bg-base-200 text-base-content/60' : 'bg-primary/10 text-primary' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.172V11a6 6 0 10-12 0v3.172a2 2 0 01-.6 1.428L4 17h5"/>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium">
                    {{ $data['message'] ?? Str::headline(str_replace('_',' ', $data['type'] ?? 'إشعار')) }}
                  </div>
                  <div class="text-xs text-base-content/60 mt-1">
                    @if(isset($data['order_id']))
                      طلب رقم #{{ $data['order_id'] }}
                    @endif
                  </div>
                </div>
                <div class="text-xs text-base-content/50 whitespace-nowrap">
                  {{ optional($n->created_at)->diffForHumans() }}
                </div>
                @if(!$n->read_at)
                <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                  @csrf
                  <button class="btn btn-ghost btn-xs" type="submit">تم</button>
                </form>
                @endif
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-4">
          {{ $notifications->links() }}
        </div>
      @endif
    </section>
  </main>
@endsection
