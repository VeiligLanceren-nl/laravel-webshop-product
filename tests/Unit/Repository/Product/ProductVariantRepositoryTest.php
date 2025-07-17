<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;
use VeiligLanceren\LaravelWebshopProduct\Models\ProductVariant;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductVariantRepository;

beforeEach(function () {
    uses(RefreshDatabase::class);
    $this->repository = app(IProductVariantRepository::class);
});

it('can create a product variant', function () {
    $product = Product::factory()->create();
    $data = [
        'name' => 'Variant A',
        'product_id' => $product->id,
        'price' => $product->price
    ];

    $variant = $this->repository->create($data);

    expect($variant)->toBeInstanceOf(ProductVariant::class)
        ->and($variant->name)->toBe('Variant A');
});

it('can fetch all product variants', function () {
    ProductVariant::factory()->count(3)->create();

    $variants = $this->repository->all();

    expect($variants)->toHaveCount(3)
        ->and($variants->first())->toBeInstanceOf(ProductVariant::class);
});

it('can find a product variant by id', function () {
    $variant = ProductVariant::factory()->create();

    $found = $this->repository->find($variant->id);

    expect($found)->not()->toBeNull()
        ->and($found->id)->toBe($variant->id);
});

it('can update a product variant', function () {
    $variant = ProductVariant::factory()->create([
        'name' => 'Old Name',
    ]);

    $updated = $this->repository->update($variant->id, ['name' => 'New Name']);

    expect($updated)->not()->toBeNull()
        ->and($updated->name)->toBe('New Name');
});

it('can delete a product variant', function () {
    $variant = ProductVariant::factory()->create();

    $result = $this->repository->delete($variant->id);

    expect($result)->toBeTrue();
    expect(ProductVariant::find($variant->id))->toBeNull();
});