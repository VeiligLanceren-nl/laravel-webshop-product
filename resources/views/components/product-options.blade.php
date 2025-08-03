@props(['product'])

<div>
    <h3 class="text-lg font-semibold">Options</h3>
    @foreach($product->options as $option)
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="options[]" value="{{ $option->id }}">
            <span>{{ $option->name }} (+€{{ number_format($option->additional_price, 2) }})</span>
        </label>
    @endforeach
</div>
