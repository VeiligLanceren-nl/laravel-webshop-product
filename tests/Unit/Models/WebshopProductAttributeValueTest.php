<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductVariant;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductAttribute;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductAttributeValue;

uses(RefreshDatabase::class);

it('can create an attribute value with factory', function () {
    $value = WebshopProductAttributeValue::factory()->create();

    expect($value)->toBeInstanceOf(WebshopProductAttributeValue::class)
        ->and($value->id)->not->toBeNull()
        ->and($value->value)->not->toBeEmpty();
});

it('belongs to an attribute', function () {
    $attribute = WebshopProductAttribute::factory()->create();
    $value = WebshopProductAttributeValue::factory()->create([
        'webshop_product_attribute_id' => $attribute->id,
    ]);

    expect($value->attribute)->toBeInstanceOf(WebshopProductAttribute::class)
        ->id->toEqual($attribute->id);
});

it('can be attached to variants', function () {
    $value = WebshopProductAttributeValue::factory()->create();
    $variant = WebshopProductVariant::factory()->create();

    $value->variants()->attach($variant->id);

    expect($value->variants()->first())
        ->toBeInstanceOf(WebshopProductVariant::class)
        ->id->toEqual($variant->id);
});

it('supports multiple variants', function () {
    $value = WebshopProductAttributeValue::factory()->create();
    $variants = WebshopProductVariant::factory()->count(2)->create();

    $value->variants()->sync($variants->pluck('id'));

    expect($value->variants)->toHaveCount(2);
});
