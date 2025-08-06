<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;
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

it('can have images associated with an attribute value', function () {
    $value = WebshopProductAttributeValue::factory()->create();
    $images = WebshopProductImage::factory()->count(2)->create([
        'webshop_product_attribute_value_id' => $value->id,
    ]);

    expect($value->images)->toHaveCount(2)
        ->each->toBeInstanceOf(WebshopProductImage::class)
        ->and($value->images->first()->webshop_product_attribute_value_id)
        ->toEqual($value->id);
});

it('returns the attribute value from an image', function () {
    $value = WebshopProductAttributeValue::factory()->create();
    $image = WebshopProductImage::factory()->create([
        'webshop_product_attribute_value_id' => $value->id,
    ]);

    expect($image->attributeValue)
        ->toBeInstanceOf(WebshopProductAttributeValue::class)
        ->id->toEqual($value->id);
});

it('returns empty collection when no images are associated', function () {
    $value = WebshopProductAttributeValue::factory()->create();

    expect($value->images)->toBeEmpty();
});