@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">المعاملات المالية</h2>
        <div class="flex items-center gap-2">
            <x-ui.btn variant="primary" size="sm">تصدير</x-ui.btn>
        </div>
    </div>

    <x-ui.table :headers="[['label'=>'#'],['label'=>'النوع'],['label'=>'المبلغ'],['label'=>'العملة'],['label'=>'الحالة'],['label'=>'التاريخ'],['label'=>'']]" zebra sticky>
        @forelse(($transactions ?? []) as $t)
        <tr>
            <td class="whitespace-nowrap">{{ $t->id }}</td>
            <td class="whitespace-nowrap">{{ $t->type }}</td>
            <td class="text-right tabular-nums">{{ number_format($t->amount_cents/100, 2) }}</td>
            <td class="whitespace-nowrap">{{ $t->currency }}</td>
            <td class="whitespace-nowrap">
                <span class="badge @class([
                    'badge-info' => $t->status==='processing',
                    'badge-success' => $t->status==='paid',
                    'badge-warning' => $t->status==='pending',
                    'badge-error' => $t->status==='failed',
                ])">{{ $t->status }}</span>
            </td>
            <td class="whitespace-nowrap">{{ optional($t->created_at)->format('Y-m-d H:i') }}</td>
            <td class="whitespace-nowrap">
                <x-ui.btn variant="ghost" size="xs">عرض</x-ui.btn>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center py-8 theme-muted">لا توجد معاملات حتى الآن</td>
        </tr>
        @endforelse
    </x-ui.table>

    @isset($transactions)
    <div>
        {{ $transactions->links() }}
    </div>
    @endisset
</div>
@endsection
