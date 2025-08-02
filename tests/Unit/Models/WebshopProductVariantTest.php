<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductVariant;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductAttributeValue;

uses(RefreshDatabase::class);

it('can create a product variant with factory', function () {
    $variant = WebshopProductVariant::factory()->create();

    expect($variant)->toBeInstanceOf(WebshopProductVariant::class)
        ->and($variant->id)->not->toBeNull();
});

it('belongs to a product', function () {
    $product = WebshopProduct::factory()->create();
    $variant = WebshopProductVariant::factory()->create([
        'webshop_product_id' => $product->id,
    ]);

    expect($variant->product)
        ->toBeInstanceOf(WebshopProduct::class)
        ->id->toEqual($product->id);
});

it('can attach attribute values', function () {
    $variant = WebshopProductVariant::factory()->create();
    $value = WebshopProductAttributeValue::factory()->create();

    $variant->attributeValues()->attach($value->id);

    expect($variant->attributeValues()->first())
        ->toBeInstanceOf(WebshopProductAttributeValue::class)
        ->id->toEqual($value->id);
});

it('casts price to decimal', function () {
    $variant = WebshopProductVariant::factory()->create([
        'price' => 99.99,
    ]);

    expect($variant->price)->toBeString()->toEqual(99.99);
});

it('casts options to array', function () {
    $variant = WebshopProductVariant::factory()->create([
        'options' => ['color' => 'red', 'size' => 'M'],
    ]);

    expect($variant->options)->toBeArray()
        ->and($variant->options['color'])->toEqual('red')
        ->and($variant->options['size'])->toEqual('M');
});
