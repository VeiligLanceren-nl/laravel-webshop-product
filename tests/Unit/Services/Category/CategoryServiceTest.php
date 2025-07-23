<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelMorphCategories\Models\MorphCategory;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Category\ICategoryService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category\ICategoryRepository;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->repository = app(ICategoryRepository::class);
    $this->service = app(ICategoryService::class);
});

it('can create a category', function () {
    $category = $this->service->create([
        'name' => 'Hosting',
        'slug' => 'hosting',
    ]);

    expect($category)->toBeInstanceOf(MorphCategory::class)
        ->and($category->name)->toBe('Hosting');
});

it('can get all categories', function () {
    MorphCategory::factory()->count(3)->create();

    $all = $this->service->all();

    expect($all)->toHaveCount(3);
});

it('can find a category by id', function () {
    $category = MorphCategory::factory()->create();

    $found = $this->service->find($category->id);

    expect($found)->not()->toBeNull()
        ->and($found->id)->toBe($category->id);
});

it('can update a category', function () {
    $category = MorphCategory::factory()->create(['name' => 'Old Name']);

    $updated = $this->service->update($category, ['name' => 'New Name']);

    expect($updated->name)->toBe('New Name');
});

it('can delete a category', function () {
    $category = MorphCategory::factory()->create();

    $result = $this->service->delete($category);

    expect($result)
        ->toBeNull()
        ->and(MorphCategory::find($category->id))
        ->toBeNull();
});
