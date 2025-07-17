<?php

namespace VeiligLanceren\LaravelWebshopProduct\Interfaces\Services\Seo;

use Spatie\Sluggable\SlugOptions;

interface ISlugConfigService
{
    /**
     * @param string $key
     * @return SlugOptions
     */
    public function get(string $key): SlugOptions;
}