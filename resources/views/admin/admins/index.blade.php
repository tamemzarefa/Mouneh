@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">المديرون</h2>
        <x-ui.btn variant="primary" size="sm" :href="route('admin.admins.create')">إضافة مدير</x-ui.btn>
    </div>

    <x-ui.table :headers="[['label'=>'#'],['label'=>'الاسم'],['label'=>'البريد'],['label'=>'الهاتف'],['label'=>'تاريخ الإنشاء'],['label'=>'إجراءات']]" zebra sticky>
        @forelse($admins as $admin)
        <tr>
            <td class="whitespace-nowrap">{{ $admin->id }}</td>
            <td class="whitespace-nowrap">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="font-medium">{{ $admin->name }}</span>
                    @if($admin->id === auth()->id())
                        <span class="badge badge-primary badge-sm">أنت</span>
                    @endif
                </div>
            </td>
            <td class="whitespace-nowrap">{{ $admin->email }}</td>
            <td class="whitespace-nowrap">{{ $admin->phone ?? 'غير محدد' }}</td>
            <td class="whitespace-nowrap">{{ $admin->created_at->format('Y-m-d') }}</td>
            <td class="whitespace-nowrap">
                <div class="flex items-center gap-2">
                    <x-ui.btn variant="ghost" size="xs" :href="route('admin.admins.edit',$admin)">تعديل</x-ui.btn>
                    @if($admin->id !== auth()->id())
                        <form action="{{ route('admin.admins.destroy',$admin) }}" method="POST" class="inline" onsubmit="return confirm('حذف المدير؟');">
                            @csrf
                            @method('DELETE')
                            <x-ui.btn variant="ghost" size="xs" type="submit">حذف</x-ui.btn>
                        </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-8 theme-muted">لا يوجد مديرون حتى الآن</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div>
        {{ $admins->links() }}
    </div>
</div>
@endsection
