<?php

namespace VeiligLanceren\LaravelWebshopProduct;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use VeiligLanceren\LaravelWebshopProduct\Services\Seo\SlugConfigService;
use VeiligLanceren\LaravelWebshopProduct\Services\Product\ProductService;
use VeiligLanceren\LaravelWebshopProduct\Services\Category\CategoryService;
use VeiligLanceren\LaravelWebshopProduct\Services\Product\ProductImageService;
use VeiligLanceren\LaravelWebshopProduct\Services\Product\ProductVariantService;
use VeiligLanceren\LaravelWebshopProduct\Repositories\Product\ProductRepository;
use VeiligLanceren\LaravelWebshopProduct\Repositories\Category\CategoryRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Seo\ISlugConfigService;
use VeiligLanceren\LaravelWebshopProduct\Repositories\Product\ProductImageRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductService;
use VeiligLanceren\LaravelWebshopProduct\Repositories\Product\ProductVariantRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Category\ICategoryService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductImageService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductVariantService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category\ICategoryRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductImageRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductVariantRepository;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/webshop-product.php', 'webshop-product');

        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(IProductImageRepository::class, ProductImageRepository::class);
        $this->app->bind(IProductVariantRepository::class, ProductVariantRepository::class);

        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(ICategoryService::class, CategoryService::class);
        $this->app->bind(ISlugConfigService::class, SlugConfigService::class);
        $this->app->bind(IProductImageService::class, ProductImageService::class);
        $this->app->bind(IProductVariantService::class, ProductVariantService::class);

        $this->app->alias(ISlugConfigService::class, 'slug-config');
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/webshop-product.php' => config_path('webshop-product.php'),
        ], 'webshop-product-config');

        if (is_dir(__DIR__ . '/../database/migrations')) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        if (is_dir(__DIR__ . '/../resources/views')) {
            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'webshop-product');
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'webshop-product');
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/webshop-product'),
        ], 'webshop-product-translations');

        if ($this->app->runningInConsole()) {
            $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        }
    }
}
