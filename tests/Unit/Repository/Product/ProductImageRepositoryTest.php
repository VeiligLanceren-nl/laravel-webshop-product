<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductImage;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductImageRepository;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->repository = app()->make(IProductImageRepository::class);
});

it('can create a product image', function () {
    $product = Product::factory()->create();

    $image = $this->repository->create([
        'product_id' => $product->id,
        'url' => 'images/product.jpg',
        'alt_text' => 'Sample image',
        'is_primary' => true,
        'order' => 1,
    ]);

    expect($image)->toBeInstanceOf(ProductImage::class)
        ->and($image->url)->toBe('images/product.jpg');
});

it('can retrieve all product images', function () {
    ProductImage::factory()->count(3)->create();

    $all = $this->repository->all();

    expect($all)->toHaveCount(3);
});

it('can find a product image by id', function () {
    $image = ProductImage::factory()->create();

    $found = $this->repository->find($image->id);

    expect($found)->not->toBeNull()
        ->and($found->id)->toBe($image->id);
});

it('can update a product image', function () {
    $image = ProductImage::factory()->create([
        'url' => 'old.jpg',
    ]);

    $this->repository->update($image, ['url' => 'new.jpg']);

    expect($image->refresh()->url)->toBe('new.jpg');
});

it('can delete a product image', function () {
    $image = ProductImage::factory()->create();

    $result = $this->repository->delete($image);

    expect($result)->toBeTrue()
        ->and(ProductImage::find($image->id))->toBeNull();
});
