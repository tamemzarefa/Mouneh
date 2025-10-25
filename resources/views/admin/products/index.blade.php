@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">المنتجات</h2>
        <x-ui.btn variant="primary" size="sm" :href="route('admin.products.create')">إضافة منتج</x-ui.btn>
    </div>
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" id="select-all-products" class="checkbox checkbox-sm rounded-none">
                تحديد الكل
            </label>
        </div>
        <form action="{{ route('admin.products.bulk-destroy') }}" method="POST" id="bulk-delete-products">
            @csrf
            @method('DELETE')
            <x-ui.btn variant="danger" size="sm" type="submit" id="bulk-delete-btn-products" disabled>حذف المحدد</x-ui.btn>
        </form>
    </div>

    <!-- Bulk Actions Toolbar -->
    <div class="flex items-center justify-between bg-base-100 border theme-border rounded-md p-3 mb-3">
        <div class="font-semibold">إجراءات جماعية</div>
        <div class="flex gap-2">
            <button class="btn btn-success btn-sm" onclick="bulkApprove()">موافقة على المحدد</button>
            <button class="btn btn-error btn-sm" onclick="bulkReject()">رفض المحدد</button>
        </div>
    </div>

    <x-ui.table :headers="[['label'=>'تحديد'],['label'=>'#'],['label'=>'العنوان'],['label'=>'التصنيف'],['label'=>'البائع'],['label'=>'السعر'],['label'=>'الحالة'],['label'=>'إجراءات']]" zebra sticky>
        @forelse($products as $product)
        <tr>
            <td class="whitespace-nowrap">
                <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="row-check-products checkbox checkbox-sm rounded-none">
            </td>
            <td class="whitespace-nowrap">{{ $product->id }}</td>
            <td class="flex items-center gap-2">
                @if($product->thumb_url)
                    <img src="{{ $product->thumb_url }}" alt="" class="w-10 h-10 rounded object-cover border" />
                @endif
                <span>{{ $product->title_ar }}</span>
            </td>
            <td class="whitespace-nowrap">{{ optional($product->category)->name_ar }}</td>
            <td class="whitespace-nowrap">{{ optional($product->seller)->name }}</td>
            <td class="whitespace-nowrap text-right tabular-nums">{{ number_format($product->price_cents/100, 2) }} {{ $product->currency }}</td>
            <td class="whitespace-nowrap">
                <span class="{{ $product->status_badge_class }}" @if($product->status_badge_style) style="{{ $product->status_badge_style }}" @endif>
                    {{ $product->status_label_ar }}
                </span>
                @if(!$product->is_active)
                    <span class="badge" title="الحالة: معطل">معطل</span>
                @endif
            </td>
            <td class="whitespace-nowrap">
                <x-ui.btn variant="ghost" size="xs" :href="route('admin.products.edit',$product)">تعديل</x-ui.btn>
                <form action="{{ route('admin.products.destroy',$product) }}" method="POST" class="inline" onsubmit="return confirm('حذف المنتج؟');">
                    @csrf
                    @method('DELETE')
                    <x-ui.btn variant="ghost" size="xs" class="ml-2" type="submit">حذف</x-ui.btn>
                </form>
                @if(($product->status ?? null) === 'approved' && $product->is_active)
                    <x-ui.btn variant="ghost" size="xs" class="ml-2" :href="route('products.show', $product)" target="_blank">عرض</x-ui.btn>
                @else
                    <x-ui.btn variant="ghost" size="xs" class="ml-2" :href="route('admin.products.edit', $product)" target="_blank">عرض</x-ui.btn>
                @endif
                @if(($product->status ?? null) !== 'approved')
                    <button type="button" class="btn btn-success btn-xs ml-2" onclick="approveProduct('{{ route('admin.products.approve', $product) }}', '{{ $product->title_ar }}')">
                        موافقة
                    </button>
                @endif
                @if(($product->status ?? null) !== 'rejected')
                    <form action="{{ route('admin.products.reject',$product) }}" method="POST" class="inline" onsubmit="return confirm('رفض المنتج؟');">
                        @csrf
                        <input type="hidden" name="reason" value="">
                        <x-ui.btn variant="danger" size="xs" class="ml-2" type="submit">رفض</x-ui.btn>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center py-8 theme-muted">لا توجد منتجات حتى الآن</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div>
        {{ $products->links() }}
    </div>
</div>

 
@endsection

@push('scripts')
<script>
// Approve via confirm/prompt (unified UX)
function approveProduct(approveUrl, productTitle) {
    try {
        console.log('Approving product:', productTitle, 'URL:', approveUrl);
        
        const name = productTitle ? ` ${productTitle}` : '';
        if (!confirm(`هل أنت متأكد من الموافقة على المنتج:${name}؟`)) {
            return;
        }

        const notes = prompt('أدخل ملاحظات (اختياري):', '');
        if (notes === null) {
            return; // User cancelled
        }

        // Create form element
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = approveUrl;
        form.style.display = 'none';

        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Add notes if provided
        if (notes && notes.trim()) {
            const notesInput = document.createElement('input');
            notesInput.type = 'hidden';
            notesInput.name = 'notes';
            notesInput.value = notes.trim();
            form.appendChild(notesInput);
        }

        console.log('Submitting form to:', approveUrl);
        // Add form to body and submit
        document.body.appendChild(form);
        form.submit();
    } catch (e) {
        console.error('Error in approveProduct:', e);
        alert('حدث خطأ أثناء تنفيذ عملية الموافقة: ' + e.message);
    }
}

// Bulk Actions
function bulkApprove() {
    const checkedBoxes = document.querySelectorAll('input[type="checkbox"][name="ids[]"]:checked');
    if (checkedBoxes.length === 0) {
        alert('يرجى تحديد منتج واحد على الأقل');
        return;
    }
    
    if (confirm(`هل أنت متأكد من الموافقة على ${checkedBoxes.length} منتج؟`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.products.bulk-approve") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = checkbox.value;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

function bulkReject() {
    const checkedBoxes = document.querySelectorAll('input[type="checkbox"][name="ids[]"]:checked');
    if (checkedBoxes.length === 0) {
        alert('يرجى تحديد منتج واحد على الأقل');
        return;
    }
    
    if (confirm(`هل أنت متأكد من رفض ${checkedBoxes.length} منتج؟`)) {
        alert('ميزة الرفض الجماعي قيد التطوير');
    }
}

</script>
<script>
(function(init){
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})(function() {
    const selectAll = document.getElementById('select-all-products');
    const checks = Array.from(document.querySelectorAll('.row-check-products'));
    const submitBtn = document.getElementById('bulk-delete-btn-products');
    const form = document.getElementById('bulk-delete-products');

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
