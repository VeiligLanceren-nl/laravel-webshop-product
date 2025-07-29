@props([
    'products',
    'showArrows' => true,
    'showDots' => false,
    'itemsPerSlide' => 4,
    'imageHeight' => 'h-40',
    'cardWidth' => 'w-64',
])

<div
        x-data="{
        slider: null,
        currentIndex: 0,
        itemWidth: 0,
        totalItems: {{ count($products) }},
        itemsPerSlide: {{ $itemsPerSlide }},
        scrollOffset: 0,

        init() {
            this.$nextTick(() => {
                this.slider = this.$refs.slider;
                this.calculateItemWidth();
                window.addEventListener('resize', this.calculateItemWidth.bind(this));
            });
        },

        calculateItemWidth() {
            if (this.slider && this.slider.firstElementChild) {
                this.itemWidth = this.slider.firstElementChild.offsetWidth +
                                 parseInt(window.getComputedStyle(this.slider.firstElementChild).marginRight);
                this.scrollOffset = this.itemWidth * this.itemsPerSlide;
            }
        },

        scrollLeft() {
            this.currentIndex = Math.max(0, this.currentIndex - 1);
            this.slider.scrollTo({
                left: this.currentIndex * this.scrollOffset,
                behavior: 'smooth'
            });
        },

        scrollRight() {
            this.currentIndex = Math.min(
                Math.ceil(this.totalItems / this.itemsPerSlide) - 1,
                this.currentIndex + 1
            );
            this.slider.scrollTo({
                left: this.currentIndex * this.scrollOffset,
                behavior: 'smooth'
            });
        },

        goToSlide(index) {
            this.currentIndex = index;
            this.slider.scrollTo({
                left: index * this.scrollOffset,
                behavior: 'smooth'
            });
        }
    }"
        class="relative group"
>
    {{-- Navigation Arrows --}}
    @if($showArrows)
        <button
                @click="scrollLeft()"
                x-show="currentIndex > 0"
                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white border rounded-full shadow p-2 hidden md:flex items-center justify-center transition-all opacity-0 group-hover:opacity-100"
                aria-label="Previous products"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        </button>
        <button
                @click="scrollRight()"
                x-show="currentIndex < Math.ceil(totalItems / itemsPerSlide) - 1"
                class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white border rounded-full shadow p-2 hidden md:flex items-center justify-center transition-all opacity-0 group-hover:opacity-100"
                aria-label="Next products"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </button>
    @endif

    {{-- Product slider --}}
    <div
            x-ref="slider"
            class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-hide px-2 py-4"
    >
        @forelse ($products as $product)
            <div class="snap-start flex-shrink-0 {{ $cardWidth }} bg-white rounded-lg shadow hover:shadow-md transition p-4 group/card">
                <a href="{{ route('product.show', $product->slug) }}" class="block h-full">
                    <div class="relative overflow-hidden rounded-md mb-3 aspect-square">
                        <img
                                src="{{ $product->images->first()->image ?? asset('images/placeholder.jpg') }}"
                                alt="{{ $product->name }}"
                                class="{{ $imageHeight }} w-full object-cover transition-transform duration-300 group-hover/card:scale-105"
                                loading="lazy"
                        />
                        @if($product->stock <= 0)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                Sold Out
                            </span>
                        @endif
                    </div>
                    <div class="text-lg font-semibold truncate">{{ $product->name }}</div>
                    <div class="text-primary font-bold mt-1">
                        &euro; {{ number_format($product->price, 2, ',', '.') }}
                        @if($product->price_original > $product->price)
                            <span class="text-gray-400 text-sm line-through ml-2">
                                &euro; {{ number_format($product->price_original, 2, ',', '.') }}
                            </span>
                        @endif
                    </div>
                </a>
            </div>
        @empty
            <div class="w-full text-center py-8">
                <p class="text-gray-500">No products found</p>
            </div>
        @endforelse
    </div>

    {{-- Dots Navigation --}}
    @if($showDots && count($products) > 0)
        <div class="flex justify-center gap-2 mt-4">
            <template x-for="(_, index) in Math.ceil(totalItems / itemsPerSlide)" :key="index">
                <button
                        @click="goToSlide(index)"
                        class="w-3 h-3 rounded-full transition-all"
                        :class="{
                        'bg-primary': currentIndex === index,
                        'bg-gray-300': currentIndex !== index
                    }"
                        :aria-label="`Go to slide ${index + 1}`"
                ></button>
            </template>
        </div>
    @endif
</div>