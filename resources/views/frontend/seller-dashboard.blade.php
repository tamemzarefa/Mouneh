@extends('layouts.frontend')

@section('title', 'لوحة تحكم البائع')

@section('content')
  <header class="header">
    <div class="brand">
      <div class="title">
        <b>لوحة تحكم البائع</b>
        <span>إدارة منتجاتك</span>
      </div>
    </div>
  </header>

  <main class="content">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="card bg-primary text-primary-content">
        <div class="card-body">
          <h3 class="card-title">المنتجات المعتمدة</h3>
          <div class="text-2xl font-bold">{{ $approvedProducts }}</div>
        </div>
      </div>
      
      <div class="card bg-warning text-warning-content">
        <div class="card-body">
          <h3 class="card-title">قيد المراجعة</h3>
          <div class="text-2xl font-bold">{{ $pendingProducts }}</div>
        </div>
      </div>
      
      <div class="card bg-error text-error-content">
        <div class="card-body">
          <h3 class="card-title">مرفوضة</h3>
          <div class="text-2xl font-bold">{{ $rejectedProducts }}</div>
        </div>
      </div>
    </div>

    <!-- Recent Approvals -->
    @if($recentApprovals->isNotEmpty())
      <section class="section">
        <h3>الموافقات الأخيرة</h3>
        <div class="space-y-3">
          @foreach($recentApprovals as $product)
            <div class="card bg-success text-success-content">
              <div class="card-body p-4">
                <div class="flex items-center justify-between">
                  <div>
                    <h4 class="font-semibold">{{ $product->title_ar }}</h4>
                    <p class="text-sm opacity-80">تمت الموافقة في {{ $product->approved_at->format('Y-m-d H:i') }}</p>
                    @if($product->approver)
                      <p class="text-xs opacity-70">بواسطة: {{ $product->approver->name }}</p>
                    @endif
                  </div>
                  <div class="text-right">
                    <div class="text-lg font-bold">{{ number_format($product->price_cents, 0, '.', ',') }} ل.س</div>
                    <span class="badge badge-success">معتمد</span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </section>
    @endif

    <!-- Product Management -->
    <section class="section">
      <div class="flex items-center justify-between mb-4">
        <h3>منتجاتي</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          إضافة منتج جديد
        </a>
      </div>
      
      <div class="space-y-3">
        @foreach($myProducts as $product)
          <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-4">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <h4 class="font-semibold text-lg">{{ $product->title_ar }}</h4>
                  <p class="text-sm text-base-content/70">{{ number_format($product->price_cents, 0, '.', ',') }} ل.س</p>
                  <p class="text-xs text-base-content/50">تم الإنشاء: {{ $product->created_at->format('Y-m-d') }}</p>
                </div>
                
                <div class="text-right">
                  @switch($product->status)
                    @case('approved')
                      <span class="badge badge-success">معتمد</span>
                      @if($product->approved_at)
                        <p class="text-xs text-base-content/50 mt-1">في {{ $product->approved_at->format('Y-m-d') }}</p>
                      @endif
                      @break
                    @case('pending')
                      <span class="badge badge-warning">قيد المراجعة</span>
                      @break
                    @case('rejected')
                      <span class="badge badge-error">مرفوض</span>
                      @if($product->rejection_reason)
                        <p class="text-xs text-base-content/50 mt-1">{{ Str::limit($product->rejection_reason, 50) }}</p>
                      @endif
                      @break
                    @default
                      <span class="badge">غير محدد</span>
                  @endswitch
                </div>
              </div>
              
              @if($product->status === 'rejected' && $product->rejection_reason)
                <div class="mt-3 p-3 bg-error/10 rounded-lg">
                  <h5 class="font-medium text-error mb-1">سبب الرفض:</h5>
                  <p class="text-sm text-base-content/70">{{ $product->rejection_reason }}</p>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </section>
  </main>
@endsection

