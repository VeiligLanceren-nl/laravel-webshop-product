@props(['product'])

@php
    $images = $product->images ?? collect();
    $placeholder = asset('images/placeholder.jpg');
@endphp

<div x-data="{
        activeImage: 0,
        zoomed: false,
        zoomPosition: { x: 50, y: 50 },
        touchStartX: 0,
        isMobile: window.innerWidth < 768,

        init() {
            // Handle window resize
            this.$watch('isMobile', (val) => {
                if (val) this.zoomed = false;
            });

            // Keyboard navigation
            window.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') this.previousImage();
                if (e.key === 'ArrowRight') this.nextImage();
                if (e.key === 'Escape') this.zoomed = false;
            });
        },

        nextImage() {
            this.activeImage = (this.activeImage + 1) % {{ $images->count() }};
            this.zoomed = false;
        },

        previousImage() {
            this.activeImage = (this.activeImage - 1 + {{ $images->count() }}) % {{ $images->count() }};
            this.zoomed = false;
        },

        handleZoom(e) {
            if (this.isMobile) return;

            const container = this.$refs.imageContainer;
            const rect = container.getBoundingClientRect();

            // Calculate mouse position relative to image
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Calculate percentage position
            this.zoomPosition = {
                x: Math.max(0, Math.min(100, (x / rect.width) * 100)),
                y: Math.max(0, Math.min(100, (y / rect.height) * 100))
            };
        },

        handleTouchStart(e) {
            this.touchStartX = e.touches[0].clientX;
        },

        handleTouchEnd(e) {
            const touchEndX = e.changedTouches[0].clientX;
            const diff = this.touchStartX - touchEndX;

            if (diff > 50) this.nextImage();
            if (diff < -50) this.previousImage();
        }
    }"
     class="w-full relative group"
     @resize.window="isMobile = window.innerWidth < 768"
>
    @if ($images->isNotEmpty())
        {{-- Main Image Container --}}
        <div class="relative mb-4 bg-gray-50 rounded-xl overflow-hidden"
             x-ref="imageContainer"
             @mousemove="handleZoom"
             @click="zoomed = !zoomed"
             @touchstart="handleTouchStart"
             @touchend="handleTouchEnd"
             :class="{
                'cursor-zoom-in': !zoomed,
                'cursor-zoom-out': zoomed && !isMobile
            }"
        >
            {{-- Main Image --}}
            <img
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    :src="{{ $images->count() > 0 ? json_encode($images->pluck('url')) : $placeholder }}[activeImage]"
                    alt="{{ $product->name }}"
                    class="w-full h-auto max-h-[500px] object-contain mx-auto"
                    :style="zoomed && !isMobile ? {
                    'transform': 'scale(2)',
                    'transform-origin': `${zoomPosition.x}% ${zoomPosition.y}%`
                } : ''"
                    loading="eager"
                    draggable="false"
            />

            {{-- Navigation Arrows (Desktop) --}}
            <template x-if="{{ $images->count() > 1 }}">
                <div class="hidden md:block">
                    <button
                            @click.stop="previousImage()"
                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md transition-all opacity-0 group-hover:opacity-100"
                            aria-label="Previous image"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                            @click.stop="nextImage()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md transition-all opacity-0 group-hover:opacity-100"
                            aria-label="Next image"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </template>

            {{-- Image Counter --}}
            <div x-show="{{ $images->count() > 1 }}" class="absolute bottom-4 left-4 bg-black/50 text-white text-sm px-2 py-1 rounded-md">
                <span x-text="activeImage + 1"></span>/<span x-text="{{ $images->count() }}"></span>
            </div>

            {{-- Zoom Indicator --}}
            <div x-show="zoomed && !isMobile" class="absolute top-4 right-4 bg-black/50 text-white text-sm px-2 py-1 rounded-md">
                Click to zoom out
            </div>
        </div>

        {{-- Thumbnail Gallery --}}
        @if ($images->count() > 1)
            <div class="relative">
                <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-2">
                    @foreach ($images as $index => $image)
                        <button
                                type="button"
                                @click="activeImage = {{ $index }}"
                                class="flex-shrink-0 rounded-lg overflow-hidden transition-all border-2 hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/50"
                                :class="activeImage === {{ $index }} ? 'border-primary scale-105' : 'border-transparent'"
                                aria-label="View image {{ $index + 1 }}"
                        >
                            <img
                                    src="{{ $image->url }}"
                                    alt="{{ $image->alt ?? $product->name }} - thumbnail {{ $index + 1 }}"
                                    class="h-20 w-20 object-cover"
                                    loading="lazy"
                                    draggable="false"
                            />
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        {{-- Placeholder when no images --}}
        <div class="bg-gray-50 rounded-xl flex items-center justify-center aspect-square">
            <div class="text-center p-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-2 text-gray-500">
                    @lang('webshop-product::webshop-product.no_images_available')
                </p>
            </div>
        </div>
    @endif
</div>