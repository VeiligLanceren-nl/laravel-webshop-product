@props([
    'product',
    'showGallery' => true,
    'showDetails' => true,
    'showVariants' => true,
    'showDescription' => true,
    'showRelated' => true,
    'relatedProducts' => [],
    'maxRelated' => 4,
    'enableBreadcrumbs' => true,
    'linkHome' => true,
    'linkCategory' => true,
])

<section class="py-8 md:py-12">
    <div class="container mx-auto px-4">
        {{-- Breadcrumbs --}}
        @if($enableBreadcrumbs)
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li>
                        @if($linkHome)
                            <a href="{{ route('home') }}" class="hover:text-blue-400">@lang('webshop-product::webshop-product.home')</a>
                        @else
                            @lang('webshop-product::webshop-product.home')
                                @endif
                    </li>
                    <li>/</li>
                    @if($product->morphCategories->isNotEmpty())
                        <li>
                            @if($linkCategory)
                                <a href="{{ route('category.show', $product->morphCategories->first()->slug) }}" class="hover:text-blue-400">
                                    {{ $product->morphCategories->first()->name }}
                                </a>
                            @else
                                {{ $product->morphCategories->first()->name }}
                            @endif
                        </li>
                        <li>/</li>
                    @endif
                    <li class="text-gray-900 font-medium">{{ $product->name }}</li>
                </ol>
            </nav>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            {{-- Gallery --}}
            @if($showGallery)
                <div x-data="{
                    activeImage: 0,
                    zoomed: false,
                    zoomPosition: { x: 0, y: 0 },
                    zoomImageSize: { width: 0, height: 0 },
                    init() {
                        this.$watch('activeImage', () => this.zoomed = false);
                    },
                    handleZoom(e) {
                        if (!this.zoomed) {
                            this.zoomed = true;
                            return;
                        }
                        const img = this.$refs.mainImage;
                        const container = this.$refs.imageContainer;
                        const rect = container.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        const xPercent = (x / rect.width) * 100;
                        const yPercent = (y / rect.height) * 100;
                        this.zoomPosition = { x: xPercent, y: yPercent };
                    }
                }">
                    <div x-ref="imageContainer"
                         class="relative bg-gray-100 rounded-lg overflow-hidden mb-4 cursor-zoom-in"
                         :class="{ 'cursor-zoom-out': zoomed }"
                         @mousemove="handleZoom"
                         @click="zoomed = !zoomed">
                        <img x-ref="mainImage"
                             :src="activeImage < {{ $product->images->count() }} ? '{{ $product->images->get(0)?->url }}'.replace(/0/, activeImage) : '{{ asset('images/placeholder.jpg') }}'"
                             alt="{{ $product->name }}"
                             class="w-full h-auto object-contain transition-opacity duration-300"
                             style="aspect-ratio: 1/1;"
                             loading="eager"
                             x-init="zoomImageSize = { width: $el.naturalWidth, height: $el.naturalHeight }"
                             :style="zoomed ? {
                                 'transform': 'scale(2)',
                                 'transform-origin': `${zoomPosition.x}% ${zoomPosition.y}%`
                             } : ''"
                        />
                        @if($product->price < $product->price_original)
                            <span class="absolute top-4 left-4 bg-red-500 text-white font-bold px-3 py-1 rounded-full text-sm">
                                @lang('webshop-product::webshop-product.sale')
                            </span>
                        @endif
                        @if($product->stock <= 0)
                            <span class="absolute top-4 right-4 bg-gray-800 text-white font-bold px-3 py-1 rounded-full text-sm">
                                @lang('webshop-product::webshop-product.out_of_stock')
                            </span>
                        @endif
                    </div>

                    @if($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($product->images as $index => $image)
                                <button @click="activeImage = {{ $index }}"
                                        class="border rounded-md overflow-hidden hover:border-blue-400 transition-all"
                                        :class="{ 'border-blue-400': activeImage === {{ $index }} }">
                                    <img src="{{ $image->url }}"
                                         alt="{{ $product->name }} - thumbnail {{ $index + 1 }}"
                                         class="w-full h-20 object-cover"
                                         loading="lazy"
                                    />
                                </button>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">@lang('webshop-product::webshop-product.no_images_available')</p>
                    @endif
                </div>
            @endif

            {{-- Details --}}
            <div>
                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                    <div class="flex items-center mb-4">
                        @if($product->price < $product->price_original)
                            <span class="text-2xl font-bold text-blue-400 mr-3">
                                &euro;{{ number_format($product->price, 2, ',', '.') }}
                            </span>
                            <span class="text-lg text-gray-500 line-through">
                                &euro;{{ number_format($product->price_original, 2, ',', '.') }}
                            </span>
                        @else
                            <span class="text-2xl font-bold text-blue-400">
                                &euro;{{ number_format($product->price, 2, ',', '.') }}
                            </span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-600 space-y-1 mb-4">
                        <div>@lang('webshop-product::webshop-product.sku'): {{ $product->sku }}</div>
                        @if($product->stock > 0)
                            <div class="text-green-600">@lang('webshop-product::webshop-product.in_stock') ({{ $product->stock }})</div>
                        @else
                            <div class="text-red-600">@lang('webshop-product::webshop-product.out_of_stock')</div>
                        @endif
                    </div>
                </div>

                {{-- Variants --}}
                @if($showVariants && $product->variants->isNotEmpty())
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">@lang('webshop-product::webshop-product.options')</h3>
                        <div class="space-y-4">
                            @foreach($product->variants->groupBy('type') as $type => $variants)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $type }}</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($variants as $variant)
                                            <button
                                                    class="px-4 py-2 border rounded-md hover:border-blue-400 transition-all"
                                                    :class="{
                                                    'border-blue-400 bg-blue-400/10': selectedVariant === '{{ $variant->id }}',
                                                    'border-gray-300': selectedVariant !== '{{ $variant->id }}'
                                                }">
                                                {{ $variant->name }}
                                                @if($variant->price_adjustment != 0)
                                                    <span class="text-xs">
                                                        ({{ $variant->price_adjustment > 0 ? '+' : '' }}{{ number_format($variant->price_adjustment, 2, ',', '.') }})
                                                    </span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Cart --}}
                <div class="mb-8">
                    <div class="flex items-center gap-4">
                        <x-webshop-product::product-amount-input :quantity="2" :max="$product->stock" input-name="product_quantity" />
                        <button class="flex-1 bg-blue-400 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="quantity <= 0 || {{ $product->stock }} <= 0">
                            @lang('webshop-product::webshop-product.add_to_cart')
                        </button>
                    </div>
                </div>

                {{-- Description --}}
                @if($showDescription && $product->description)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-3">@lang('webshop-product::webshop-product.description')</h3>
                        <div class="prose max-w-none text-gray-700">
                            {!! $product->description !!}
                        </div>
                    </div>
                @endif

                {{-- Additional Details --}}
                @if($showDetails)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-3">@lang('webshop-product::webshop-product.details')</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            @if($product->weight)
                                <div>
                                    <span class="font-medium text-gray-700">@lang('webshop-product::webshop-product.weight'):</span>
                                    <span class="text-gray-600 ml-2">{{ $product->weight }} kg</span>
                                </div>
                            @endif
                            @if($product->dimensions)
                                <div>
                                    <span class="font-medium text-gray-700">@lang('webshop-product::webshop-product.dimensions'):</span>
                                    <span class="text-gray-600 ml-2">
                                        {{ $product->dimensions['length'] ?? 'N/A' }} ×
                                        {{ $product->dimensions['width'] ?? 'N/A' }} ×
                                        {{ $product->dimensions['height'] ?? 'N/A' }} cm
                                    </span>
                                </div>
                            @endif
                            <div>
                                <span class="font-medium text-gray-700">@lang('webshop-product::webshop-product.category'):</span>
                                <span class="text-gray-600 ml-2">
                                    {{ $product->morphCategories->first()->name ?? @lang('webshop-product::webshop-product.uncategorized') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($showRelated && $relatedProducts->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6">@lang('webshop-product::webshop-product.you_may_also_like')</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts->take($maxRelated) as $relatedProduct)
                        <x-webshop-product::product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
