<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductService;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = app()->make(IProductService::class);
});

it('can create a product through the service', function () {
    $product = $this->service->create([
        'sku' => 'PROD-001',
        'name' => 'Managed Hosting',
        'slug' => 'managed-hosting',
        'price' => 19.95,
    ]);

    expect($product)->toBeInstanceOf(Product::class)
        ->and($product->sku)->toBe('PROD-001');
});

it('can retrieve all products through the service', function () {
    Product::factory()->count(5)->create();

    $products = $this->service->all();

    expect($products)->toHaveCount(5);
});

it('can find a product by id through the service', function () {
    $product = Product::factory()->create();

    $found = $this->service->find($product->id);

    expect($found)->not()->toBeNull()
        ->and($found->id)->toBe($product->id);
});

it('can update a product through the service', function () {
    $product = Product::factory()->create(['name' => 'Old']);

    $updated = $this->service->update($product, ['name' => 'New']);

    expect($updated->name)->toBe('New');
});

it('can delete a product through the service', function () {
    $product = Product::factory()->create();

    $deleted = $this->service->delete($product);

    expect($deleted)->toBeTrue()
        ->and(Product::find($product->id))->toBeNull();
});
