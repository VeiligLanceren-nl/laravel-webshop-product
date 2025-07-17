<?php

namespace VeiligLanceren\LaravelWebshopProduct\Facades;

use Illuminate\Support\Facades\Facade;

class SlugConfig extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'slug-config';
    }
}
