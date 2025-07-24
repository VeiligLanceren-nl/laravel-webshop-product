@props([
    'quantity' => 1,
    'max' => 10,
    'min' => 1,
    'inputName' => 'quantity',
])

<div
        x-data="{ quantity: {{ $quantity }} }"
        class="flex items-center border rounded-md overflow-hidden"
>
    <button
            type="button"
            class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors"
            @click="quantity > {{ $min }} ? quantity-- : null"
    >
        -
    </button>
    <input
            type="number"
            :name="'{{ $inputName }}'"
            x-model="quantity"
            min="{{ $min }}"
            max="{{ $max }}"
            value="{{ $quantity }}"
            class="w-12 text-center border-0 focus:ring-0"
    />
    <button
            type="button"
            class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors"
            @click="quantity < {{ $max }} ? quantity++ : null"
    >
        +
    </button>
</div>
