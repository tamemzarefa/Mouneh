@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">التصنيفات</h2>
        <x-ui.btn variant="primary" size="sm" :href="route('admin.categories.create')">إضافة تصنيف</x-ui.btn>
    </div>
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" id="select-all-categories" class="checkbox checkbox-sm rounded-none checkbox-primary focus:ring-2 focus:ring-offset-2 focus:ring-primary/60 transition duration-150">
                تحديد الكل
            </label>
        </div>
        <form action="{{ route('admin.categories.bulk-destroy') }}" method="POST" id="bulk-delete-categories">
            @csrf
            @method('DELETE')
            <x-ui.btn variant="danger" size="sm" type="submit" id="bulk-delete-btn-categories" disabled>حذف المحدد</x-ui.btn>
        </form>
    </div>

    <x-ui.table :headers="[['label'=>'تحديد'],['label'=>'#'],['label'=>'المعرف'],['label'=>'الصورة'],['label'=>'الاسم (AR)'],['label'=>'الأب'],['label'=>'Slug'],['label'=>'']]" zebra sticky>
        @foreach($categories as $cat)
        <tr>
            <td>
                <input type="checkbox" name="ids[]" value="{{ $cat->id }}" class="row-check-categories checkbox checkbox-sm rounded-none checkbox-primary focus:ring-2 focus:ring-offset-2 focus:ring-primary/60 transition duration-150">
            </td>
            <td>{{ $loop->iteration + ($categories->currentPage()-1)*$categories->perPage() }}</td>
            <td>{{ $cat->id }}</td>
            <td class="whitespace-nowrap">
                @php($img = $cat->getFirstMediaUrl('image') ?: ($cat->image_url ?? ''))
                @if($img)
                    <img src="{{ $img }}" alt="" class="w-10 h-10 object-cover rounded border" />
                @else
                    -
                @endif
            </td>
            <td>{{ $cat->name_ar }}</td>
            <td>{{ optional($cat->parent)->name_ar ?: '-' }}</td>
            <td>{{ $cat->slug }}</td>
            <td class="whitespace-nowrap">
                <x-ui.btn variant="ghost" size="xs" :href="route('admin.categories.edit',$cat)">تعديل</x-ui.btn>
                <form action="{{ route('admin.categories.destroy',$cat) }}" method="POST" class="inline" onsubmit="return confirm('حذف التصنيف؟');">
                    @csrf
                    @method('DELETE')
                    <x-ui.btn variant="ghost" size="xs" class="ml-2" type="submit">حذف</x-ui.btn>
                </form>
            </td>
        </tr>
        @endforeach
    </x-ui.table>

    <div>
        {{ $categories->links() }}
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
    const selectAll = document.getElementById('select-all-categories');
    const checks = Array.from(document.querySelectorAll('.row-check-categories'));
    const submitBtn = document.getElementById('bulk-delete-btn-categories');
    const form = document.getElementById('bulk-delete-categories');

    function refreshState() {
        const anyChecked = checks.some(c => c.checked);
        submitBtn.disabled = !anyChecked;
        if (checks.length) {
            selectAll.checked = checks.every(c => c.checked);
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
