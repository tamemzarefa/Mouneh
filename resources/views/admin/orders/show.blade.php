@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">طلب رقم #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">رجوع للقائمة</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 space-y-4">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-sm text-base-content/70">الحالة</div>
                            <div>
                                <span class="badge @class([
                                    'badge-warning' => $order->status==='pending',
                                    'badge-info' => $order->status==='confirmed',
                                    'badge-accent' => $order->status==='shipped',
                                    'badge-success' => $order->status==='delivered',
                                    'badge-error' => $order->status==='cancelled',
                                ])">{{ $order->status }}</span>
                            </div>
                        </div>
                        <div class="text-sm text-base-content/70">
                            {{ $order->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                    
                    <!-- Order Status Management -->
                    <div class="mt-4">
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-2">
                            @csrf
                            <div>
                                <label class="label">
                                    <span class="label-text">الحالة التالية</span>
                                </label>
                                <select name="status" class="select select-bordered select-sm w-full">
                                    @foreach($workflow['next'] as $nextStatus)
                                        @switch($nextStatus)
                                            @case('pending') <option value="pending">معلق</option> @break
                                            @case('confirmed') <option value="confirmed">مؤكد</option> @break
                                            @case('shipped') <option value="shipped">تم الشحن</option> @break
                                            @case('delivered') <option value="delivered">تم التسليم</option> @break
                                            @case('cancelled') <option value="cancelled">ملغي</option> @break
                                        @endswitch
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="label">
                                    <span class="label-text">ملاحظات (اختياري)</span>
                                </label>
                                <textarea name="notes" class="textarea textarea-bordered textarea-sm w-full" 
                                          placeholder="أضف ملاحظة حول تغيير الحالة..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-full">تحديث الحالة</button>
                        </form>
                        
                        @if($workflow['next'] === [])
                            <div class="alert alert-info mt-2">
                                <span>هذا الطلب في حالته النهائية</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-lg">المنتجات</h3>
                    <div class="overflow-x-auto">
                        <table class="table text-right">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المنتج</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ optional($item->product)->title_ar }}</td>
                                    <td>{{ number_format($item->price_cents/100, 2) }} {{ $order->currency }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format(($item->price_cents*$item->quantity)/100, 2) }} {{ $order->currency }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Status History -->
            @if($order->statusHistory->isNotEmpty())
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h3 class="card-title text-lg">تاريخ تغيير الحالة</h3>
                        <div class="space-y-3">
                            @foreach($order->statusHistory as $status)
                                <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                                    <div>
                                        <div class="font-medium">
                                            @switch($status->status)
                                                @case('pending') معلق @break
                                                @case('confirmed') مؤكد @break
                                                @case('shipped') تم الشحن @break
                                                @case('delivered') تم التسليم @break
                                                @case('cancelled') ملغي @break
                                                @default {{ $status->status }}
                                            @endswitch
                                        </div>
                                        @if($status->notes)
                                            <div class="text-sm text-base-content/70">{{ $status->notes }}</div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm">{{ $status->created_at->format('Y-m-d H:i') }}</div>
                                        @if($status->updatedBy)
                                            <div class="text-xs text-base-content/50">{{ $status->updatedBy->name }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-4">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-lg">الأطراف</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="text-base-content/70">المشتري</div>
                            <div>{{ optional($order->buyer)->name }}</div>
                        </div>
                        <div>
                            <div class="text-base-content/70">البائع</div>
                            <div>{{ optional($order->seller)->name }}</div>
                        </div>
                        <div class="col-span-2">
                            <div class="text-base-content/70">العنوان</div>
                            <div>{{ optional($order->address)->address_line ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-lg">الفاتورة</h3>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between"><span class="text-base-content/70">الإجمالي الفرعي</span><span>{{ number_format($order->subtotal_cents/100, 2) }} {{ $order->currency }}</span></div>
                        <div class="flex justify-between"><span class="text-base-content/70">الشحن</span><span>{{ number_format($order->shipping_cents/100, 2) }} {{ $order->currency }}</span></div>
                        <div class="flex justify-between"><span class="text-base-content/70">الخصم</span><span>-{{ number_format($order->discount_cents/100, 2) }} {{ $order->currency }}</span></div>
                        <div class="divider my-2"></div>
                        <div class="flex justify-between font-bold"><span>الإجمالي</span><span>{{ number_format($order->total_cents/100, 2) }} {{ $order->currency }}</span></div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-lg">الدفع</h3>
                    @if($order->payment)
                        <div class="text-sm space-y-1">
                            <div class="flex justify-between"><span class="text-base-content/70">الطريقة</span><span>{{ $order->payment->provider }}</span></div>
                            <div class="flex justify-between">
                                <span class="text-base-content/70">الحالة</span>
                                <span class="badge @class([
                                    'badge-warning' => $order->payment->status==='pending',
                                    'badge-success' => $order->payment->status==='paid',
                                    'badge-error' => $order->payment->status==='failed',
                                    'badge-info' => $order->payment->status==='refunded',
                                ])">{{ $order->payment->status }}</span>
                            </div>
                            @if($order->payment->reference)
                                <div class="flex justify-between"><span class="text-base-content/70">المرجع</span><span>{{ $order->payment->reference }}</span></div>
                            @endif
                            @if($order->payment->paid_at)
                                <div class="flex justify-between"><span class="text-base-content/70">تاريخ الدفع</span><span>{{ $order->payment->paid_at->format('Y-m-d H:i') }}</span></div>
                            @endif
                        </div>
                        
                        <!-- Payment Status Management -->
                        <div class="mt-4">
                            <form method="POST" action="{{ route('admin.orders.payment', $order) }}" class="space-y-2">
                                @csrf
                                <select name="payment_status" class="select select-bordered select-sm w-full">
                                    <option value="pending" {{ $order->payment->status === 'pending' ? 'selected' : '' }}>معلق</option>
                                    <option value="paid" {{ $order->payment->status === 'paid' ? 'selected' : '' }}>مدفوع</option>
                                    <option value="failed" {{ $order->payment->status === 'failed' ? 'selected' : '' }}>فشل</option>
                                    <option value="refunded" {{ $order->payment->status === 'refunded' ? 'selected' : '' }}>مسترد</option>
                                </select>
                                <input type="text" name="reference" placeholder="مرجع الدفع (اختياري)" 
                                       value="{{ $order->payment->reference }}" 
                                       class="input input-bordered input-sm w-full">
                                <button type="submit" class="btn btn-primary btn-sm w-full">تحديث الدفع</button>
                            </form>
                        </div>
                    @else
                        <div class="text-sm text-base-content/70">لا توجد معلومات دفع</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
