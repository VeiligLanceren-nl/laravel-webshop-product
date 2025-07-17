<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\Product;
use VeiligLanceren\LaravelWebshopProduct\Models\Category;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category\ICategoryRepository;

uses(RefreshDatabase::class);

it('can create and retrieve a category', function () {
    $repo = app(ICategoryRepository::class);

    $category = $repo->create([
        'name' => 'Webhosting',
        'slug' => 'webhosting',
    ]);

    expect($category)
        ->toBeInstanceOf(Category::class)
        ->and($category->name)
        ->toBe('Webhosting');

    $fetched = $repo->find($category->id);
    expect($fetched?->slug)->toBe('webhosting');
});

it('can update a category', function () {
    $repo = app(ICategoryRepository::class);

    $category = Category::factory()->create(['name' => 'Old Name']);

    $updated = $repo->update($category, ['name' => 'New Name']);

    expect($updated->name)->toBe('New Name');
});

it('can assign categories to a model', function () {
    $repo = app(ICategoryRepository::class);

    $product = Product::factory()->create();
    $categories = Category::factory()->count(2)->create();

    $repo->assign($product, $categories->pluck('id')->toArray());

    expect($repo->getForModel($product))->toHaveCount(2);
});

it('can detach categories from a model', function () {
    $repo = app(ICategoryRepository::class);

    $product = Product::factory()->create();
    $categories = Category::factory()->count(2)->create();

    $repo->assign($product, $categories->pluck('id')->toArray());
    $repo->detach($product, $categories[0]->id);

    expect($repo->getForModel($product))->toHaveCount(1);
});
