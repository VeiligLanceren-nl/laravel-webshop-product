<?php

use Spatie\Sluggable\SlugOptions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use VeiligLanceren\LaravelWebshopProduct\Facades\SlugConfig;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductOption;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductVariant;

uses(RefreshDatabase::class);

it('can create a product with factory', function () {
    $product = WebshopProduct::factory()->create();

    expect($product)->toBeInstanceOf(WebshopProduct::class)
        ->and($product->id)->not->toBeNull()
        ->and($product->slug)->not->toBeEmpty();
});

it('casts fields correctly', function () {
    $product = WebshopProduct::factory()->create([
        'price' => 123.45,
        'weight' => 7.5,
        'dimensions' => ['length' => 10, 'width' => 20, 'height' => 30],
        'active' => true,
        'featured' => false,
    ]);

    expect($product->price)->toBeString()->toEqual('123.45')
        ->and($product->weight)->toBeString()->toEqual('7.50');
});

it('can manage dimensions with mutators and accessors', function () {
    $product = WebshopProduct::factory()->create();

    $product->length = 15;
    $product->width = 25;
    $product->height = 35;
    $product->save();

    $product->refresh();

    expect($product->length)->toEqual(15.0)
        ->and($product->width)->toEqual(25.0)
        ->and($product->height)->toEqual(35.0);
});

it('has many variants', function () {
    $product = WebshopProduct::factory()->create();
    $variant = WebshopProductVariant::factory()->create(['webshop_product_id' => $product->id]);

    expect($product->variants)->toHaveCount(1)
        ->and($product->variants->first())->toBeInstanceOf(WebshopProductVariant::class);
});

it('has many images ordered by order', function () {
    $product = WebshopProduct::factory()->create();

    $image1 = WebshopProductImage::factory()->create(['webshop_product_id' => $product->id, 'order' => 2]);
    $image2 = WebshopProductImage::factory()->create(['webshop_product_id' => $product->id, 'order' => 1]);

    $images = $product->images;

    expect($images->first()->id)->toEqual($image2->id)
        ->and($images->last()->id)->toEqual($image1->id);
});

it('returns primary image if available', function () {
    $product = WebshopProduct::factory()->create();

    $primary = WebshopProductImage::factory()->create([
        'webshop_product_id' => $product->id,
        'is_primary' => true,
    ]);

    expect($product->primary_image->id)->toEqual($primary->id);
});

it('uses slug as route key name', function () {
    $product = WebshopProduct::factory()->create();

    expect($product->getRouteKeyName())->toEqual('slug');
});

it('uses slug options from SlugConfig facade', function () {
    SlugConfig::shouldReceive('get')
        ->once()
        ->with('category')
        ->andReturn(SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug'));

    $product = new WebshopProduct();

    $options = $product->getSlugOptions();

    expect($options)->toBeInstanceOf(SlugOptions::class);
});

it('has many options', function () {
    $product = WebshopProduct::factory()->create();

    $option = WebshopProductOption::factory()->create([
        'webshop_product_id' => $product->id,
        'name' => 'Printing',
        'additional_price' => 25.00,
    ]);

    expect($product->options)->toHaveCount(1)
        ->and($product->options->first())->toBeInstanceOf(WebshopProductOption::class)
        ->and($product->options->first()->name)->toEqual('Printing');
});

it('calculates total price with selected options', function () {
    $product = WebshopProduct::factory()->create(['price' => 100.00]);

    $options = WebshopProductOption::factory()->count(2)->create([
        'webshop_product_id' => $product->id,
    ]);

    $selectedIds = $options->pluck('id')->toArray();
    $totalPrice = $product->totalPriceWithOptions($selectedIds);

    expect($totalPrice)->toBe(
        $product->price + $options->sum('additional_price')
    );
});

it('returns base price if no options are selected', function () {
    $product = WebshopProduct::factory()->create(['price' => 199.99]);

    $totalPrice = $product->totalPriceWithOptions([]);

    expect($totalPrice)->toBe(199.99);
});

it('stores and retrieves OG and X meta fields', function () {
    $product = WebshopProduct::factory()->create([
        'og_title' => 'OG Product Title',
        'og_description' => 'OG Product Description',
        'og_image' => '/images/og-test.jpg',
        'x_meta_title' => 'X Product Title',
        'x_meta_description' => 'X Product Description',
        'x_meta_image' => '/images/x-test.jpg',
    ]);

    expect($product->og_title)->toEqual('OG Product Title')
        ->and($product->og_description)->toEqual('OG Product Description')
        ->and($product->og_image)->toEqual('/images/og-test.jpg')
        ->and($product->x_meta_title)->toEqual('X Product Title')
        ->and($product->x_meta_description)->toEqual('X Product Description')
        ->and($product->x_meta_image)->toEqual('/images/x-test.jpg');
});