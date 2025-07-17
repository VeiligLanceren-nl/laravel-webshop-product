<?php

namespace VeiligLanceren\LaravelWebshopProduct\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Spatie\Sluggable\SlugOptions get(string $key)
 *
 * @see \VeiligLanceren\LaravelWebshopProduct\Services\Seo\SlugConfigService
 */
class SlugConfig extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'slug-config';
    }
}
