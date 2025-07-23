<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductImageRepository;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->repository = app()->make(IProductImageRepository::class);
});

it('can create a product image', function () {
    $product = WebshopProduct::factory()->create();

    $image = $this->repository->create([
        'webshop_product_id' => $product->id,
        'url' => 'images/product.jpg',
        'alt_text' => 'Sample image',
        'is_primary' => true,
        'order' => 1,
    ]);

    expect($image)->toBeInstanceOf(WebshopProductImage::class)
        ->and($image->url)->toBe('images/product.jpg');
});

it('can retrieve all product images', function () {
    WebshopProductImage::factory()->count(3)->create();

    $all = $this->repository->all();

    expect($all)->toHaveCount(3);
});

it('can find a product image by id', function () {
    $image = WebshopProductImage::factory()->create();

    $found = $this->repository->find($image->id);

    expect($found)->not->toBeNull()
        ->and($found->id)->toBe($image->id);
});

it('can update a product image', function () {
    $image = WebshopProductImage::factory()->create([
        'url' => 'old.jpg',
    ]);

    $this->repository->update($image, ['url' => 'new.jpg']);

    expect($image->refresh()->url)->toBe('new.jpg');
});

it('can delete a product image', function () {
    $image = WebshopProductImage::factory()->create();

    $result = $this->repository->delete($image);

    expect($result)->toBeTrue()
        ->and(WebshopProductImage::find($image->id))->toBeNull();
});
