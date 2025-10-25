@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">الطلبات</h2>
    </div>

    <x-ui.table :headers="[['label'=>'#'],['label'=>'المشتري'],['label'=>'البائع'],['label'=>'الحالة'],['label'=>'الإجمالي'],['label'=>'العملة'],['label'=>'تاريخ الإنشاء'],['label'=>'']]" zebra sticky>
        @forelse($orders as $order)
        <tr>
            <td class="whitespace-nowrap">{{ $order->id }}</td>
            <td class="whitespace-nowrap">{{ optional($order->buyer)->name }}</td>
            <td class="whitespace-nowrap">{{ optional($order->seller)->name }}</td>
            <td class="whitespace-nowrap">
                <span class="badge @class([
                    'badge-warning' => $order->status==='pending',
                    'badge-info' => $order->status==='confirmed',
                    'badge-accent' => $order->status==='shipped',
                    'badge-success' => $order->status==='delivered',
                    'badge-error' => $order->status==='cancelled',
                ])">{{ $order->status }}</span>
            </td>
            <td class="text-right tabular-nums">{{ number_format($order->total_cents/100, 2) }}</td>
            <td class="whitespace-nowrap">{{ $order->currency }}</td>
            <td class="whitespace-nowrap">{{ $order->created_at->format('Y-m-d H:i') }}</td>
            <td class="whitespace-nowrap">
                <x-ui.btn variant="ghost" size="xs" :href="route('admin.orders.show',$order)">عرض</x-ui.btn>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center py-8 theme-muted">لا توجد طلبات حتى الآن</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div>
        {{ $orders->links() }}
    </div>
</div>
@endsection

