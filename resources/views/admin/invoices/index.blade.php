@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">الفواتير</h2>
        <div class="flex items-center gap-2">
            <x-ui.btn variant="primary" size="sm">تصدير</x-ui.btn>
        </div>
    </div>

    <x-ui.table :headers="[['label'=>'#'],['label'=>'العميل'],['label'=>'الإجمالي'],['label'=>'العملة'],['label'=>'الحالة'],['label'=>'التاريخ'],['label'=>'']]" zebra sticky>
        @forelse(($invoices ?? []) as $inv)
        <tr>
            <td class="whitespace-nowrap">{{ $inv->id }}</td>
            <td class="whitespace-nowrap">{{ optional($inv->customer)->name ?? '-' }}</td>
            <td class="text-right tabular-nums">{{ number_format($inv->total_cents/100, 2) }}</td>
            <td class="whitespace-nowrap">{{ $inv->currency }}</td>
            <td class="whitespace-nowrap">
                <span class="badge @class([
                    'badge-info' => $inv->status==='issued',
                    'badge-success' => $inv->status==='paid',
                    'badge-warning' => $inv->status==='overdue',
                    'badge-error' => $inv->status==='void',
                ])">{{ $inv->status }}</span>
            </td>
            <td class="whitespace-nowrap">{{ optional($inv->created_at)->format('Y-m-d') }}</td>
            <td class="whitespace-nowrap">
                <x-ui.btn variant="ghost" size="xs">عرض</x-ui.btn>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center py-8 theme-muted">لا توجد فواتير حتى الآن</td>
        </tr>
        @endforelse
    </x-ui.table>

    @isset($invoices)
    <div>
        {{ $invoices->links() }}
    </div>
    @endisset
</div>
@endsection
