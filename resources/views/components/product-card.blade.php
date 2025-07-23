@props([
    'product',
    'showImage' => true,
    'showPrice' => true,
    'showBadges' => true,
    'showCategory' => false,
    'aspectRatio' => 'aspect-square',
    'imageSize' => 'h-64',
])

<div class="group relative bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
    {{-- Product Image --}}
    @if($showImage)
        <a href="{{ route('product.show', $product->slug) }}" class="block">
            <div class="{{ $aspectRatio }} bg-gray-50 relative overflow-hidden">
                <img
                        src="{{ $product->images->first()->url ?? asset('images/placeholder.jpg') }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 {{ $imageSize }}"
                        loading="lazy"
                />

                {{-- Badges --}}
                @if($showBadges)
                    <div class="absolute top-3 left-3 flex flex-col gap-2">
                        @if($product->price < $product->price_original)
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                Sale
                            </span>
                        @endif
                        @if($product->stock <= 0)
                            <span class="bg-gray-800 text-white text-xs font-bold px-2 py-1 rounded-full">
                                Out of Stock
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </a>
    @endif

    {{-- Product Content --}}
    <div class="p-4">
        @if($showCategory && $product->morphCategories->isNotEmpty())
            <div class="mb-1">
                <a href="{{ route('category.show', $product->morphCategories->first()->slug) }}"
                   class="text-xs font-medium text-gray-500 hover:text-primary transition-colors">
                    {{ $product->morphCategories->first()->name }}
                </a>
            </div>
        @endif

        <h3 class="text-lg font-semibold text-gray-900 mb-2 truncate">
            <a href="{{ route('product.show', $product->slug) }}" class="hover:text-primary transition-colors">
                {{ $product->name }}
            </a>
        </h3>

        @if($showPrice)
            <div class="flex items-center gap-2">
                @if($product->price < $product->price_original)
                    <span class="text-lg font-bold text-primary">
                        &euro;{{ number_format($product->price, 2, ',', '.') }}
                    </span>
                    <span class="text-sm text-gray-500 line-through">
                        &euro;{{ number_format($product->price_original, 2, ',', '.') }}
                    </span>
                @else
                    <span class="text-lg font-bold text-primary">
                        &euro;{{ number_format($product->price, 2, ',', '.') }}
                    </span>
                @endif
            </div>
        @endif
    </div>
</div>