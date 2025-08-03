<?php

use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductOption;

it('can create a product option', function () {
    $option = WebshopProductOption::factory()->create();

    expect($option)->toBeInstanceOf(WebshopProductOption::class)
        ->and($option->id)->not()->toBeNull()
        ->and($option->name)->not()->toBeEmpty()
        ->and($option->additional_price)->toBeFloat();
});

it('belongs to a product', function () {
    $option = WebshopProductOption::factory()->create();

    expect($option->product)->toBeInstanceOf(WebshopProduct::class)
        ->and($option->product->id)->toEqual($option->webshop_product_id);
});

it('calculates total price with selected options', function () {
    $product = WebshopProduct::factory()->create(['price' => 100]);

    $options = WebshopProductOption::factory()->count(2)->create([
        'webshop_product_id' => $product->id,
    ]);

    $selectedIds = $options->pluck('id')->toArray();
    $totalPrice = $product->totalPriceWithOptions($selectedIds);

    expect($totalPrice)->toBe(
        $product->price + $options->sum('additional_price')
    );
});
