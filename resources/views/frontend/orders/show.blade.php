@extends('layouts.frontend')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>طلب رقم #{{ $order->id }}</b>
        <span>تفاصيل الطلب</span>
      </div>
    </div>
    <div class="actions">
      <a href="{{ route('orders.index') }}" class="btn btn-ghost btn-sm">رجوع للطلبات</a>
    </div>
  </header>

  <main class="content">
    <div class="grid" style="grid-template-columns: 1fr 300px; gap: 20px;">
      <div class="space-y-4">
        <!-- Order Status -->
        <section class="section">
          <div class="card">
            <div class="body">
              <h3>حالة الطلب</h3>
              <div class="row" style="align-items:center;gap:12px;">
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
                <span class="meta">{{ $order->created_at->format('Y-m-d H:i') }}</span>
              </div>
            </div>
          </div>
        </section>

        <!-- Order Items -->
        <section class="section">
          <div class="card">
            <div class="body">
              <h3>المنتجات</h3>
              <div class="space-y-3">
                @foreach($order->items as $item)
                  <div class="row" style="align-items:center;gap:12px;padding:12px;background:#f8f9fa;border-radius:8px;">
                    <div style="flex:1;">
                      <div class="name">{{ optional($item->product)->title_ar }}</div>
                      <div class="meta">الكمية: {{ $item->quantity }}</div>
                    </div>
                    <div class="text-right">
                      <div class="price">{{ number_format($item->unit_price_cents, 0, '.', ',') }} {{ $order->currency }}</div>
                      <div class="meta">المجموع: {{ number_format($item->unit_price_cents * $item->quantity, 0, '.', ',') }} {{ $order->currency }}</div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </section>

        <!-- Delivery Address -->
        @if($order->address)
          <section class="section">
            <div class="card">
              <div class="body">
                <h3>عنوان التوصيل</h3>
                <div class="meta">
                  {{ $order->address->address_line }}<br>
                  {{ $order->address->city }}, {{ $order->address->state }}<br>
                  {{ $order->address->postal_code }}
                </div>
              </div>
            </div>
          </section>
        @endif
      </div>

      <div class="space-y-4">
        <!-- Seller Info -->
        <section class="section">
          <div class="card">
            <div class="body">
              <h3>البائع</h3>
              <div class="meta">{{ optional($order->seller)->name }}</div>
              @if($order->seller && $order->seller->email)
                <div class="meta">{{ $order->seller->email }}</div>
              @endif
            </div>
          </div>
        </section>

        <!-- Order Summary -->
        <section class="section">
          <div class="card">
            <div class="body">
              <h3>ملخص الطلب</h3>
              <div class="space-y-2">
                <div class="row" style="justify-content:space-between;">
                  <span>الإجمالي الفرعي</span>
                  <span>{{ number_format($order->subtotal_cents, 0, '.', ',') }} {{ $order->currency }}</span>
                </div>
                <div class="row" style="justify-content:space-between;">
                  <span>الشحن</span>
                  <span>{{ number_format($order->shipping_cents, 0, '.', ',') }} {{ $order->currency }}</span>
                </div>
                <div class="row" style="justify-content:space-between;">
                  <span>الخصم</span>
                  <span>-{{ number_format($order->discount_cents, 0, '.', ',') }} {{ $order->currency }}</span>
                </div>
                <hr style="margin:8px 0;">
                <div class="row" style="justify-content:space-between;font-weight:bold;">
                  <span>الإجمالي</span>
                  <span class="price">{{ number_format($order->total_cents, 0, '.', ',') }} {{ $order->currency }}</span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Payment Info -->
        @if($order->payment)
          <section class="section">
            <div class="card">
              <div class="body">
                <h3>معلومات الدفع</h3>
                <div class="space-y-2">
                  <div class="row" style="justify-content:space-between;">
                    <span>الطريقة</span>
                    <span>{{ $order->payment->provider }}</span>
                  </div>
                  <div class="row" style="justify-content:space-between;">
                    <span>الحالة</span>
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
                  </div>
                  @if($order->payment->reference)
                    <div class="row" style="justify-content:space-between;">
                      <span>المرجع</span>
                      <span class="meta">{{ $order->payment->reference }}</span>
                    </div>
                  @endif
                  @if($order->payment->paid_at)
                    <div class="row" style="justify-content:space-between;">
                      <span>تاريخ الدفع</span>
                      <span class="meta">{{ $order->payment->paid_at->format('Y-m-d H:i') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </section>
        @endif
      </div>
    </div>
  </main>
@endsection
