@props(['product'])

<div class="space-y-4">
    @foreach ($product->variants->flatMap->attributeValues->groupBy('attribute.name') as $attributeName => $values)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ ucfirst($attributeName) }}
            </label>
            <select
                    name="attributes[{{ Str::slug($attributeName) }}]"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                    required
            >
                <option value="">Select {{ strtolower($attributeName) }}</option>
                @foreach ($values->unique('id') as $value)
                    <option value="{{ $value->id }}">
                        {{ $value->value }}
                    </option>
                @endforeach
            </select>
        </div>
    @endforeach
</div>
