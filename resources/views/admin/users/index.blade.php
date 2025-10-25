@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold">المستخدمون</h2>
            <p class="text-sm theme-muted">إدارة المستخدمين العاديين (المشترين والبائعين)</p>
        </div>
        <x-ui.btn variant="primary" size="sm" :href="route('admin.users.create')">إضافة مستخدم</x-ui.btn>
    </div>
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" id="select-all-users" class="checkbox checkbox-sm rounded-none checkbox-primary focus:ring-2 focus:ring-offset-2 focus:ring-primary/60 transition duration-150">
                تحديد الكل
            </label>
        </div>
        <form action="{{ route('admin.users.bulk-destroy') }}" method="POST" id="bulk-delete-users">
            @csrf
            @method('DELETE')
            <x-ui.btn variant="danger" size="sm" type="submit" id="bulk-delete-btn-users" disabled>حذف المحدد</x-ui.btn>
        </form>
    </div>

    <x-ui.table :headers="[['label'=>'تحديد'],['label'=>'#'],['label'=>'الاسم'],['label'=>'البريد'],['label'=>'الهاتف'],['label'=>'الدور'],['label'=>'إجراءات']]" zebra sticky>
        @forelse($users as $user)
        <tr>
            <td class="whitespace-nowrap">
                @if(auth()->id() !== $user->id)
                <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="row-check-users checkbox checkbox-sm rounded-none checkbox-primary focus:ring-2 focus:ring-offset-2 focus:ring-primary/60 transition duration-150">
                @endif
            </td>
            <td class="whitespace-nowrap">{{ $user->id }}</td>
            <td class="whitespace-nowrap">{{ $user->name }}</td>
            <td class="whitespace-nowrap">{{ $user->email ?? 'غير محدد' }}</td>
            <td class="whitespace-nowrap">{{ $user->phone ?? 'غير محدد' }}</td>
            <td class="whitespace-nowrap">
                @if($user->role === 'seller')
                    <span class="badge badge-secondary">بائع</span>
                @else
                    <span class="badge badge-ghost">مشتري</span>
                @endif
            </td>
            <td class="whitespace-nowrap">
                <div class="flex items-center gap-2">
                    <x-ui.btn variant="ghost" size="xs" :href="route('admin.users.edit',$user)">تعديل</x-ui.btn>
                    @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy',$user) }}" method="POST" class="inline" onsubmit="return confirm('حذف المستخدم؟');">
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
            <td colspan="7" class="text-center py-8 theme-muted">لا يوجد مستخدمون حتى الآن</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div>
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
(function(init){
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})(function() {
    const selectAll = document.getElementById('select-all-users');
    const checks = Array.from(document.querySelectorAll('.row-check-users'));
    const submitBtn = document.getElementById('bulk-delete-btn-users');
    const form = document.getElementById('bulk-delete-users');

    function refreshState() {
        const anyChecked = checks.some(c => c.checked);
        submitBtn.disabled = !anyChecked;
        if (checks.length) {
            selectAll.checked = checks.length && checks.every(c => c.checked);
            selectAll.indeterminate = !selectAll.checked && anyChecked;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', () => {
            checks.forEach(c => c.checked = selectAll.checked);
            refreshState();
        });
    }
    checks.forEach(c => c.addEventListener('change', refreshState));
    refreshState();

    if (form) {
        form.addEventListener('submit', function(e){
            // remove old hidden inputs
            Array.from(form.querySelectorAll('input[name="ids[]"]')).forEach(el => el.remove());
            // append selected ids
            const selected = checks.filter(c => c.checked).map(c => c.value);
            if (selected.length === 0) {
                e.preventDefault();
                return false;
            }
            selected.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });
        });
    }
});
</script>
@endpush
