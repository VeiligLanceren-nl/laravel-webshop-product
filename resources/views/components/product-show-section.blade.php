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
                            <a href="{{ route('home') }}" class="hover:text-blue-400">
                                @lang('webshop-product::webshop-product.home')
                            </a>
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
                <div id="gallery-container">
                    <div class="relative bg-gray-100 rounded-lg overflow-hidden mb-4 cursor-zoom-in" id="main-image-container">
                        <img id="mainImage"
                             src="{{ $product->images->first()->image ?? asset('images/placeholder.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full h-auto object-contain transition-opacity duration-300"
                             style="aspect-ratio: 1/1;"
                             loading="eager"
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

                    {{-- Thumbnails --}}
                    @if($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-3" id="thumbnail-container">
                            @foreach($product->images as $index => $image)
                                <button data-index="{{ $index }}"
                                        class="border rounded-md overflow-hidden hover:border-blue-400 transition-all">
                                    <img src="{{ $image->image }}"
                                         alt="{{ $product->name }} - thumbnail {{ $index + 1 }}"
                                         class="w-full h-20 object-cover"
                                         loading="lazy"
                                    />
                                </button>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">
                            @lang('webshop-product::webshop-product.no_images_available')
                        </p>
                    @endif
                </div>

                <div id="zoom-controls" class="mt-3 flex justify-center space-x-4 hidden">
                    <button id="zoom-out" class="p-2 bg-gray-200 hover:bg-gray-300 rounded-full">
                        -
                    </button>
                    <button id="zoom-reset" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-md text-sm">
                        100%
                    </button>
                    <button id="zoom-in" class="p-2 bg-gray-200 hover:bg-gray-300 rounded-full">
                        +
                    </button>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const images = @json($product->images->pluck('image'));
                        let activeImage = 0;
                        let zoomed = false;
                        let zoomLevel = 2;
                        let zoomPosition = { x: 50, y: 50 };

                        const mainImage = document.getElementById('mainImage');
                        const mainContainer = document.getElementById('main-image-container');
                        const thumbnails = document.querySelectorAll('#thumbnail-container button');
                        const zoomControls = document.getElementById('zoom-controls');
                        const zoomInBtn = document.getElementById('zoom-in');
                        const zoomOutBtn = document.getElementById('zoom-out');
                        const zoomResetBtn = document.getElementById('zoom-reset');

                        // Thumbnail click
                        thumbnails.forEach((btn, index) => {
                            btn.addEventListener('click', () => {
                                activeImage = index;
                                mainImage.src = images[activeImage] || '{{ asset('images/placeholder.jpg') }}';
                                zoomed = false;
                                zoomControls.classList.add('hidden');
                                mainImage.style.transform = 'scale(1)';
                            });
                        });

                        // Toggle zoom
                        mainContainer.addEventListener('click', () => {
                            zoomed = !zoomed;
                            if (!zoomed) {
                                mainImage.style.transform = 'scale(1)';
                                zoomControls.classList.add('hidden');
                            } else {
                                zoomControls.classList.remove('hidden');
                            }
                        });

                        // Move zoom position
                        mainContainer.addEventListener('mousemove', (e) => {
                            if (!zoomed) return;
                            const rect = mainContainer.getBoundingClientRect();
                            const x = ((e.clientX - rect.left) / rect.width) * 100;
                            const y = ((e.clientY - rect.top) / rect.height) * 100;
                            zoomPosition = { x, y };
                            mainImage.style.transformOrigin = `${x}% ${y}%`;
                            mainImage.style.transform = `scale(${zoomLevel})`;
                        });

                        // Zoom buttons
                        zoomInBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            zoomLevel = Math.min(3, zoomLevel + 0.5);
                            mainImage.style.transform = `scale(${zoomLevel})`;
                        });

                        zoomOutBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            zoomLevel = Math.max(1, zoomLevel - 0.5);
                            mainImage.style.transform = `scale(${zoomLevel})`;
                        });

                        zoomResetBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            zoomLevel = 2;
                            mainImage.style.transform = `scale(${zoomLevel})`;
                        });
                    });
                </script>
            @endif

            {{-- Product Details --}}
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
                {{-- Keep your variant block here if needed --}}

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
                                    {{ $product->morphCategories->first()->name ?? __('webshop-product::webshop-product.uncategorized') }}
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
