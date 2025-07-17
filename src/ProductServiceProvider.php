<?php

namespace VeiligLanceren\LaravelWebshopProduct;

use Illuminate\Support\ServiceProvider;
use VeiligLanceren\LaravelWebshopProduct\Services\Seo\SlugConfigService;
use VeiligLanceren\LaravelWebshopProduct\Services\Product\ProductService;
use VeiligLanceren\LaravelWebshopProduct\Services\Category\CategoryService;
use VeiligLanceren\LaravelWebshopProduct\Repositories\Product\ProductRepository;
use VeiligLanceren\LaravelWebshopProduct\Repositories\Category\CategoryRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Seo\ISlugConfigService;
use VeiligLanceren\LaravelWebshopProduct\Repositories\Product\ProductImageRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Product\IProductService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Category\ICategoryService;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Category\ICategoryRepository;
use VeiligLanceren\LaravelWebshopProduct\Interfaces\Repositories\Product\IProductImageRepository;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/product.php', 'product');

        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(IProductImageRepository::class, ProductImageRepository::class);

        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(ICategoryService::class, CategoryService::class);
        $this->app->bind(ISlugConfigService::class, SlugConfigService::class);

        $this->app->alias(ISlugConfigService::class, 'slug-config');
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/product.php' => config_path('product.php'),
        ], 'product-config');

        if (is_dir(__DIR__ . '/../database/migrations')) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        if (is_dir(__DIR__ . '/../resources/views')) {
            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'product');
        }

        if ($this->app->runningInConsole()) {
            $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        }
    }
}
