<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Models\Category;
use VeiligLanceren\LaravelWebshopProduct\Support\Traits\HasCategory;

class CategoryableTestModel extends Model
{
    use HasCategory;

    protected $table = 'categoryable_test_models';
    protected $guarded = [];
    public $timestamps = false;
}

beforeEach(function () {
    uses(RefreshDatabase::class);

    Schema::create('categoryable_test_models', function ($table) {
        $table->id();
    });
});

afterEach(function () {
    Schema::drop('categoryables');
    Schema::drop('categories');
    Schema::drop('categoryable_test_models');
});

it('can attach categories', function () {
    $model = CategoryableTestModel::create();
    $cat1 = Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
    $cat2 = Category::create(['name' => 'Cat 2', 'slug' => 'cat-2']);

    $model->attachCategories([$cat1->id, $cat2->id]);

    expect($model->categories()->count())->toBe(2);
    expect($model->categories()->pluck('id'))->toContain($cat1->id, $cat2->id);
});

it('can detach categories', function () {
    $model = CategoryableTestModel::create();
    $cat1 = Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);

    $model->attachCategories($cat1->id);
    $model->detachCategories($cat1->id);

    expect($model->categories()->count())->toBe(0);
});

it('can sync categories', function () {
    $model = CategoryableTestModel::create();
    $cat1 = Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
    $cat2 = Category::create(['name' => 'Cat 2', 'slug' => 'cat-2']);

    $model->syncCategories([$cat1->id]);
    expect($model->categories()->pluck('id'))->toContain($cat1->id);

    $model->syncCategories([$cat2->id]);
    expect($model->categories()->pluck('id'))->toContain($cat2->id);
    expect($model->categories()->pluck('id'))->not->toContain($cat1->id);
});

it('can check category by id, slug, and model', function () {
    $model = CategoryableTestModel::create();
    $cat1 = Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
    $cat2 = Category::create(['name' => 'Cat 2', 'slug' => 'cat-2']);

    $model->attachCategories([$cat1->id, $cat2->id]);

    expect($model->hasCategory($cat1->id))->toBeTrue();
    expect($model->hasCategory($cat1))->toBeTrue();
    expect($model->hasCategory('cat-1'))->toBeTrue();
    expect($model->hasCategory('cat-nonexistent'))->toBeFalse();
    expect($model->hasCategory(999))->toBeFalse();
});