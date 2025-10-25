@extends('layouts.frontend')

@section('title', 'طلباتي')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>طلباتي</b>
        <span>تتبع طلباتك</span>
      </div>
    </div>
  </header>

  <main class="content">
    @if($orders->isEmpty())
      <div class="section" style="text-align:center;color:#7a6b6b;padding:24px;">
        لا توجد طلبات حتى الآن
      </div>
    @else
      <section class="section">
        <div class="grid">
          @foreach($orders as $order)
            <article class="card">
              <div class="body">
                <div class="row" style="justify-content:space-between;align-items:center;">
                  <div>
                    <div class="name">طلب رقم #{{ $order->id }}</div>
                    <div class="meta">من: {{ optional($order->seller)->name }}</div>
                    <div class="meta">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                  </div>
                  <div class="text-right">
                    <div class="price">{{ number_format($order->total_cents, 0, '.', ',') }} {{ $order->currency }}</div>
                    <div class="meta">
                      <span class="badge @class([
                        'badge-warning' => $order->status==='pending',
                        'badge-info' => $order->status==='confirmed',
                        'badge-accent' => $order->status==='shipped',
                        'badge-success' => $order->status==='delivered',
                        'badge-error' => $order->status==='cancelled',
                      ])">
                        @switch($order->status)
                          @case('pending') معلق @break
                          @case('confirmed') مؤكد @break
                          @case('shipped') تم الشحن @break
                          @case('delivered') تم التسليم @break
                          @case('cancelled') ملغي @break
                          @default {{ $order->status }}
                        @endswitch
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="row" style="margin-top:12px;">
                  <div class="meta">
                    {{ $order->items->count() }} منتج
                    @if($order->payment)
                      | الدفع: 
                      <span class="badge @class([
                        'badge-warning' => $order->payment->status==='pending',
                        'badge-success' => $order->payment->status==='paid',
                        'badge-error' => $order->payment->status==='failed',
                        'badge-info' => $order->payment->status==='refunded',
                      ])">
                        @switch($order->payment->status)
                          @case('pending') معلق @break
                          @case('paid') مدفوع @break
                          @case('failed') فشل @break
                          @case('refunded') مسترد @break
                          @default {{ $order->payment->status }}
                        @endswitch
                      </span>
                    @endif
                  </div>
                  <a href="{{ route('orders.show', $order) }}" class="btn btn-sm">عرض التفاصيل</a>
                </div>
              </div>
            </article>
          @endforeach
        </div>
        
        <div style="margin-top:20px;">
          {{ $orders->links() }}
        </div>
      </section>
    @endif
  </main>
@endsection
