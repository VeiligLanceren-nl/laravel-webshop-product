<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductVariant;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductVariantRepository;

beforeEach(function () {
    uses(RefreshDatabase::class);
    $this->repository = app(IProductVariantRepository::class);
});

it('can create a product variant', function () {
    $product = WebshopProduct::factory()->create();
    $data = [
        'name' => 'Variant A',
        'product_id' => $product->id,
        'price' => $product->price
    ];

    $variant = $this->repository->create($data);

    expect($variant)->toBeInstanceOf(WebshopProductVariant::class)
        ->and($variant->name)->toBe('Variant A');
});

it('can fetch all product variants', function () {
    WebshopProductVariant::factory()->count(3)->create();

    $variants = $this->repository->all();

    expect($variants)->toHaveCount(3)
        ->and($variants->first())->toBeInstanceOf(WebshopProductVariant::class);
});

it('can find a product variant by id', function () {
    $variant = WebshopProductVariant::factory()->create();

    $found = $this->repository->find($variant->id);

    expect($found)->not()->toBeNull()
        ->and($found->id)->toBe($variant->id);
});

it('can update a product variant', function () {
    $variant = WebshopProductVariant::factory()->create([
        'name' => 'Old Name',
    ]);

    $updated = $this->repository->update($variant->id, ['name' => 'New Name']);

    expect($updated)->not()->toBeNull()
        ->and($updated->name)->toBe('New Name');
});

it('can delete a product variant', function () {
    $variant = WebshopProductVariant::factory()->create();

    $result = $this->repository->delete($variant->id);

    expect($result)->toBeTrue();
    expect(WebshopProductVariant::find($variant->id))->toBeNull();
});