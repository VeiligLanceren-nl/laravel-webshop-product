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
                            <a href="{{ route('home') }}" class="hover:text-primary">Home</a>
                        @else
                            Home
                        @endif
                    </li>
                    <li>/</li>
                    @if($product->categories->isNotEmpty())
                        <li>
                            @if($linkCategory)
                                <a href="{{ route('category.show', $product->categories->first()->slug) }}" class="hover:text-primary">
                                    {{ $product->categories->first()->name }}
                                </a>
                            @else
                                {{ $product->categories->first()->name }}
                            @endif
                        </li>
                        <li>/</li>
                    @endif
                    <li class="text-gray-900 font-medium">{{ $product->name }}</li>
                </ol>
            </nav>
        @endif

        {{-- Product Main Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            {{-- Product Gallery --}}
            @if($showGallery)
                <div x-data="{
                    activeImage: 0,
                    zoomed: false,
                    zoomPosition: { x: 0, y: 0 },
                    zoomImageSize: { width: 0, height: 0 },

                    init() {
                        this.$watch('activeImage', () => {
                            this.zoomed = false;
                        });
                    },

                    handleZoom(e) {
                        if (!this.zoomed) {
                            this.zoomed = true;
                            return;
                        }

                        const img = this.$refs.mainImage;
                        const container = this.$refs.imageContainer;
                        const rect = container.getBoundingClientRect();

                        // Calculate mouse position relative to image
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        // Calculate percentage position
                        const xPercent = (x / rect.width) * 100;
                        const yPercent = (y / rect.height) * 100;

                        this.zoomPosition = { x: xPercent, y: yPercent };
                    }
                }">
                    {{-- Main Image --}}
                    <div
                            x-ref="imageContainer"
                            class="relative bg-gray-100 rounded-lg overflow-hidden mb-4 cursor-zoom-in"
                            :class="{ 'cursor-zoom-out': zoomed }"
                            @mousemove="handleZoom"
                            @click="zoomed = !zoomed"
                    >
                        <img
                                x-ref="mainImage"
                                src="{{ $product->images->first()->url ?? asset('images/placeholder.jpg') }}"
                                alt="{{ $product->name }}"
                                class="w-full h-auto object-contain transition-opacity duration-300"
                                :class="{
                                'opacity-100': activeImage === index,
                                'opacity-0': activeImage !== index
                            }"
                                style="aspect-ratio: 1/1;"
                                loading="eager"
                                x-init="zoomImageSize = {
                                width: $el.naturalWidth,
                                height: $el.naturalHeight
                            }"
                                :style="zoomed ? {
                                'transform': 'scale(2)',
                                'transform-origin': `${zoomPosition.x}% ${zoomPosition.y}%`
                            } : ''"
                        />

                        {{-- Sale Badge --}}
                        @if($product->price < $product->price_original)
                            <span class="absolute top-4 left-4 bg-red-500 text-white font-bold px-3 py-1 rounded-full text-sm">
                                Sale
                            </span>
                        @endif

                        {{-- Out of Stock Badge --}}
                        @if($product->stock <= 0)
                            <span class="absolute top-4 right-4 bg-gray-800 text-white font-bold px-3 py-1 rounded-full text-sm">
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    {{-- Thumbnail Gallery --}}
                    @if($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($product->images as $index => $image)
                                <button
                                        @click="activeImage = {{ $index }}"
                                        class="border rounded-md overflow-hidden hover:border-primary transition-all"
                                        :class="{ 'border-primary': activeImage === {{ $index }} }"
                                >
                                    <img src="{{ $image->url }}"
                                         alt="{{ $product->name }} - thumbnail {{ $index + 1 }}"
                                         class="w-full h-20 object-cover"
                                         loading="lazy"
                                    />
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Product Details --}}
            <div>
                {{-- Title and Price --}}
                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                    <div class="flex items-center mb-4">
                        @if($product->price < $product->price_original)
                            <span class="text-2xl font-bold text-primary mr-3">
                                &euro;{{ number_format($product->price, 2, ',', '.') }}
                            </span>
                            <span class="text-lg text-gray-500 line-through">
                                &euro;{{ number_format($product->price_original, 2, ',', '.') }}
                            </span>
                        @else
                            <span class="text-2xl font-bold text-primary">
                                &euro;{{ number_format($product->price, 2, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    {{-- SKU and Stock --}}
                    <div class="text-sm text-gray-600 space-y-1 mb-4">
                        <div>SKU: {{ $product->sku }}</div>
                        @if($product->stock > 0)
                            <div class="text-green-600">In stock ({{ $product->stock }} available)</div>
                        @else
                            <div class="text-red-600">Out of stock</div>
                        @endif
                    </div>
                </div>

                {{-- Variants --}}
                @if($showVariants && $product->variants->isNotEmpty())
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Options</h3>
                        <div class="space-y-4">
                            @foreach($product->variants->groupBy('type') as $type => $variants)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $type }}</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($variants as $variant)
                                            <button
                                                    class="px-4 py-2 border rounded-md hover:border-primary transition-all"
                                                    :class="{
                                                    'border-primary bg-primary/10': selectedVariant === '{{ $variant->id }}',
                                                    'border-gray-300': selectedVariant !== '{{ $variant->id }}'
                                                }"
                                            >
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

                {{-- Add to Cart --}}
                <div class="mb-8">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center border rounded-md overflow-hidden">
                            <button
                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors"
                                    @click="quantity > 1 ? quantity-- : null"
                            >
                                -
                            </button>
                            <input
                                    type="number"
                                    x-model="quantity"
                                    min="1"
                                    max="{{ $product->stock }}"
                                    class="w-12 text-center border-0 focus:ring-0"
                            />
                            <button
                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors"
                                    @click="quantity < {{ $product->stock }} ? quantity++ : null"
                            >
                                +
                            </button>
                        </div>

                        <button
                                class="flex-1 bg-primary hover:bg-primary-dark text-white font-medium py-3 px-6 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="quantity <= 0 || {{ $product->stock }} <= 0"
                        >
                            Add to Cart
                        </button>
                    </div>
                </div>

                {{-- Product Description --}}
                @if($showDescription && $product->description)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-3">Description</h3>
                        <div class="prose max-w-none text-gray-700">
                            {!! $product->description !!}
                        </div>
                    </div>
                @endif

                {{-- Additional Details --}}
                @if($showDetails)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-3">Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            @if($product->weight)
                                <div>
                                    <span class="font-medium text-gray-700">Weight:</span>
                                    <span class="text-gray-600 ml-2">{{ $product->weight }} kg</span>
                                </div>
                            @endif

                            @if($product->dimensions)
                                <div>
                                    <span class="font-medium text-gray-700">Dimensions:</span>
                                    <span class="text-gray-600 ml-2">
                                        {{ $product->dimensions['length'] ?? 'N/A' }} ×
                                        {{ $product->dimensions['width'] ?? 'N/A' }} ×
                                        {{ $product->dimensions['height'] ?? 'N/A' }} cm
                                    </span>
                                </div>
                            @endif

                            <div>
                                <span class="font-medium text-gray-700">Category:</span>
                                <span class="text-gray-600 ml-2">
                                    @if($product->categories->isNotEmpty())
                                        {{ $product->categories->first()->name }}
                                    @else
                                        Uncategorized
                                    @endif
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
                <h2 class="text-2xl font-bold mb-6">You may also like</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts->take($maxRelated) as $relatedProduct)
                        <x-webshop-product::product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>