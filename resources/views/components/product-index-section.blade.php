@props([
    'products',
    'filters' => null,
    'sortOptions' => [
        'price_asc' => 'Price: Low to High',
        'price_desc' => 'Price: High to Low',
        'newest' => 'Newest',
        'popular' => 'Most Popular',
    ],
    'showFilters' => true,
    'showSort' => true,
    'gridColumns' => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-4',
    'gap' => 'gap-6',
])

<section class="py-8 md:py-12">
    <div class="container mx-auto px-4">
        {{-- Header with title and sorting --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                @if(request()->has('search'))
                    @lang('webshop-product::webshop-product.search_results', ['term' => request('search')])
                @else
                    @lang('webshop-product::webshop-product.our_products')
                @endif
            </h1>

            @if($showSort)
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">@lang('webshop-product::webshop-product.sort_by')</span>
                    <select
                            x-data="{ currentSort: '{{ request('sort', 'newest') }}' }"
                            x-model="currentSort"
                            @change="window.location.href = updateQueryStringParam('sort', currentSort)"
                            class="border-gray-300 rounded-md text-sm focus:border-primary focus:ring-primary"
                    >
                        @foreach($sortOptions as $value => $label)
                            <option value="{{ $value }}" {{ request('sort', 'newest') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Filters sidebar --}}
            @if($showFilters && $filters)
                <div class="lg:w-64 flex-shrink-0">
                    <div class="bg-white p-4 rounded-lg shadow-sm sticky top-4">
                        <h3 class="font-medium text-lg mb-4">@lang('webshop-product::webshop-product.filters')</h3>

                        <form id="filter-form" method="GET" action="{{ url()->current() }}">
                            {{-- Search filter --}}
                            <div class="mb-6">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                                    @lang('webshop-product::webshop-product.search')
                                </label>
                                <input
                                        type="text"
                                        name="search"
                                        id="search"
                                        value="{{ request('search') }}"
                                        placeholder="@lang('webshop-product::webshop-product.search_placeholder')"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary text-sm"
                                />
                            </div>

                            {{-- Price range filter --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    @lang('webshop-product::webshop-product.price_range')
                                </label>
                                <div class="flex items-center gap-2">
                                    <input
                                            type="number"
                                            name="min_price"
                                            value="{{ request('min_price') }}"
                                            placeholder="@lang('webshop-product::webshop-product.min')"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary text-sm"
                                    />
                                    <span class="text-gray-500">to</span>
                                    <input
                                            type="number"
                                            name="max_price"
                                            value="{{ request('max_price') }}"
                                            placeholder="@lang('webshop-product::webshop-product.max')"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary text-sm"
                                    />
                                </div>
                            </div>

                            {{-- Category filter --}}
                            @if($filters->has('categories'))
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        @lang('webshop-product::webshop-product.categories')
                                    </label>
                                    <div class="space-y-2">
                                        @foreach($filters->get('categories') as $category)
                                            <div class="flex items-center">
                                                <input
                                                        id="category-{{ $category->id }}"
                                                        name="categories[]"
                                                        type="checkbox"
                                                        value="{{ $category->id }}"
                                                        {{ in_array($category->id, (array)request('categories', [])) ? 'checked' : '' }}
                                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                                                />
                                                <label for="category-{{ $category->id }}" class="ml-2 text-sm text-gray-700">
                                                    {{ $category->name }} ({{ $category->products_count }})
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Other dynamic filters --}}
                            @foreach($filters->except('categories') as $filterName => $filterValues)
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __(Str::title(str_replace('_', ' ', $filterName))) }}
                                    </label>
                                    <div class="space-y-2">
                                        @foreach($filterValues as $value => $count)
                                            <div class="flex items-center">
                                                <input
                                                        id="{{ $filterName }}-{{ $value }}"
                                                        name="{{ $filterName }}[]"
                                                        type="checkbox"
                                                        value="{{ $value }}"
                                                        {{ in_array($value, (array)request($filterName, [])) ? 'checked' : '' }}
                                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                                                />
                                                <label for="{{ $filterName }}-{{ $value }}" class="ml-2 text-sm text-gray-700">
                                                    {{ $value }} ({{ $count }})
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <div class="flex gap-2">
                                <button
                                        type="submit"
                                        class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                                >
                                    @lang('webshop-product::webshop-product.apply_filters')
                                </button>
                                <a
                                        href="{{ url()->current() }}"
                                        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center justify-center"
                                >
                                    @lang('webshop-product::webshop-product.reset')
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Products grid --}}
            <div class="flex-1">
                @if($products->count() > 0)
                    <div class="grid {{ $gridColumns }} {{ $gap }}">
                        @foreach($products as $product)
                            <x-webshop-product::product-card :product="$product" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">
                            @lang('webshop-product::webshop-product.no_products')
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @lang('webshop-product::webshop-product.try_adjusting')
                        </p>
                        <div class="mt-6">
                            <a
                                    href="{{ url()->current() }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                            >
                                @lang('webshop-product::webshop-product.reset_filters')
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        function updateQueryStringParam(key, value) {
            const url = new URL(window.location.href);
            url.searchParams.set(key, value);
            return url.toString();
        }
    </script>
@endpush
