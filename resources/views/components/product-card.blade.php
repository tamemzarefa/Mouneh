@props(['product'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="relative">
        @if($product->images && $product->images->count() > 0)
            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
        
        @if($product->is_featured)
            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                مميز
            </div>
        @endif
    </div>
    
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
            {{ $product->name }}
        </h3>
        
        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
            {{ Str::limit($product->description, 80) }}
        </p>
        
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center">
                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <span class="text-sm text-gray-600">
                    {{ number_format($product->reviews->avg('rating') ?? 0, 1) }}
                    ({{ $product->reviews->count() }})
                </span>
            </div>
            
            <div class="text-right">
                <span class="text-lg font-bold text-green-600">
                    {{ number_format($product->price) }} ل.س
                </span>
            </div>
        </div>
        
        <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>{{ $product->seller->name ?? 'بائع غير معروف' }}</span>
            </div>
            
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                عرض التفاصيل
            </button>
        </div>
    </div>
</div>
