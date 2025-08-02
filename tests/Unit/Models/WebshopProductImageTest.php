<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProduct;
use VeiligLanceren\LaravelWebshopProduct\Models\WebshopProductImage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    Config::set('webshop-product.images.disk', 'public');
    Config::set('webshop-product.images.storage_prefix', '/storage/');
    Config::set('webshop-product.images.placeholder', 'images/placeholder.jpg');
    Config::set('webshop-product.images.use_full_url', true);
});

it('belongs to a product', function () {
    $product = WebshopProduct::factory()->create();
    $image = WebshopProductImage::factory()->create([
        'webshop_product_id' => $product->id,
    ]);

    expect($image->product)->toBeInstanceOf(WebshopProduct::class)
        ->id->toEqual($product->id);
});

it('returns placeholder when no url is set', function () {
    $image = WebshopProductImage::factory()->create(['url' => '']);

    expect($image->image)->toContain(Config::get('webshop-product.images.placeholder'));
});

it('returns full url when url is already absolute', function () {
    $url = 'https://example.com/image.jpg';
    $image = WebshopProductImage::factory()->create(['url' => $url]);

    expect($image->image)->toEqual($url);
});

it('returns storage url when file exists on disk', function () {
    Storage::disk('public')->put('test.jpg', 'fake content');
    $image = WebshopProductImage::factory()->create(['url' => 'test.jpg']);

    expect($image->image)->toEqual(Storage::disk('public')->url('test.jpg'));
});

it('returns prefixed asset url when file does not exist and use_full_url = true', function () {
    $image = WebshopProductImage::factory()->create(['url' => 'missing.jpg']);

    expect($image->image)->toEqual(asset('/storage/missing.jpg'));
});

it('returns relative prefixed url when file does not exist and use_full_url = false', function () {
    Config::set('webshop-product.images.use_full_url', false);
    $image = WebshopProductImage::factory()->create(['url' => 'missing.jpg']);

    expect($image->image)->toEqual('/storage/missing.jpg');
});
