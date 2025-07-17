<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductRepository;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->repository = app(IProductRepository::class);
});

it('can create a product', function () {
    $product = $this->repository->create([
        'sku' => 'HOSTING-001',
        'name' => 'Webhosting Plus',
        'slug' => 'webhosting-plus',
        'price' => 9.95,
    ]);

    expect($product)->toBeInstanceOf(Product::class)
        ->and($product->name)->toBe('Webhosting Plus');
});

it('can get all products', function () {
    Product::factory()->count(3)->create();

    $products = $this->repository->all();

    expect($products)->toHaveCount(3);
});

it('can find a product by ID', function () {
    $product = Product::factory()->create();

    $found = $this->repository->find($product->id);

    expect($found)->not()->toBeNull()
        ->and($found->id)->toBe($product->id);
});

it('can update a product', function () {
    $product = Product::factory()->create(['name' => 'Old Name']);

    $updated = $this->repository->update($product, ['name' => 'New Name']);

    expect($updated->name)->toBe('New Name');
});

it('can delete a product', function () {
    $product = Product::factory()->create();

    $result = $this->repository->delete($product);

    expect($result)->toBeTrue()
        ->and(Product::find($product->id))->toBeNull();
});
