<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductAttribute;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductAttributeValue;

uses(RefreshDatabase::class);

it('can create an attribute with factory', function () {
    $attribute = WebshopProductAttribute::factory()->create();

    expect($attribute)->toBeInstanceOf(WebshopProductAttribute::class)
        ->and($attribute->id)->not->toBeNull()
        ->and($attribute->name)->not->toBeEmpty();
});

it('has many values', function () {
    $attribute = WebshopProductAttribute::factory()->create();

    $value1 = WebshopProductAttributeValue::factory()->create([
        'webshop_product_attribute_id' => $attribute->id,
    ]);
    $value2 = WebshopProductAttributeValue::factory()->create([
        'webshop_product_attribute_id' => $attribute->id,
    ]);

    $values = $attribute->values;

    expect($values)->toHaveCount(2)
        ->and($values->first())->toBeInstanceOf(WebshopProductAttributeValue::class);
});

it('can distinguish variation attributes', function () {
    $variation = WebshopProductAttribute::factory()->create(['is_variation' => true]);
    $normal = WebshopProductAttribute::factory()->create(['is_variation' => false]);

    expect($variation->is_variation)->toBeTrue()
        ->and($normal->is_variation)->toBeFalse();
});
