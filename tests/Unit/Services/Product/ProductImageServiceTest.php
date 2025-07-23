<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductImageService;


beforeEach(function () {
    uses(RefreshDatabase::class);

    $this->service = app(IProductImageService::class);
});

it('can create a product image', function () {
    $product = WebshopProduct::factory()->create();

    $image = $this->service->create([
        'product_id' => $product->id,
        'url' => 'images/sample.jpg',
        'alt_text' => 'Afbeelding',
        'is_primary' => false,
        'order' => 1,
    ]);

    expect($image)->toBeInstanceOf(WebshopProductImage::class)
        ->and($image->url)->toBe('images/sample.jpg');
});

it('can retrieve all product images', function () {
    WebshopProductImage::factory()->count(2)->create();

    $result = $this->service->all();

    expect($result)->toHaveCount(2);
});

it('can find a product image by id', function () {
    $image = WebshopProductImage::factory()->create();

    $found = $this->service->find($image->id);

    expect($found)->not->toBeNull()
        ->and($found->id)->toBe($image->id);
});

it('can update a product image', function () {
    $image = WebshopProductImage::factory()->create([
        'url' => 'old.jpg',
    ]);

    $updated = $this->service->update($image, ['url' => 'new.jpg']);

    expect($updated->url)->toBe('new.jpg');
});

it('can delete a product image', function () {
    $image = WebshopProductImage::factory()->create();

    $result = $this->service->delete($image);

    expect($result)->toBeTrue()
        ->and(WebshopProductImage::find($image->id))->toBeNull();
});

it('ensures only one primary image per product', function () {
    $product = WebshopProduct::factory()->create();

    $primary1 = WebshopProductImage::factory()->create([
        'product_id' => $product->id,
        'is_primary' => true,
    ]);

    $primary2 = $this->service->create([
        'product_id' => $product->id,
        'url' => 'images/new.jpg',
        'is_primary' => true,
        'alt_text' => '',
        'order' => 1,
    ]);

    $primary1->refresh();
    $primary2->refresh();

    expect($primary1->is_primary)->toBeFalse()
        ->and($primary2->is_primary)->toBeTrue();
});

it('updates primary image correctly when changed', function () {
    $product = WebshopProduct::factory()->create();

    $primary1 = WebshopProductImage::factory()->create([
        'product_id' => $product->id,
        'is_primary' => true,
    ]);

    $primary2 = WebshopProductImage::factory()->create([
        'product_id' => $product->id,
        'is_primary' => false,
    ]);

    $this->service->update($primary2, ['is_primary' => true]);

    $primary1->refresh();
    $primary2->refresh();

    expect($primary1->is_primary)->toBeFalse()
        ->and($primary2->is_primary)->toBeTrue();
});
